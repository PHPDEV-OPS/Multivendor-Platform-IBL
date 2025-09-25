<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Auth::user();

        // Get date range from request or default to last 30 days
        $period = $request->get('period', '30');
        $startDate = $this->getStartDate($period);
        $endDate = now();

        // Get analytics data
        $analytics = $this->getAnalyticsData($vendor->id, $startDate, $endDate);
        $previousAnalytics = $this->getPreviousAnalyticsData($vendor->id, $startDate, $endDate);
        $chartData = $this->getChartData($vendor->id, $startDate, $endDate);
        $topProducts = $this->getTopProducts($vendor->id, $startDate, $endDate);
        $categoryData = $this->getCategoryData($vendor->id, $startDate, $endDate);
        $recentActivity = $this->getRecentActivity($vendor->id);

        return view('vendor.analytics', compact(
            'analytics',
            'previousAnalytics',
            'chartData',
            'topProducts',
            'categoryData',
            'recentActivity',
            'period'
        ));
    }

    private function getStartDate($period)
    {
        switch ($period) {
            case '7':
                return now()->subDays(7);
            case '30':
                return now()->subDays(30);
            case '90':
                return now()->subDays(90);
            case '180':
                return now()->subDays(180);
            case '365':
                return now()->subDays(365);
            default:
                return now()->subDays(30);
        }
    }

    private function getAnalyticsData($vendorId, $startDate, $endDate)
    {
        // Revenue from paid orders only
        $totalRevenue = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('vendor_amount');

        // Total paid orders
        $totalOrders = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Products sold (quantity)
        $productsSold = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('items')
            ->get()
            ->sum(function ($order) {
                return $order->items->sum('quantity');
            });

        // Average rating
        $averageRating = Product::where('vendor_id', $vendorId)
            ->where('rating', '>', 0)
            ->avg('rating');
        $averageRating = $averageRating ?: 0;

        // Average order value
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Conversion rate (orders vs product views - simplified)
        $totalViews = Product::where('vendor_id', $vendorId)->sum('view_count') ?: 1;
        $conversionRate = ($totalOrders / $totalViews) * 100;

        return [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'products_sold' => $productsSold,
            'average_rating' => round($averageRating, 1),
            'average_order_value' => $averageOrderValue,
            'conversion_rate' => round($conversionRate, 2),
        ];
    }

    private function getPreviousAnalyticsData($vendorId, $startDate, $endDate)
    {
        $periodLength = $endDate->diffInDays($startDate);
        $previousStartDate = $startDate->copy()->subDays($periodLength);
        $previousEndDate = $startDate->copy();

        return $this->getAnalyticsData($vendorId, $previousStartDate, $previousEndDate);
    }

    private function getChartData($vendorId, $startDate, $endDate)
    {
        $days = [];
        $revenues = [];
        $orders = [];

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $dayRevenue = Order::where('vendor_id', $vendorId)
                ->where('payment_status', 'paid')
                ->whereDate('created_at', $currentDate)
                ->sum('vendor_amount');

            $dayOrders = Order::where('vendor_id', $vendorId)
                ->where('payment_status', 'paid')
                ->whereDate('created_at', $currentDate)
                ->count();

            $days[] = $currentDate->format('M d');
            $revenues[] = $dayRevenue;
            $orders[] = $dayOrders;

            $currentDate->addDay();
        }

        return [
            'days' => $days,
            'revenues' => $revenues,
            'orders' => $orders,
        ];
    }

    private function getTopProducts($vendorId, $startDate, $endDate)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.vendor_id', $vendorId)
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'products.name',
                'products.price',
                'products.main_image',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.total_price) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.price', 'products.main_image')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();
    }

    private function getCategoryData($vendorId, $startDate, $endDate)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.vendor_id', $vendorId)
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'categories.name',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.total_price) as total_revenue')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_revenue', 'desc')
            ->get();
    }

    private function getRecentActivity($vendorId)
    {
        $activities = collect();

        // Recent orders
        $recentOrders = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        foreach ($recentOrders as $order) {
            $activities->push([
                'type' => 'order',
                'title' => 'New Order',
                'description' => "Order {$order->order_number} from " . ($order->user ? $order->user->name : 'Customer'),
                'impact' => '+KES ' . number_format($order->vendor_amount, 0),
                'time' => $order->created_at->diffForHumans(),
                'created_at' => $order->created_at,
            ]);
        }

        // Recent product views (if tracking exists)
        $recentViews = Product::where('vendor_id', $vendorId)
            ->where('view_count', '>', 0)
            ->orderBy('updated_at', 'desc')
            ->take(3)
            ->get();

        foreach ($recentViews as $product) {
            $activities->push([
                'type' => 'view',
                'title' => 'Product Viewed',
                'description' => "Product '{$product->name}' was viewed",
                'impact' => $product->view_count . ' total views',
                'time' => $product->updated_at->diffForHumans(),
                'created_at' => $product->updated_at,
            ]);
        }

        return $activities->sortByDesc('created_at')->take(10);
    }

    public function export(Request $request)
    {
        $vendor = Auth::user();
        $period = $request->get('period', '30');
        $startDate = $this->getStartDate($period);
        $endDate = now();

        $analytics = $this->getAnalyticsData($vendor->id, $startDate, $endDate);
        $topProducts = $this->getTopProducts($vendor->id, $startDate, $endDate);

        $filename = 'vendor_analytics_' . $vendor->id . '_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($analytics, $topProducts, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            // Analytics summary
            fputcsv($file, ['Vendor Analytics Report']);
            fputcsv($file, ['Period', $startDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d')]);
            fputcsv($file, []);

            fputcsv($file, ['Metric', 'Value']);
            fputcsv($file, ['Total Revenue', 'KES ' . number_format($analytics['total_revenue'], 2)]);
            fputcsv($file, ['Total Orders', $analytics['total_orders']]);
            fputcsv($file, ['Products Sold', $analytics['products_sold']]);
            fputcsv($file, ['Average Rating', $analytics['average_rating']]);
            fputcsv($file, ['Average Order Value', 'KES ' . number_format($analytics['average_order_value'], 2)]);
            fputcsv($file, ['Conversion Rate', $analytics['conversion_rate'] . '%']);
            fputcsv($file, []);

            // Top products
            fputcsv($file, ['Top Products']);
            fputcsv($file, ['Product Name', 'Units Sold', 'Revenue']);
            foreach ($topProducts as $product) {
                fputcsv($file, [
                    $product->name,
                    $product->total_sold,
                    'KES ' . number_format($product->total_revenue, 2)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
