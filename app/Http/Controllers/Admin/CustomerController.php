<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user')
            ->with(['userProfile', 'orders'])
            ->withCount('orders')
            ->withSum('orders', 'total_amount');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } else {
                $query->where('is_active', false);
            }
        }

        $customers = $query->latest()->paginate(15);

        // Add additional data to each customer
        foreach ($customers as $customer) {
            $customer->total_spent = $customer->orders_sum_total_amount ?? 0;
            $customer->last_order_date = $customer->orders->sortByDesc('created_at')->first()?->created_at;
            $customer->recent_orders_count = $customer->orders->where('created_at', '>=', now()->subDays(30))->count();
        }

        // Get customer statistics
        $stats = [
            'total' => User::where('role', 'user')->count(),
            'active' => User::where('role', 'user')->where('is_active', true)->count(),
            'inactive' => User::where('role', 'user')->where('is_active', false)->count(),
        ];

        return view('admin.customers', compact('customers', 'stats'));
    }

    public function show(User $user)
    {
        $user->load(['userProfile', 'orders']);
        
        return view('admin.customers.show', compact('user'));
    }
}
