<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Auth::user();
        
        // Get current month data
        $currentMonth = now()->startOfMonth();
        $previousMonth = now()->subMonth()->startOfMonth();
        
        // Get financial overview
        $financialOverview = $this->getFinancialOverview($vendor->id, $currentMonth);
        $previousMonthData = $this->getFinancialOverview($vendor->id, $previousMonth);
        
        // Get recent transactions
        $recentTransactions = $this->getRecentTransactions($vendor->id);
        
        // Get payout information
        $payoutInfo = $this->getPayoutInfo($vendor->id);
        
        // Get commission breakdown
        $commissionBreakdown = $this->getCommissionBreakdown($vendor->id, $currentMonth);
        
        return view('vendor.finance', compact(
            'financialOverview',
            'previousMonthData',
            'recentTransactions',
            'payoutInfo',
            'commissionBreakdown'
        ));
    }

    private function getFinancialOverview($vendorId, $startDate)
    {
        $endDate = $startDate->copy()->endOfMonth();
        
        // Total revenue from paid orders
        $totalRevenue = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        // Net earnings (vendor amount after commission)
        $netEarnings = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('vendor_amount');

        // Platform fees (difference between total and vendor amount)
        $platformFees = $totalRevenue - $netEarnings;

        // Total orders
        $totalOrders = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Average order value
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Conversion rate (simplified - orders vs product views)
        $totalViews = Product::where('vendor_id', $vendorId)->sum('view_count') ?: 1;
        $conversionRate = ($totalOrders / $totalViews) * 100;

        return [
            'total_revenue' => $totalRevenue,
            'net_earnings' => $netEarnings,
            'platform_fees' => $platformFees,
            'pending_payout' => $netEarnings, // Simplified - assume all earnings are pending
            'total_orders' => $totalOrders,
            'average_order_value' => $averageOrderValue,
            'conversion_rate' => $conversionRate,
        ];
    }

    private function getRecentTransactions($vendorId)
    {
        return Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->with(['user', 'items.product'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($order) {
                return [
                    'order_number' => $order->order_number,
                    'customer_name' => $order->user ? $order->user->name : 'N/A',
                    'product_names' => $order->items->pluck('product_name')->join(', '),
                    'total_amount' => $order->total_amount,
                    'commission' => $order->total_amount - $order->vendor_amount,
                    'net_earnings' => $order->vendor_amount,
                    'status' => $order->status,
                    'date' => $order->created_at->format('Y-m-d'),
                ];
            });
    }

    private function getPayoutInfo($vendorId)
    {
        // Get total pending earnings
        $pendingEarnings = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->sum('vendor_amount');

        // Get last month's earnings (simulating last payout)
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();
        
        $lastPayout = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
            ->sum('vendor_amount');

        // Next payout date (assuming monthly payouts on 25th)
        $nextPayoutDate = now()->day >= 25 ? now()->addMonth()->day(25) : now()->day(25);

        return [
            'next_payout_amount' => $pendingEarnings,
            'next_payout_date' => $nextPayoutDate->format('F j, Y'),
            'last_payout_amount' => $lastPayout,
            'last_payout_date' => $lastMonthEnd->format('F j, Y'),
            'payout_method' => 'M-Pesa', // Default payout method
        ];
    }

    private function getCommissionBreakdown($vendorId, $startDate)
    {
        $endDate = $startDate->copy()->endOfMonth();
        
        $totalRevenue = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $netEarnings = Order::where('vendor_id', $vendorId)
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('vendor_amount');

        $totalCommission = $totalRevenue - $netEarnings;

        // Assuming 15% platform fee and 2% transaction fee
        $platformFeeRate = 0.15;
        $transactionFeeRate = 0.02;
        
        $platformFee = $totalRevenue * $platformFeeRate;
        $transactionFee = $totalRevenue * $transactionFeeRate;
        
        // Adjust if actual commission is different
        if ($totalCommission > 0) {
            $actualCommissionRate = $totalCommission / $totalRevenue;
            $platformFee = $totalCommission * 0.85; // 85% of commission is platform fee
            $transactionFee = $totalCommission * 0.15; // 15% of commission is transaction fee
        }

        return [
            'total_revenue' => $totalRevenue,
            'platform_fee' => $platformFee,
            'transaction_fee' => $transactionFee,
            'net_earnings' => $netEarnings,
            'platform_fee_percentage' => $totalRevenue > 0 ? ($platformFee / $totalRevenue) * 100 : 0,
            'transaction_fee_percentage' => $totalRevenue > 0 ? ($transactionFee / $totalRevenue) * 100 : 0,
            'net_earnings_percentage' => $totalRevenue > 0 ? ($netEarnings / $totalRevenue) * 100 : 0,
        ];
    }

    public function export(Request $request)
    {
        $vendor = Auth::user();
        $currentMonth = now()->startOfMonth();
        
        $financialOverview = $this->getFinancialOverview($vendor->id, $currentMonth);
        $recentTransactions = $this->getRecentTransactions($vendor->id);

        $filename = 'vendor_finance_report_' . $vendor->id . '_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($financialOverview, $recentTransactions) {
            $file = fopen('php://output', 'w');
            
            // Financial overview
            fputcsv($file, ['Vendor Finance Report']);
            fputcsv($file, ['Generated on: ' . now()->format('Y-m-d H:i:s')]);
            fputcsv($file, []);
            
            fputcsv($file, ['Financial Overview']);
            fputcsv($file, ['Total Revenue', 'KES ' . number_format($financialOverview['total_revenue'], 2)]);
            fputcsv($file, ['Net Earnings', 'KES ' . number_format($financialOverview['net_earnings'], 2)]);
            fputcsv($file, ['Platform Fees', 'KES ' . number_format($financialOverview['platform_fees'], 2)]);
            fputcsv($file, ['Pending Payout', 'KES ' . number_format($financialOverview['pending_payout'], 2)]);
            fputcsv($file, []);
            
            // Recent transactions
            fputcsv($file, ['Recent Transactions']);
            fputcsv($file, ['Order Number', 'Customer', 'Products', 'Total Amount', 'Commission', 'Net Earnings', 'Status', 'Date']);
            
            foreach ($recentTransactions as $transaction) {
                fputcsv($file, [
                    $transaction['order_number'],
                    $transaction['customer_name'],
                    $transaction['product_names'],
                    'KES ' . number_format($transaction['total_amount'], 2),
                    'KES ' . number_format($transaction['commission'], 2),
                    'KES ' . number_format($transaction['net_earnings'], 2),
                    ucfirst($transaction['status']),
                    $transaction['date']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
