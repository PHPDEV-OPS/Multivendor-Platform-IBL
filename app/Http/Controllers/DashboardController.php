<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the appropriate dashboard based on user role
     */
    public function index()
    {
        $user = Auth::user();

        // Update last login time
        $user->update(['last_login_at' => now()]);

        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard();
            case 'vendor':
                return $this->vendorDashboard();
            case 'customer':
            default:
                return $this->customerDashboard();
        }
    }

    /**
     * Customer Dashboard
     */
    private function customerDashboard()
    {
        $user = Auth::user();

        // Mock data for demonstration - replace with actual data
        $stats = [
            'total_orders' => 12,
            'pending_orders' => 2,
            'completed_orders' => 10,
            'wishlist_items' => 5,
        ];

        $recentOrders = []; // Replace with actual order data
        $wishlistItems = []; // Replace with actual wishlist data

        return view('dashboards.customer', compact('user', 'stats', 'recentOrders', 'wishlistItems'));
    }

    /**
     * Admin Dashboard
     */
    private function adminDashboard()
    {
        $user = Auth::user();

        // Mock data for demonstration - replace with actual data
        $stats = [
            'total_users' => 1250,
            'total_orders' => 3420,
            'total_products' => 890,
            'total_revenue' => 125000,
            'pending_orders' => 45,
            'active_vendors' => 23,
        ];

        $recentOrders = []; // Replace with actual order data
        $recentUsers = []; // Replace with actual user data

        return view('dashboards.admin', compact('user', 'stats', 'recentOrders', 'recentUsers'));
    }

    /**
     * Vendor Dashboard
     */
    private function vendorDashboard()
    {
        $user = Auth::user();

        // Mock data for demonstration - replace with actual data
        $stats = [
            'total_products' => 45,
            'total_sales' => 8500,
            'pending_orders' => 8,
            'completed_orders' => 156,
            'product_views' => 2340,
            'monthly_revenue' => 12500,
        ];

        $recentOrders = []; // Replace with actual order data
        $topProducts = []; // Replace with actual product data

        return view('dashboards.vendor', compact('user', 'stats', 'recentOrders', 'topProducts'));
    }
}
