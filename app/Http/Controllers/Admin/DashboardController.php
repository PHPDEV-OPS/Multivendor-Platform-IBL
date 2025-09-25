<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\VendorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_orders' => Order::count(),
            'active_users' => User::where('role', 'user')->where('is_active', true)->count(),
            'vendors' => User::where('role', 'vendor')->where('is_active', true)->count(),
        ];

        // Get recent orders
        $recentOrders = Order::with(['user', 'vendor'])
            ->latest()
            ->take(4)
            ->get();

        // Get top products
        $topProducts = Product::with('vendor')
            ->orderBy('sold_count', 'desc')
            ->take(3)
            ->get();

        // Get monthly analytics
        $monthlyStats = $this->getMonthlyStats();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts', 'monthlyStats'));
    }

    private function getMonthlyStats()
    {
        $currentMonth = now()->format('Y-m');
        
        return [
            'revenue' => Order::where('payment_status', 'paid')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('total_amount'),
            'orders' => Order::whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->count(),
            'new_users' => User::where('role', 'user')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->count(),
            'active_vendors' => User::where('role', 'vendor')
                ->where('is_active', true)
                ->count(),
        ];
    }
}
