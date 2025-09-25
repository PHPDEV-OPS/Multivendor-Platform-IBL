@extends('layouts.main')

@section('content')
<style>
.order_details_wrapper {
    background: #fff;
    border-radius: 8px;
    padding: 40px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin: 40px 0;
}

.order_header {
    border-bottom: 2px solid #f8f9fa;
    padding-bottom: 20px;
    margin-bottom: 30px;
}

.order_section {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 25px;
    margin: 20px 0;
}

.status_badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
}

.status_pending { background: #fff3cd; color: #856404; }
.status_processing { background: #d1ecf1; color: #0c5460; }
.status_shipped { background: #d4edda; color: #155724; }
.status_delivered { background: #d4edda; color: #155724; }
.status_cancelled { background: #f8d7da; color: #721c24; }

.payment_paid { background: #d4edda; color: #155724; }
.payment_pending { background: #fff3cd; color: #856404; }
.payment_failed { background: #f8d7da; color: #721c24; }

.amaz_primary_btn {
    background: #ff6b35;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    font-weight: 500;
    margin-right: 10px;
}

.amaz_primary_btn:hover {
    background: #e55a2b;
    color: white;
    transform: translateY(-2px);
}

.print_btn {
    background: #28a745;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.print_btn:hover {
    background: #218838;
}

@media print {
    .no-print { display: none !important; }
    .order_details_wrapper { box-shadow: none; margin: 0; padding: 20px; }
    body { font-size: 12px; }
    .print_header { display: block !important; }
}

.print_header {
    display: none;
    text-align: center;
    border-bottom: 2px solid #000;
    padding-bottom: 20px;
    margin-bottom: 30px;
}
</style>

<div class="amaz_section section_spacing">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="order_details_wrapper" id="order-details">
                    <!-- Print Header (only visible when printing) -->
                    <div class="print_header">
                        <h2>Tununue-LTD</h2>
                        <p>Order Receipt</p>
                        <p>Date: {{ now()->format('F j, Y g:i A') }}</p>
                    </div>

                    <!-- Order Header -->
                    <div class="order_header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2>Order Details</h2>
                                <p class="text-muted mb-0">Order #{{ $order->order_number }}</p>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="no-print">
                                    <button onclick="printReceipt()" class="print_btn">
                                        <i class="fas fa-print me-2"></i>
                                        Print Receipt
                                    </button>
                                    @if($order->payment_status == 'paid')
                                        <a href="{{ route('user.orders.download-pdf', $order->id) }}" class="print_btn" style="background: #007bff; text-decoration: none; margin-left: 10px;">
                                            <i class="fas fa-download me-2"></i>
                                            Download PDF
                                        </a>
                                    @endif
                                    <a href="{{ route('user.orders') }}" class="amaz_primary_btn">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Back to Orders
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Order Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="order_section">
                                <h5 class="mb-3">Order Information</h5>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Order Date:</strong></div>
                                    <div class="col-7">{{ $order->created_at->format('F j, Y g:i A') }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Order Status:</strong></div>
                                    <div class="col-7">
                                        <span class="status_badge status_{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Payment Status:</strong></div>
                                    <div class="col-7">
                                        <span class="status_badge payment_{{ $order->payment_status }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Payment Method:</strong></div>
                                    <div class="col-7">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
                                </div>
                                @if($order->paid_at)
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Paid At:</strong></div>
                                    <div class="col-7">{{ $order->paid_at->format('F j, Y g:i A') }}</div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="order_section">
                                <h5 class="mb-3">Customer Information</h5>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Name:</strong></div>
                                    <div class="col-8">{{ $order->billing_address['name'] }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Email:</strong></div>
                                    <div class="col-8">{{ $order->billing_address['email'] }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Phone:</strong></div>
                                    <div class="col-8">{{ $order->billing_address['phone'] }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Address:</strong></div>
                                    <div class="col-8">
                                        {{ $order->billing_address['address'] }}<br>
                                        {{ $order->billing_address['city'] }}, {{ $order->billing_address['state'] }} {{ $order->billing_address['postal_code'] }}<br>
                                        {{ $order->billing_address['country'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="order_section">
                        <h5 class="mb-4">Order Items</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>SKU</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Unit Price</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->product_name }}</strong>
                                        </td>
                                        <td>{{ $item->product_sku }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">KSh {{ number_format($item->unit_price, 0) }}</td>
                                        <td class="text-end">KSh {{ number_format($item->total_price, 0) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="order_section">
                        <h5 class="mb-4">Order Summary</h5>
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="row mb-2">
                                    <div class="col-6"><strong>Subtotal:</strong></div>
                                    <div class="col-6 text-end">KSh {{ number_format($order->subtotal, 0) }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6"><strong>Shipping:</strong></div>
                                    <div class="col-6 text-end">KSh {{ number_format($order->shipping_amount, 0) }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6"><strong>Tax:</strong></div>
                                    <div class="col-6 text-end">KSh {{ number_format($order->tax_amount, 0) }}</div>
                                </div>
                                @if($order->discount_amount > 0)
                                <div class="row mb-2">
                                    <div class="col-6"><strong>Discount:</strong></div>
                                    <div class="col-6 text-end text-success">-KSh {{ number_format($order->discount_amount, 0) }}</div>
                                </div>
                                @endif
                                <hr>
                                <div class="row">
                                    <div class="col-6"><strong class="h5">Total:</strong></div>
                                    <div class="col-6 text-end"><strong class="h5 text-primary">KSh {{ number_format($order->total_amount, 0) }}</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($order->notes)
                    <div class="order_section">
                        <h5 class="mb-3">Order Notes</h5>
                        <p class="mb-0">{{ $order->notes }}</p>
                    </div>
                    @endif

                    <!-- Footer for print -->
                    <div class="text-center mt-4" style="display: none;">
                        <small class="text-muted">
                            Thank you for your business!<br>
                            {{ config('app.name', 'Ecomtu') }} - {{ config('app.url') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function printReceipt() {
    // Open print-only version in new window
    const printWindow = window.open('{{ route("user.orders.show", $order->id) }}?print=1', '_blank', 'width=800,height=600');

    // Wait for the window to load then print
    printWindow.onload = function() {
        setTimeout(function() {
            printWindow.print();
        }, 500);
    };
}
</script>
@endsection
