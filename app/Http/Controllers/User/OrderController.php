<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Build query with filters
        $query = Order::where('user_id', $user->id)
            ->with(['items.product', 'user']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
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

        // Get orders with pagination
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calculate order statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $processingOrders = Order::where('user_id', $user->id)->where('status', 'processing')->count();
        $deliveredOrders = Order::where('user_id', $user->id)->where('status', 'delivered')->count();

        return view('user.orders.index', compact(
            'orders',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'deliveredOrders'
        ));
    }

    public function show($id, Request $request)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->with(['items.product', 'user'])
            ->firstOrFail();

        // Check if this is a print request
        if ($request->has('print')) {
            return view('user.orders.print', compact('order'));
        }

        return view('user.orders.show', compact('order'));
    }

    public function downloadPdf($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->with(['items.product', 'user'])
            ->firstOrFail();

        // Generate PDF
        $pdf = Pdf::loadView('user.orders.pdf', compact('order'));

        // Set paper size for thermal printer (80mm width, auto height)
        $pdf->setPaper([0, 0, 226.77, 841.89], 'portrait'); // 80mm x 297mm in points

        // Set options for better rendering
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'defaultFont' => 'DejaVuSansMono',
            'dpi' => 96,
            'defaultPaperSize' => 'custom'
        ]);

        // Download the PDF with a descriptive filename
        $filename = 'receipt-' . $order->order_number . '-' . $order->created_at->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
