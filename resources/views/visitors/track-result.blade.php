@extends('layouts.main')

@section('content')
<div class="order_tracking_area section_spacing6">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="tracking_result">
                    <div class="text-center mb-4">
                        <h3 class="font_30 f_w_700 mb_3">Order Tracking</h3>
                        <p class="text-muted">Order ID: <strong>{{ $order->order_number }}</strong></p>
                    </div>

                    <!-- Order Status Timeline -->
                    <div class="order-timeline mb-5">
                        <div class="timeline-container">
                            <div class="timeline-item {{ $order->status == 'pending' ? 'active' : ($order->created_at ? 'completed' : '') }}">
                                <div class="timeline-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Order Placed</h6>
                                    <p class="text-muted">{{ $order->created_at->setTimezone('Africa/Nairobi')->format('M d, Y - h:i A') }} EAT</p>
                                </div>
                            </div>

                            <div class="timeline-item {{ $order->status == 'processing' ? 'active' : (in_array($order->status, ['shipped', 'delivered']) ? 'completed' : '') }}">
                                <div class="timeline-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Processing</h6>
                                    <p class="text-muted">
                                        @if($order->status == 'processing' || in_array($order->status, ['shipped', 'delivered']))
                                            Order is being prepared
                                        @else
                                            Waiting for processing
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item {{ $order->status == 'shipped' ? 'active' : ($order->status == 'delivered' ? 'completed' : '') }}">
                                <div class="timeline-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Shipped</h6>
                                    <p class="text-muted">
                                        @if($order->status == 'shipped' || $order->status == 'delivered')
                                            @if($order->tracking_number)
                                                Tracking: {{ $order->tracking_number }}
                                            @else
                                                Order has been shipped
                                            @endif
                                        @else
                                            Not yet shipped
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item {{ $order->status == 'delivered' ? 'active completed' : '' }}">
                                <div class="timeline-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Delivered</h6>
                                    <p class="text-muted">
                                        @if($order->status == 'delivered')
                                            @if($order->delivered_at)
                                                {{ $order->delivered_at->setTimezone('Africa/Nairobi')->format('M d, Y - h:i A') }} EAT
                                            @else
                                                Order delivered
                                            @endif
                                        @else
                                            Not yet delivered
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="order-info-card">
                                <h5 class="mb-3">Order Information</h5>
                                <div class="info-row">
                                    <span class="label">Order Number:</span>
                                    <span class="value">{{ $order->order_number }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="label">Order Date:</span>
                                    <span class="value">{{ $order->created_at->setTimezone('Africa/Nairobi')->format('M d, Y \a\t g:i A') }} EAT</span>
                                </div>
                                <div class="info-row">
                                    <span class="label">Status:</span>
                                    <span class="value">
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="label">Payment Status:</span>
                                    <span class="value">
                                        <span class="status-badge status-{{ $order->payment_status }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </span>
                                </div>
                                @if($order->tracking_number)
                                <div class="info-row">
                                    <span class="label">Tracking Number:</span>
                                    <span class="value">{{ $order->tracking_number }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="order-info-card">
                                <h5 class="mb-3">Shipping Information</h5>
                                @if($order->shipping_address)
                                    @php
                                        $address = is_array($order->shipping_address)
                                            ? $order->shipping_address
                                            : json_decode($order->shipping_address, true);
                                    @endphp
                                    <div class="address-info">
                                        <p><strong>{{ $address['name'] ?? 'N/A' }}</strong></p>
                                        <p>{{ $address['address'] ?? 'N/A' }}</p>
                                        <p>{{ $address['city'] ?? 'N/A' }}, {{ $address['state'] ?? 'N/A' }}</p>
                                        <p>{{ $address['postal_code'] ?? 'N/A' }}</p>
                                        @if(isset($address['phone']))
                                            <p>Phone: {{ $address['phone'] }}</p>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-muted">No shipping address available</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="order-items-card mt-4">
                        <h5 class="mb-3">Order Items</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                         alt="{{ $item->product_name }}"
                                                         class="product-thumb me-3">
                                                @endif
                                                <div>
                                                    <h6 class="mb-1">{{ $item->product_name }}</h6>
                                                    @if($item->product_sku)
                                                        <small class="text-muted">SKU: {{ $item->product_sku }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>KES {{ number_format($item->unit_price, 0) }}</td>
                                        <td>KES {{ number_format($item->unit_price * $item->quantity, 0) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                        <td><strong>KES {{ number_format($order->subtotal, 0) }}</strong></td>
                                    </tr>
                                    @if($order->shipping_amount > 0)
                                    <tr>
                                        <td colspan="3" class="text-end">Shipping:</td>
                                        <td>KES {{ number_format($order->shipping_amount, 0) }}</td>
                                    </tr>
                                    @endif
                                    @if($order->tax_amount > 0)
                                    <tr>
                                        <td colspan="3" class="text-end">Tax:</td>
                                        <td>KES {{ number_format($order->tax_amount, 0) }}</td>
                                    </tr>
                                    @endif
                                    @if($order->discount_amount > 0)
                                    <tr>
                                        <td colspan="3" class="text-end">Discount:</td>
                                        <td class="text-success">-KES {{ number_format($order->discount_amount, 0) }}</td>
                                    </tr>
                                    @endif
                                    <tr class="table-active">
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td><strong>KES {{ number_format($order->total_amount, 0) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="text-center mt-4">
                        <a href="{{ route('track-order') }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-search me-1"></i>Track Another Order
                        </a>
                        @if($order->user_id == auth()->id())
                            <a href="{{ route('user.orders.show', $order) }}" class="btn btn-primary">
                                <i class="fas fa-eye me-1"></i>View Full Details
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order_tracking_area {
    padding: 80px 0;
    background: #f8f9fa;
    min-height: 80vh;
}

.tracking_result {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.order-timeline {
    position: relative;
}

.timeline-container {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin: 40px 0;
}

.timeline-container::before {
    content: '';
    position: absolute;
    top: 25px;
    left: 0;
    right: 0;
    height: 2px;
    background: #e9ecef;
    z-index: 1;
}

.timeline-item {
    flex: 1;
    text-align: center;
    position: relative;
    z-index: 2;
}

.timeline-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    transition: all 0.3s ease;
}

.timeline-item.active .timeline-icon {
    background: #007bff;
    color: white;
}

.timeline-item.completed .timeline-icon {
    background: #28a745;
    color: white;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-weight: 600;
}

.timeline-content p {
    font-size: 14px;
    margin: 0;
}

.order-info-card {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 10px;
    height: 100%;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row .label {
    font-weight: 600;
    color: #495057;
}

.order-items-card {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 10px;
}

.product-thumb {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending { background: #fff3cd; color: #856404; }
.status-processing { background: #cce5ff; color: #004085; }
.status-shipped { background: #d4edda; color: #155724; }
.status-delivered { background: #d1ecf1; color: #0c5460; }
.status-cancelled { background: #f8d7da; color: #721c24; }
.status-paid { background: #d4edda; color: #155724; }
.status-pending { background: #fff3cd; color: #856404; }

@media (max-width: 768px) {
    .timeline-container {
        flex-direction: column;
        align-items: center;
    }

    .timeline-container::before {
        display: none;
    }

    .timeline-item {
        margin-bottom: 30px;
    }

    .tracking_result {
        padding: 20px;
    }
}
</style>
@endsection
