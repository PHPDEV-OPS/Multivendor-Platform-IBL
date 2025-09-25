<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        // Get date range
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Financial statistics
        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'total_orders' => Order::count(),
            'paid_orders' => Order::where('payment_status', 'paid')->count(),
            'pending_payments' => Order::where('payment_status', 'pending')->count(),
            'monthly_revenue' => Order::where('payment_status', 'paid')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('total_amount'),
            'monthly_orders' => Order::whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];

        // Revenue by date
        $revenueByDate = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top customers by spending
        $topCustomers = User::where('role', 'user')
            ->withSum('orders', 'total_amount')
            ->withCount('orders')
            ->orderByDesc('orders_sum_total_amount')
            ->take(10)
            ->get();

        // Payment method breakdown
        $paymentMethods = Transaction::selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_method')
            ->get();

        // Recent transactions
        $recentTransactions = Transaction::with(['order.user'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.finance', compact(
            'stats',
            'revenueByDate',
            'topCustomers',
            'paymentMethods',
            'recentTransactions',
            'startDate',
            'endDate'
        ));
    }
}
