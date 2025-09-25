<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $vendor = Auth::user();

        // Get vendor statistics
        $stats = $this->getVendorStats($vendor->id);

        // Get recent orders
        $recentOrders = $this->getRecentOrders($vendor->id);

        // Get top products
        $topProducts = $this->getTopProducts($vendor->id);

        // Get monthly analytics
        $monthlyStats = $this->getMonthlyStats($vendor->id);

        // Get recent activity
        $recentActivity = $this->getRecentActivity($vendor->id);

        return view('vendor.dashboard', compact(
            'stats',
            'recentOrders',
            'topProducts',
            'monthlyStats',
            'recentActivity'
        ));
    }

    private function getVendorStats($vendorId)
    {
        // Total revenue (vendor amount from paid orders only)
        $totalRevenue = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->sum('vendor_amount');

        // Total paid orders (only count paid orders)
        $totalOrders = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->count();

        // Total products
        $totalProducts = Product::where('vendor_id', $vendorId)->count();

        // Active products
        $activeProducts = Product::where('vendor_id', $vendorId)
            ->where('status', 'active')
            ->count();

        // Average rating
        $averageRating = Product::where('vendor_id', $vendorId)
            ->where('rating', '>', 0)
            ->avg('rating') ?? 0;

        // Total items sold (from paid orders only)
        $totalItemsSold = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->with('items')
            ->get()
            ->sum(function ($order) {
                return $order->items->sum('quantity');
            });

        // Pending orders count
        $pendingOrders = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->where('status', 'pending')
            ->count();

        // Processing orders count
        $processingOrders = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->where('status', 'processing')
            ->count();

        return [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'total_products' => $totalProducts,
            'active_products' => $activeProducts,
            'average_rating' => round($averageRating, 1),
            'total_items_sold' => $totalItemsSold,
            'pending_orders' => $pendingOrders,
            'processing_orders' => $processingOrders,
        ];
    }

    private function getRecentOrders($vendorId)
    {
        return Order::with(['user', 'items.product'])
            ->where('vendor_id', $vendorId)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                $firstItem = $order->items->first();
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->user->name ?? 'Unknown Customer',
                    'product_name' => $firstItem && $firstItem->product ? $firstItem->product->name : 'N/A',
                    'amount' => $order->total_amount,
                    'status' => $order->status,
                    'date' => $order->created_at->format('Y-m-d'),
                    'status_badge_class' => $order->status_badge_class,
                ];
            });
    }

    private function getTopProducts($vendorId)
    {
        return Product::where('vendor_id', $vendorId)
            ->where('sold_count', '>', 0)
            ->orderBy('sold_count', 'desc')
            ->take(3)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'sales' => $product->sold_count,
                    'price' => $product->final_price,
                ];
            });
    }

    private function getMonthlyStats($vendorId)
    {
        $currentMonth = now()->format('Y-m');

        // Monthly revenue
        $monthlyRevenue = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('vendor_amount');

        // Monthly orders
        $monthlyOrders = Order::where('vendor_id', $vendorId)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        // Monthly products sold
        $monthlyProductsSold = Order::where('vendor_id', $vendorId)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->with('items')
            ->get()
            ->sum(function ($order) {
                return $order->items->sum('quantity');
            });

        // Monthly average rating
        $monthlyRating = Product::where('vendor_id', $vendorId)
            ->where('rating', '>', 0)
            ->whereYear('updated_at', now()->year)
            ->whereMonth('updated_at', now()->month)
            ->avg('rating') ?? 0;

        return [
            'revenue' => $monthlyRevenue,
            'orders' => $monthlyOrders,
            'products_sold' => $monthlyProductsSold,
            'rating' => round($monthlyRating, 1),
        ];
    }

    private function getRecentActivity($vendorId)
    {
        $activities = collect();

        // Recent orders
        $recentOrders = Order::where('vendor_id', $vendorId)
            ->latest()
            ->take(3)
            ->get();

        foreach ($recentOrders as $order) {
            $activities->push([
                'type' => 'order',
                'icon' => 'fas fa-shopping-cart',
                'icon_bg' => 'bg-success',
                'title' => 'New order received',
                'description' => "Order {$order->order_number} from customer " . ($order->user->name ?? 'Unknown') . " for KSh " . number_format($order->total_amount, 0),
                'time' => $order->created_at->diffForHumans(),
                'created_at' => $order->created_at,
            ]);
        }

        // Recent reviews
        $recentReviews = Review::whereHas('product', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })
        ->with('product')
        ->latest()
        ->take(3)
        ->get();

        foreach ($recentReviews as $review) {
            $activities->push([
                'type' => 'review',
                'icon' => 'fas fa-star',
                'icon_bg' => 'bg-primary',
                'title' => 'New review received',
                'description' => "{$review->rating}-star review for \"{$review->product->name}\"",
                'time' => $review->created_at->diffForHumans(),
                'created_at' => $review->created_at,
            ]);
        }

        // Low stock alerts
        $lowStockProducts = Product::where('vendor_id', $vendorId)
            ->where('stock_quantity', '<=', DB::raw('min_stock_alert'))
            ->where('stock_quantity', '>', 0)
            ->latest()
            ->take(2)
            ->get();

        foreach ($lowStockProducts as $product) {
            $activities->push([
                'type' => 'stock',
                'icon' => 'fas fa-box',
                'icon_bg' => 'bg-warning',
                'title' => 'Product stock low',
                'description' => "\"{$product->name}\" stock is running low ({$product->stock_quantity} items left)",
                'time' => $product->updated_at->diffForHumans(),
                'created_at' => $product->updated_at,
            ]);
        }

        // Sort by creation date and take the most recent 4
        return $activities->sortByDesc('created_at')->take(4);
    }
}
