<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $query = Promotion::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', true)
                          ->where('start_date', '<=', now())
                          ->where('end_date', '>=', now());
                    break;
                case 'scheduled':
                    $query->where('start_date', '>', now());
                    break;
                case 'expired':
                    $query->where('end_date', '<', now());
                    break;
                case 'paused':
                    $query->where('is_active', false);
                    break;
            }
        }

        // Filter by banner status
        if ($request->filled('banner_status')) {
            if ($request->banner_status === 'with_banner') {
                $query->whereNotNull('banner_image');
            } elseif ($request->banner_status === 'active_banner') {
                $query->whereNotNull('banner_image')
                      ->where('banner_is_active', true);
            }
        }

        $promotions = $query->latest()->paginate(15);

        // Get statistics
        $stats = [
            'total' => Promotion::count(),
            'active' => Promotion::where('is_active', true)
                                ->where('start_date', '<=', now())
                                ->where('end_date', '>=', now())
                                ->count(),
            'scheduled' => Promotion::where('start_date', '>', now())->count(),
            'expired' => Promotion::where('end_date', '<', now())->count(),
            'with_banners' => Promotion::whereNotNull('banner_image')->count(),
            'active_banners' => Promotion::whereNotNull('banner_image')
                                       ->where('banner_is_active', true)
                                       ->count(),
        ];

        $types = Promotion::getTypes();
        $bannerPositions = Promotion::getBannerPositions();

        return view('admin.promotions.index', compact('promotions', 'stats', 'types', 'bannerPositions'));
    }

    public function banners()
    {
        // Get all banners grouped by position
        $bannerPositions = Promotion::getBannerPositions();
        $bannersByPosition = [];
        
        foreach ($bannerPositions as $positionKey => $positionName) {
            $bannersByPosition[$positionKey] = Promotion::whereNotNull('banner_image')
                ->where('banner_position', $positionKey)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // Get banner statistics
        $stats = [
            'total_banners' => Promotion::whereNotNull('banner_image')->count(),
            'active_banners' => Promotion::whereNotNull('banner_image')
                ->where('banner_is_active', true)
                ->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->count(),
            'scheduled_banners' => Promotion::whereNotNull('banner_image')
                ->where('start_date', '>', now())
                ->count(),
            'expired_banners' => Promotion::whereNotNull('banner_image')
                ->where('end_date', '<', now())
                ->count(),
        ];

        return view('admin.promotions.banners', compact('bannersByPosition', 'bannerPositions', 'stats'));
    }

    public function create()
    {
        $types = Promotion::getTypes();
        $bannerPositions = Promotion::getBannerPositions();
        $products = Product::active()->get();
        $categories = Category::active()->get();

        return view('admin.promotions.create', compact('types', 'bannerPositions', 'products', 'categories'));
    }

    public function store(Request $request)
    {
        // Log the incoming request data
        \Log::info('Promotion creation request received', [
            'request_data' => $request->all(),
            'files' => $request->hasFile('banner_image') ? 'Has banner image' : 'No banner image'
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:promotions,code',
            'description' => 'nullable|string',
            'type' => 'required|in:' . implode(',', array_keys(Promotion::getTypes())),
            'discount_value' => 'required|numeric|min:0',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'required|integer|min:1',
            'applicable_products' => 'nullable|array',
            'applicable_products.*' => 'exists:products,id',
            'applicable_categories' => 'nullable|array',
            'applicable_categories.*' => 'exists:categories,id',
            'excluded_products' => 'nullable|array',
            'excluded_products.*' => 'exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'is_first_time_only' => 'boolean',
            'is_new_customer_only' => 'boolean',
            
            // Banner fields
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_title' => 'nullable|string|max:255',
            'banner_subtitle' => 'nullable|string|max:255',
            'banner_link' => 'nullable|url',
            'banner_position' => 'nullable|in:' . implode(',', array_keys(Promotion::getBannerPositions())),
            'banner_is_active' => 'boolean',
        ]);

        // Generate code if not provided
        if (empty($validated['code'])) {
            do {
                $code = strtoupper(Str::random(8));
            } while (Promotion::where('code', $code)->exists());
            $validated['code'] = $code;
        }

        // Log the validated data before creation
        \Log::info('Validated data before promotion creation', [
            'validated_data' => $validated,
            'banner_position' => $validated['banner_position'] ?? 'not set'
        ]);

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('promotions/banners', 'public');
        }

        // Convert arrays to JSON
        $validated['applicable_products'] = $validated['applicable_products'] ?? null;
        $validated['applicable_categories'] = $validated['applicable_categories'] ?? null;
        $validated['excluded_products'] = $validated['excluded_products'] ?? null;

        try {
            // Log the data being saved
            \Log::info('Attempting to create promotion', [
                'validated_data' => $validated,
                'request_data' => $request->all()
            ]);

            $promotion = Promotion::create($validated);
            
            \Log::info('Promotion created successfully', [
                'promotion_id' => $promotion->id,
                'name' => $promotion->name,
                'code' => $promotion->code,
                'banner_position' => $promotion->banner_position
            ]);

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Promotion created successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to create promotion', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validated
            ]);
            
            return back()->withInput()->withErrors(['error' => 'Failed to create promotion: ' . $e->getMessage()]);
        }
    }

    public function show(Promotion $promotion)
    {
        $promotion->load(['orders', 'applicableProducts', 'applicableCategories']);
        
        return view('admin.promotions.show', compact('promotion'));
    }

    public function edit(Promotion $promotion)
    {
        $types = Promotion::getTypes();
        $bannerPositions = Promotion::getBannerPositions();
        $products = Product::active()->get();
        $categories = Category::active()->get();

        return view('admin.promotions.edit', compact('promotion', 'types', 'bannerPositions', 'products', 'categories'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:promotions,code,' . $promotion->id,
            'description' => 'nullable|string',
            'type' => 'required|in:' . implode(',', array_keys(Promotion::getTypes())),
            'discount_value' => 'required|numeric|min:0',
            'minimum_order_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'required|integer|min:1',
            'applicable_products' => 'nullable|array',
            'applicable_products.*' => 'exists:products,id',
            'applicable_categories' => 'nullable|array',
            'applicable_categories.*' => 'exists:categories,id',
            'excluded_products' => 'nullable|array',
            'excluded_products.*' => 'exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'is_first_time_only' => 'boolean',
            'is_new_customer_only' => 'boolean',
            
            // Banner fields
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner_title' => 'nullable|string|max:255',
            'banner_subtitle' => 'nullable|string|max:255',
            'banner_link' => 'nullable|url',
            'banner_position' => 'nullable|in:' . implode(',', array_keys(Promotion::getBannerPositions())),
            'banner_is_active' => 'boolean',
        ]);

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old image
            if ($promotion->banner_image) {
                Storage::disk('public')->delete($promotion->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('promotions/banners', 'public');
        }

        // Convert arrays to JSON
        $validated['applicable_products'] = $validated['applicable_products'] ?? null;
        $validated['applicable_categories'] = $validated['applicable_categories'] ?? null;
        $validated['excluded_products'] = $validated['excluded_products'] ?? null;

        $promotion->update($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion updated successfully.');
    }

    public function destroy(Promotion $promotion)
    {
        // Delete banner image
        if ($promotion->banner_image) {
            Storage::disk('public')->delete($promotion->banner_image);
        }

        $promotion->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Promotion deleted successfully.'
            ]);
        }

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promotion deleted successfully.');
    }

    public function toggleStatus(Promotion $promotion)
    {
        $promotion->update(['is_active' => !$promotion->is_active]);

        $status = $promotion->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.promotions.index')
            ->with('success', "Promotion {$status} successfully.");
    }

    public function toggleBannerStatus(Promotion $promotion)
    {
        $promotion->update(['banner_is_active' => !$promotion->banner_is_active]);

        $status = $promotion->banner_is_active ? 'activated' : 'deactivated';
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Banner {$status} successfully.",
                'banner_is_active' => $promotion->banner_is_active
            ]);
        }
        
        return redirect()->route('admin.promotions.index')
            ->with('success', "Banner {$status} successfully.");
    }

    public function duplicate(Promotion $promotion)
    {
        $newPromotion = $promotion->replicate();
        $newPromotion->name = $promotion->name . ' (Copy)';
        $newPromotion->code = strtoupper(Str::random(8));
        $newPromotion->used_count = 0;
        $newPromotion->is_active = false;
        $newPromotion->banner_is_active = false;
        $newPromotion->save();

        return redirect()->route('admin.promotions.edit', $newPromotion)
            ->with('success', 'Promotion duplicated successfully. Please review and update the details.');
    }

    public function analytics()
    {
        // Get promotion performance data
        $promotionStats = DB::table('promotions')
            ->selectRaw('
                promotions.id,
                promotions.name,
                promotions.code,
                promotions.used_count,
                promotions.usage_limit,
                COUNT(orders.id) as total_orders,
                SUM(orders.total_amount) as total_revenue
            ')
            ->leftJoin('orders', 'promotions.id', '=', 'orders.promotion_id')
            ->groupBy('promotions.id', 'promotions.name', 'promotions.code', 'promotions.used_count', 'promotions.usage_limit')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Get banner performance data
        $bannerStats = Promotion::whereNotNull('banner_image')
            ->select('id', 'name', 'banner_title', 'banner_position', 'banner_is_active', 'used_count')
            ->orderBy('used_count', 'desc')
            ->get();

        return view('admin.promotions.analytics', compact('promotionStats', 'bannerStats'));
    }

    public function export()
    {
        $promotions = Promotion::all();
        
        $filename = 'promotions_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($promotions) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID', 'Name', 'Code', 'Type', 'Discount Value', 'Usage Count', 
                'Usage Limit', 'Status', 'Start Date', 'End Date', 'Banner Active'
            ]);

            // Add data
            foreach ($promotions as $promotion) {
                fputcsv($file, [
                    $promotion->id,
                    $promotion->name,
                    $promotion->code,
                    $promotion->type,
                    $promotion->discount_value,
                    $promotion->used_count,
                    $promotion->usage_limit,
                    $promotion->status,
                    $promotion->start_date->format('Y-m-d'),
                    $promotion->end_date->format('Y-m-d'),
                    $promotion->banner_is_active ? 'Yes' : 'No'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
