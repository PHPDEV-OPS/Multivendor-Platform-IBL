<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PromotionsController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Auth::user();
        
        // Get vendor's promotions (for now, show all active promotions since promotions are global)
        // In the future, you might want to add vendor_id to promotions table for vendor-specific promotions
        $query = Promotion::query();
        
        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->active();
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
        
        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $promotions = $query->latest()->paginate(10);
        
        // Get promotion statistics
        $stats = $this->getPromotionStats($vendor->id);
        
        // Get vendor's products that can be promoted
        $vendorProducts = Product::where('vendor_id', $vendor->id)->active()->get();
        
        // Get categories that vendor's products belong to
        $vendorCategories = Category::whereHas('products', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })->get();
        
        return view('vendor.promotions', compact(
            'promotions',
            'stats',
            'vendorProducts',
            'vendorCategories'
        ));
    }
    
    private function getPromotionStats($vendorId)
    {
        // Get vendor's orders that used promotions
        $vendorOrdersWithPromotions = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereNotNull('promotion_code')
            ->get();
        
        // Calculate revenue from promotions
        $revenueFromPromotions = $vendorOrdersWithPromotions->sum('vendor_amount');
        
        // Get active promotions count
        $activePromotions = Promotion::active()->count();
        
        // Get total promotions count
        $totalPromotions = Promotion::count();
        
        // Get promotions that apply to vendor's products
        $applicablePromotions = Promotion::where(function($query) use ($vendorId) {
            // Promotions with no specific products (apply to all)
            $query->whereNull('applicable_products')
                  ->whereNull('applicable_categories');
        })->orWhere(function($query) use ($vendorId) {
            // Promotions that include vendor's products
            $vendorProductIds = Product::where('vendor_id', $vendorId)->pluck('id')->toArray();
            $query->where(function($q) use ($vendorProductIds) {
                foreach ($vendorProductIds as $productId) {
                    $q->orWhereJsonContains('applicable_products', $productId);
                }
            });
        })->orWhere(function($query) use ($vendorId) {
            // Promotions that include vendor's categories
            $vendorCategoryIds = Category::whereHas('products', function($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->pluck('id')->toArray();
            
            $query->where(function($q) use ($vendorCategoryIds) {
                foreach ($vendorCategoryIds as $categoryId) {
                    $q->orWhereJsonContains('applicable_categories', $categoryId);
                }
            });
        })->count();
        
        // Get orders count that used promotions
        $ordersWithPromotions = $vendorOrdersWithPromotions->count();
        
        return [
            'total_promotions' => $totalPromotions,
            'active_promotions' => $activePromotions,
            'applicable_promotions' => $applicablePromotions,
            'revenue_from_promotions' => $revenueFromPromotions,
            'orders_with_promotions' => $ordersWithPromotions,
            'average_discount_per_order' => $ordersWithPromotions > 0 
                ? $vendorOrdersWithPromotions->avg('discount_amount') 
                : 0,
        ];
    }
    
    public function show(Promotion $promotion)
    {
        $vendor = Auth::user();
        
        // Get vendor's orders that used this promotion
        $vendorOrdersWithPromotion = Order::where('vendor_id', $vendor->id)
            ->where('payment_status', 'paid')
            ->where('promotion_code', $promotion->code)
            ->with(['user', 'items.product'])
            ->latest()
            ->take(10)
            ->get();
        
        // Calculate promotion performance for this vendor
        $performance = [
            'total_orders' => $vendorOrdersWithPromotion->count(),
            'total_revenue' => $vendorOrdersWithPromotion->sum('vendor_amount'),
            'total_discount' => $vendorOrdersWithPromotion->sum('discount_amount'),
            'average_order_value' => $vendorOrdersWithPromotion->avg('vendor_amount'),
        ];
        
        return view('vendor.promotions.show', compact(
            'promotion',
            'vendorOrdersWithPromotion',
            'performance'
        ));
    }
    
    public function analytics(Request $request)
    {
        $vendor = Auth::user();
        $period = $request->get('period', '30');
        
        $startDate = match($period) {
            '7' => now()->subDays(7),
            '30' => now()->subDays(30),
            '90' => now()->subDays(90),
            default => now()->subDays(30),
        };
        
        // Get promotion analytics for vendor
        $analytics = $this->getPromotionAnalytics($vendor->id, $startDate, now());
        
        return view('vendor.promotions.analytics', compact('analytics', 'period'));
    }
    
    private function getPromotionAnalytics($vendorId, $startDate, $endDate)
    {
        // Get orders with promotions in the period
        $ordersWithPromotions = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereNotNull('promotion_code')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        
        // Get orders without promotions for comparison
        $ordersWithoutPromotions = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereNull('promotion_code')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        
        // Calculate metrics
        $totalOrders = $ordersWithPromotions->count() + $ordersWithoutPromotions->count();
        $promotionUsageRate = $totalOrders > 0 ? ($ordersWithPromotions->count() / $totalOrders) * 100 : 0;
        
        // Top performing promotions
        $topPromotions = $ordersWithPromotions->groupBy('promotion_code')
            ->map(function ($orders, $code) {
                return [
                    'code' => $code,
                    'orders_count' => $orders->count(),
                    'revenue' => $orders->sum('vendor_amount'),
                    'discount_given' => $orders->sum('discount_amount'),
                ];
            })
            ->sortByDesc('revenue')
            ->take(5);
        
        return [
            'total_orders_with_promotions' => $ordersWithPromotions->count(),
            'total_orders_without_promotions' => $ordersWithoutPromotions->count(),
            'promotion_usage_rate' => $promotionUsageRate,
            'revenue_with_promotions' => $ordersWithPromotions->sum('vendor_amount'),
            'revenue_without_promotions' => $ordersWithoutPromotions->sum('vendor_amount'),
            'total_discount_given' => $ordersWithPromotions->sum('discount_amount'),
            'average_order_with_promotion' => $ordersWithPromotions->avg('vendor_amount'),
            'average_order_without_promotion' => $ordersWithoutPromotions->avg('vendor_amount'),
            'top_promotions' => $topPromotions,
        ];
    }
    
    public function export(Request $request)
    {
        $vendor = Auth::user();
        
        // Get vendor's promotion performance data
        $ordersWithPromotions = Order::where('vendor_id', $vendor->id)
            ->where('payment_status', 'paid')
            ->whereNotNull('promotion_code')
            ->with(['user'])
            ->latest()
            ->get();
        
        $filename = 'vendor_promotions_report_' . $vendor->id . '_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($ordersWithPromotions) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Order Number',
                'Customer Name',
                'Promotion Code',
                'Order Total',
                'Discount Amount',
                'Vendor Amount',
                'Order Date'
            ]);

            // CSV data
            foreach ($ordersWithPromotions as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->user ? $order->user->name : 'N/A',
                    $order->promotion_code,
                    'KES ' . number_format($order->total_amount, 0),
                    'KES ' . number_format($order->discount_amount, 0),
                    'KES ' . number_format($order->vendor_amount, 0),
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
