@extends('layouts.main')

@section('content')
<style>
.success_wrapper {
    background: #fff;
    border-radius: 8px;
    padding: 40px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-align: center;
    margin: 40px 0;
}

.success_icon {
    width: 80px;
    height: 80px;
    background: #28a745;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
}

.success_icon i {
    font-size: 40px;
    color: white;
}

.order_details {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 30px;
    margin: 30px 0;
}

.order_item {
    border-bottom: 1px solid #dee2e6;
    padding: 15px 0;
}

.order_item:last-child {
    border-bottom: none;
}

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
}

.amaz_primary_btn:hover {
    background: #e55a2b;
    color: white;
    transform: translateY(-2px);
}

.amaz_secondary_btn {
    background: #6c757d;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    font-weight: 500;
}

.amaz_secondary_btn:hover {
    background: #5a6268;
    color: white;
    transform: translateY(-2px);
}
</style>

<div class="amaz_section section_spacing">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="success_wrapper">
                    <div class="success_icon">
                        <i class="fas fa-check"></i>
                    </div>
                    
                    <h2 class="mb-3">Order Placed Successfully!</h2>
                    <p class="text-muted mb-4">Thank you for your order. We've received your order and will begin processing it right away.</p>
                    
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="order_details">
                        <h4 class="mb-4">Order Details</h4>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Order Number:</strong><br>
                                <span class="text-primary">{{ $order->order_number }}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Order Date:</strong><br>
                                {{ $order->created_at->format('F j, Y') }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Order Status:</strong><br>
                                <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'processing' ? 'info' : 'success') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <strong>Payment Status:</strong><br>
                                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Payment Method:</strong><br>
                                {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                            </div>
                            <div class="col-md-6">
                                <strong>Total Amount:</strong><br>
                                <span class="h5 text-primary">KSh {{ number_format($order->total_amount, 0) }}</span>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <h5 class="mb-3">Order Items</h5>
                        @foreach($order->items as $item)
                            <div class="order_item">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6 class="mb-1">{{ $item->product_name }}</h6>
                                        <small class="text-muted">SKU: {{ $item->product_sku }}</small>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="text-muted">Qty: {{ $item->quantity }}</span>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <strong>KSh {{ number_format($item->total_price, 0) }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Billing Address</h6>
                                <div class="text-muted">
                                    {{ $order->billing_address['name'] }}<br>
                                    {{ $order->billing_address['email'] }}<br>
                                    {{ $order->billing_address['phone'] }}<br>
                                    {{ $order->billing_address['address'] }}<br>
                                    {{ $order->billing_address['city'] }}, {{ $order->billing_address['state'] }} {{ $order->billing_address['postal_code'] }}<br>
                                    {{ $order->billing_address['country'] }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>Shipping Address</h6>
                                <div class="text-muted">
                                    {{ $order->shipping_address['name'] }}<br>
                                    {{ $order->shipping_address['phone'] }}<br>
                                    {{ $order->shipping_address['address'] }}<br>
                                    {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['postal_code'] }}<br>
                                    {{ $order->shipping_address['country'] }}
                                </div>
                            </div>
                        </div>
                        
                        @if($order->notes)
                            <hr>
                            <div>
                                <h6>Order Notes</h6>
                                <p class="text-muted">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="next_steps mb-4">
                        <h5>What's Next?</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                                    <p class="small">You'll receive an email confirmation with order details</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="fas fa-truck fa-2x text-info mb-2"></i>
                                    <p class="small">We'll notify you when your order ships</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="fas fa-home fa-2x text-success mb-2"></i>
                                    <p class="small">Your order will be delivered to your address</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="action_buttons">
                        <a href="{{ route('home') }}" class="amaz_primary_btn me-3">
                            <i class="fas fa-home me-2"></i>
                            Continue Shopping
                        </a>
                        @if(auth()->check())
                            <a href="{{ route('user.orders.show', $order->id) }}" class="amaz_secondary_btn">
                                <i class="fas fa-eye me-2"></i>
                                View Order Details
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
