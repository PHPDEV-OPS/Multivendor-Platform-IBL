<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Auth::user();
        
        // Get filters from request
        $reportType = $request->get('report_type', 'sales');
        $dateRange = $request->get('date_range', 'last30days');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        // Calculate date range
        $dates = $this->calculateDateRange($dateRange, $startDate, $endDate);
        
        // Get report data based on type
        $reportData = $this->getReportData($vendor->id, $reportType, $dates['start'], $dates['end']);
        
        // Get vendor categories for filter
        $categories = $this->getVendorCategories($vendor->id);
        
        return view('vendor.reports', compact(
            'reportData',
            'categories',
            'reportType',
            'dateRange',
            'startDate',
            'endDate'
        ));
    }

    private function calculateDateRange($dateRange, $startDate = null, $endDate = null)
    {
        $end = now();
        
        switch ($dateRange) {
            case 'today':
                $start = now()->startOfDay();
                break;
            case 'yesterday':
                $start = now()->subDay()->startOfDay();
                $end = now()->subDay()->endOfDay();
                break;
            case 'last7days':
                $start = now()->subDays(7);
                break;
            case 'last30days':
                $start = now()->subDays(30);
                break;
            case 'last90days':
                $start = now()->subDays(90);
                break;
            case 'custom':
                $start = $startDate ? \Carbon\Carbon::parse($startDate) : now()->subDays(30);
                $end = $endDate ? \Carbon\Carbon::parse($endDate) : now();
                break;
            default:
                $start = now()->subDays(30);
        }
        
        return ['start' => $start, 'end' => $end];
    }

    private function getReportData($vendorId, $reportType, $startDate, $endDate)
    {
        switch ($reportType) {
            case 'sales':
                return $this->getSalesReport($vendorId, $startDate, $endDate);
            case 'products':
                return $this->getProductsReport($vendorId, $startDate, $endDate);
            case 'customers':
                return $this->getCustomersReport($vendorId, $startDate, $endDate);
            case 'inventory':
                return $this->getInventoryReport($vendorId);
            case 'revenue':
                return $this->getRevenueReport($vendorId, $startDate, $endDate);
            default:
                return $this->getSalesReport($vendorId, $startDate, $endDate);
        }
    }

    private function getSalesReport($vendorId, $startDate, $endDate)
    {
        // Summary stats
        $totalRevenue = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('vendor_amount');

        $totalOrders = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $totalItems = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('items')
            ->get()
            ->sum(function ($order) {
                return $order->items->sum('quantity');
            });

        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Recent orders
        $recentOrders = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['user', 'items.product'])
            ->latest()
            ->take(10)
            ->get();

        return [
            'type' => 'sales',
            'summary' => [
                'total_revenue' => $totalRevenue,
                'total_orders' => $totalOrders,
                'total_items' => $totalItems,
                'average_order_value' => $averageOrderValue,
            ],
            'orders' => $recentOrders,
        ];
    }

    private function getProductsReport($vendorId, $startDate, $endDate)
    {
        // Top selling products
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.vendor_id', $vendorId)
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'products.name',
                'products.price',
                'products.stock_quantity',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.total_price) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.price', 'products.stock_quantity')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        // Product performance summary
        $totalProducts = Product::where('vendor_id', $vendorId)->count();
        $activeProducts = Product::where('vendor_id', $vendorId)->where('status', 'active')->count();
        $lowStockProducts = Product::where('vendor_id', $vendorId)
            ->where('stock_quantity', '<=', DB::raw('min_stock_alert'))
            ->count();

        return [
            'type' => 'products',
            'summary' => [
                'total_products' => $totalProducts,
                'active_products' => $activeProducts,
                'low_stock_products' => $lowStockProducts,
                'products_sold' => $topProducts->sum('total_sold'),
            ],
            'top_products' => $topProducts,
        ];
    }

    private function getCustomersReport($vendorId, $startDate, $endDate)
    {
        // Customer analytics
        $totalCustomers = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->distinct('user_id')
            ->count();

        $repeatCustomers = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('user_id', DB::raw('COUNT(*) as order_count'))
            ->groupBy('user_id')
            ->having('order_count', '>', 1)
            ->count();

        // Top customers
        $topCustomers = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('user')
            ->select('user_id', DB::raw('COUNT(*) as order_count'), DB::raw('SUM(vendor_amount) as total_spent'))
            ->groupBy('user_id')
            ->orderBy('total_spent', 'desc')
            ->take(10)
            ->get();

        return [
            'type' => 'customers',
            'summary' => [
                'total_customers' => $totalCustomers,
                'repeat_customers' => $repeatCustomers,
                'new_customers' => $totalCustomers - $repeatCustomers,
                'retention_rate' => $totalCustomers > 0 ? ($repeatCustomers / $totalCustomers) * 100 : 0,
            ],
            'top_customers' => $topCustomers,
        ];
    }

    private function getInventoryReport($vendorId)
    {
        // Inventory status
        $products = Product::where('vendor_id', $vendorId)
            ->select('name', 'sku', 'stock_quantity', 'min_stock_alert', 'price', 'status')
            ->orderBy('stock_quantity', 'asc')
            ->get();

        $totalValue = $products->sum(function ($product) {
            return $product->stock_quantity * $product->price;
        });

        $lowStockCount = $products->where('stock_quantity', '<=', function ($product) {
            return $product->min_stock_alert;
        })->count();

        return [
            'type' => 'inventory',
            'summary' => [
                'total_products' => $products->count(),
                'total_value' => $totalValue,
                'low_stock_count' => $lowStockCount,
                'out_of_stock' => $products->where('stock_quantity', 0)->count(),
            ],
            'products' => $products,
        ];
    }

    private function getRevenueReport($vendorId, $startDate, $endDate)
    {
        // Daily revenue breakdown
        $dailyRevenue = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(vendor_amount) as revenue'),
                DB::raw('COUNT(*) as orders')
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        $totalRevenue = $dailyRevenue->sum('revenue');
        $totalOrders = $dailyRevenue->sum('orders');

        return [
            'type' => 'revenue',
            'summary' => [
                'total_revenue' => $totalRevenue,
                'total_orders' => $totalOrders,
                'average_daily_revenue' => $dailyRevenue->count() > 0 ? $totalRevenue / $dailyRevenue->count() : 0,
                'best_day_revenue' => $dailyRevenue->max('revenue'),
            ],
            'daily_revenue' => $dailyRevenue,
        ];
    }

    private function getVendorCategories($vendorId)
    {
        return Category::whereHas('products', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })->get();
    }

    public function export(Request $request)
    {
        $vendor = Auth::user();
        $reportType = $request->get('report_type', 'sales');
        $dateRange = $request->get('date_range', 'last30days');
        
        $dates = $this->calculateDateRange($dateRange, $request->get('start_date'), $request->get('end_date'));
        $reportData = $this->getReportData($vendor->id, $reportType, $dates['start'], $dates['end']);

        $filename = "vendor_{$reportType}_report_" . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($reportData, $reportType) {
            $file = fopen('php://output', 'w');
            
            // Add report header
            fputcsv($file, [ucfirst($reportType) . ' Report']);
            fputcsv($file, ['Generated on: ' . now()->format('Y-m-d H:i:s')]);
            fputcsv($file, []);
            
            // Add summary
            fputcsv($file, ['Summary']);
            foreach ($reportData['summary'] as $key => $value) {
                fputcsv($file, [ucfirst(str_replace('_', ' ', $key)), $value]);
            }
            fputcsv($file, []);
            
            // Add detailed data based on report type
            if ($reportType === 'sales' && isset($reportData['orders'])) {
                fputcsv($file, ['Order Details']);
                fputcsv($file, ['Order Number', 'Customer', 'Amount', 'Items', 'Date']);
                foreach ($reportData['orders'] as $order) {
                    fputcsv($file, [
                        $order->order_number,
                        $order->user ? $order->user->name : 'N/A',
                        $order->vendor_amount,
                        $order->items->sum('quantity'),
                        $order->created_at->format('Y-m-d H:i:s')
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
