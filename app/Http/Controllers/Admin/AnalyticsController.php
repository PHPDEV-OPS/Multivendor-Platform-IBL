<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        // Get date range
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Revenue analytics
        $revenueData = $this->getRevenueData($startDate, $endDate);
        
        // Order analytics
        $orderData = $this->getOrderData($startDate, $endDate);
        
        // Customer analytics
        $customerData = $this->getCustomerData($startDate, $endDate);
        
        // Product analytics
        $productData = $this->getProductData($startDate, $endDate);

        return view('admin.analytics', compact(
            'revenueData', 
            'orderData', 
            'customerData', 
            'productData',
            'startDate',
            'endDate'
        ));
    }

    private function getRevenueData($startDate, $endDate)
    {
        $dailyRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'total' => $dailyRevenue->sum('revenue'),
            'average' => $dailyRevenue->avg('revenue'),
            'daily' => $dailyRevenue,
        ];
    }

    private function getOrderData($startDate, $endDate)
    {
        $dailyOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $statusBreakdown = Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return [
            'total' => $dailyOrders->sum('count'),
            'average' => $dailyOrders->avg('count'),
            'daily' => $dailyOrders,
            'status_breakdown' => $statusBreakdown,
        ];
    }

    private function getCustomerData($startDate, $endDate)
    {
        $newCustomers = User::where('role', 'user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalCustomers = User::where('role', 'user')->count();
        $activeCustomers = User::where('role', 'user')->where('is_active', true)->count();

        return [
            'total' => $totalCustomers,
            'active' => $activeCustomers,
            'new' => $newCustomers->sum('count'),
            'daily_new' => $newCustomers,
        ];
    }

    private function getProductData($startDate, $endDate)
    {
        $topProducts = Product::with('vendor')
            ->orderBy('sold_count', 'desc')
            ->take(10)
            ->get();

        $topCategories = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, COUNT(*) as product_count, SUM(products.sold_count) as total_sales')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_sales', 'desc')
            ->take(10)
            ->get();

        return [
            'top_products' => $topProducts,
            'top_categories' => $topCategories,
        ];
    }
}
