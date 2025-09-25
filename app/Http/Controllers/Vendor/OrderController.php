<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $vendor = Auth::user();
 
        // Build query for vendor's paid orders only
        $query = Order::where('vendor_id', $vendor->id)
            ->where('payment_status', 'paid') // Only show paid orders
            ->with(['user', 'items.product']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('items', function($itemQuery) use ($search) {
                      $itemQuery->where('product_name', 'like', "%{$search}%");
                  });
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply date filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Per page selection
        $perPage = $request->get('per_page', 15);
        if (!in_array($perPage, [10, 15, 25, 50, 100])) {
            $perPage = 15;
        }

        $orders = $query->latest()->paginate($perPage);

        // Get order statistics for this vendor (paid orders only)
        $stats = [
            'total' => Order::where('vendor_id', $vendor->id)->where('payment_status', 'paid')->count(),
            'pending' => Order::where('vendor_id', $vendor->id)->where('payment_status', 'paid')->where('status', 'pending')->count(),
            'processing' => Order::where('vendor_id', $vendor->id)->where('payment_status', 'paid')->where('status', 'processing')->count(),
            'shipped' => Order::where('vendor_id', $vendor->id)->where('payment_status', 'paid')->where('status', 'shipped')->count(),
            'delivered' => Order::where('vendor_id', $vendor->id)->where('payment_status', 'paid')->where('status', 'delivered')->count(),
            'total_revenue' => Order::where('vendor_id', $vendor->id)->where('payment_status', 'paid')->sum('vendor_amount'),
        ];

        return view('vendor.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $vendor = Auth::user();

        // Ensure the order belongs to this vendor and is paid
        if ((int)$order->vendor_id !== (int)$vendor->id || $order->payment_status !== 'paid') {
            abort(404, 'Order not found or not accessible.');
        }

        $order->load(['user', 'items.product', 'transactions']);

        return view('vendor.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $vendor = Auth::user();

        // Ensure the order belongs to this vendor and is paid
        if ((int)$order->vendor_id !== (int)$vendor->id) {
            Log::warning('Order access denied - vendor mismatch', [
                'order_id' => $order->id,
                'order_vendor_id' => $order->vendor_id,
                'current_vendor_id' => $vendor->id,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Order not found or not accessible.'
            ], 404);
        }

        if ($order->payment_status !== 'paid') {
            Log::warning('Order access denied - not paid', [
                'order_id' => $order->id,
                'payment_status' => $order->payment_status
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Order must be paid before status can be updated.'
            ], 400);
        }

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $updateData = [
            'status' => $request->status,
        ];

        // Add tracking number if provided
        if ($request->filled('tracking_number')) {
            $updateData['tracking_number'] = $request->tracking_number;
        }

        // Add notes if provided
        if ($request->filled('notes')) {
            $updateData['notes'] = $request->notes;
        }

        // Set timestamps based on status
        switch ($request->status) {
            case 'shipped':
                $updateData['shipped_at'] = now();
                break;
            case 'delivered':
                $updateData['delivered_at'] = now();
                break;
        }

        $order->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully!',
            'status' => $request->status,
        ]);
    }

    public function export(Request $request)
    {
        $vendor = Auth::user();

        // Get vendor's paid orders for export
        $query = Order::where('vendor_id', $vendor->id)
            ->where('payment_status', 'paid')
            ->with(['user', 'items.product']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->get();

        // Generate CSV
        $filename = 'vendor_orders_' . $vendor->id . '_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'Order Number',
                'Customer Name',
                'Customer Email',
                'Customer Phone',
                'Total Amount',
                'Vendor Amount',
                'Status',
                'Payment Status',
                'Order Date',
                'Items Count',
                'Tracking Number'
            ]);

            // CSV data
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->user->name ?? 'N/A',
                    $order->user->email ?? 'N/A',
                    $order->billing_address['phone'] ?? 'N/A',
                    number_format($order->total_amount, 2),
                    number_format($order->vendor_amount, 2),
                    ucfirst($order->status),
                    ucfirst($order->payment_status),
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->items->count(),
                    $order->tracking_number ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
