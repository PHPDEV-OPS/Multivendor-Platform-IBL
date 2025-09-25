@extends('layouts.main')

@section('content')
<style>
.cart_items_wrapper {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.empty_cart_state {
    min-height: 300px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.empty_cart_icon svg {
    opacity: 0.6;
}

.order_summary_wrapper {
    background: #fff;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: sticky;
    top: 20px;
}

.summary_item {
    font-size: 14px;
}

.summary_label {
    color: #6c757d;
}

.summary_value {
    font-weight: 500;
}

.summary_total {
    border-top: 2px solid #e9ecef !important;
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

.amaz_primary_btn:disabled {
    background: #6c757d;
    cursor: not-allowed;
    transform: none;
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

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 5px;
}

.quantity-controls .btn {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    font-size: 14px;
}

.quantity-controls .form-control {
    width: 60px;
    text-align: center;
    height: 30px;
    padding: 0;
    font-size: 14px;
}

@media (max-width: 768px) {
    .cart_items_wrapper,
    .order_summary_wrapper {
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .order_summary_wrapper {
        position: static;
    }
}
</style>

<!-- cart_page_wrapper::start -->
<div class="amaz_section section_spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title text-center mb_30">
                    <h2>Shopping Cart</h2>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Cart Items Column -->
            <div class="col-lg-8 col-md-12">
                <div class="cart_items_wrapper">
                    <div class="cart_items_header d-flex justify-content-between align-items-center mb_30">
                        <h4 class="m-0">Cart Items</h4>
                        <span class="cart_items_count">0 Items</span>
                    </div>
                    
                    @if($cartItems->count() > 0)
                        <!-- Cart Items List -->
                        <div class="cart_items_list">
                            @foreach($cartItems as $cartItem)
                                <div class="cart_item mb_30 p_20 border rounded" data-cart-id="{{ $cartItem->id }}">
                                    <div class="row align-items-center">
                                        <div class="col-md-2 col-4">
                                            <img src="{{ $cartItem->product->main_image ? (str_starts_with($cartItem->product->main_image, 'frontend/') ? asset($cartItem->product->main_image) : Storage::url($cartItem->product->main_image)) : asset('frontend/amazy/img/67b5a3c9e4224.png') }}" 
                                                 class="img-fluid rounded" 
                                                 alt="{{ $cartItem->product->name }}">
                                        </div>
                                        <div class="col-md-4 col-8">
                                            <h6 class="mb_1">{{ $cartItem->product->name }}</h6>
                                            <small class="text-muted">Vendor: {{ $cartItem->product->vendor->name ?? 'Unknown' }}</small>
                                            <div class="mt-2">
                                                <span class="text-primary fw-bold">KSh {{ number_format($cartItem->price, 0) }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-6">
                                            <div class="quantity-controls">
                                                <button class="btn btn-sm btn-outline-secondary quantity-btn" data-action="decrease">-</button>
                                                <input type="number" class="form-control form-control-sm quantity-input" 
                                                       value="{{ $cartItem->quantity }}" 
                                                       min="1" 
                                                       max="{{ $cartItem->product->stock_quantity }}"
                                                       data-cart-id="{{ $cartItem->id }}">
                                                <button class="btn btn-sm btn-outline-secondary quantity-btn" data-action="increase">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-3">
                                            <div class="text-end">
                                                <span class="fw-bold">KSh {{ number_format($cartItem->subtotal, 0) }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-3">
                                            <button class="btn btn-sm btn-danger remove-item" data-cart-id="{{ $cartItem->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="text-end mt_30">
                                <button class="btn btn-outline-danger" id="clear-cart">
                                    <i class="fas fa-trash me-2"></i>Clear Cart
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Empty Cart State -->
                        <div class="empty_cart_state text-center py_50">
                            <div class="empty_cart_icon mb_30">
                                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 22C9.55228 22 10 21.5523 10 21C10 20.4477 9.55228 20 9 20C8.44772 20 8 20.4477 8 21C8 21.5523 8.44772 22 9 22Z" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M20 22C20.5523 22 21 21.5523 21 21C21 20.4477 20.5523 20 20 20C19.4477 20 19 20.4477 19 21C19 21.5523 19.4477 22 20 22Z" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M1 1H5L7.68 14.39C7.77144 14.8504 8.02191 15.264 8.38755 15.5583C8.75318 15.8526 9.2107 16.009 9.68 16H19.4C19.8693 16.009 20.3268 15.8526 20.6925 15.5583C21.0581 15.264 21.3086 14.8504 21.4 14.39L23 6H6" stroke="#6c757d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h4 class="mb_20">No products found</h4>
                            <p class="text-muted mb_30">Your shopping cart is empty. Start shopping to add items to your cart.</p>
                            <a href="{{ route('home') }}" class="amaz_primary_btn">
                                <i class="fas fa-shopping-bag me-2"></i>
                                Continue Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Order Summary Column -->
            <div class="col-lg-4 col-md-12">
                <div class="order_summary_wrapper">
                    <div class="order_summary_header mb_30">
                        <h4 class="m-0 fw-bold">Order Summary</h4>
                    </div>
                    
                    <div class="order_summary_content">
                        <div class="summary_item d-flex justify-content-between align-items-center mb_15">
                            <span class="summary_label">Subtotal:</span>
                            <span class="summary_value">KSh {{ number_format($cartSummary['subtotal'], 0) }}</span>
                        </div>
                        
                        <div class="summary_item d-flex justify-content-between align-items-center mb_15">
                            <span class="summary_label">Shipping Charge:</span>
                            <span class="summary_value text-muted">Calculated at next step</span>
                        </div>
                        
                        <div class="summary_item d-flex justify-content-between align-items-center mb_15">
                            <span class="summary_label">Discount:</span>
                            <span class="summary_value text-success">- KSh {{ number_format($cartSummary['discount'], 0) }}</span>
                        </div>
                        
                        <div class="summary_item d-flex justify-content-between align-items-center mb_25">
                            <span class="summary_label">VAT/TAX/GST:</span>
                            <span class="summary_value text-muted">Calculated at next step</span>
                        </div>
                        
                        <div class="summary_total d-flex justify-content-between align-items-center py_20 border-top">
                            <span class="summary_label fw-bold fs-5">Total:</span>
                            <span class="summary_value fw-bold fs-5">KSh {{ number_format($cartSummary['total'], 0) }}</span>
                        </div>
                        
                        <div class="checkout_actions mt_30">
                            @if($cartItems->count() > 0)
                                <a href="{{ route('checkout') }}" class="amaz_primary_btn w-100 mb_15">
                                    <i class="fas fa-lock me-2"></i>
                                    Proceed to Checkout
                                </a>
                            @else
                                <button class="amaz_primary_btn w-100 mb_15" disabled>
                                    <i class="fas fa-lock me-2"></i>
                                    Proceed to Checkout
                                </button>
                            @endif
                            <a href="{{ route('home') }}" class="amaz_secondary_btn w-100">
                                <i class="fas fa-arrow-left me-2"></i>
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart_page_wrapper::end -->

@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity controls
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-input');
            const action = this.dataset.action;
            let value = parseInt(input.value);
            
            if (action === 'increase') {
                value = Math.min(value + 1, parseInt(input.max));
            } else {
                value = Math.max(value - 1, parseInt(input.min));
            }
            
            input.value = value;
            updateCartItem(input.dataset.cartId, value);
        });
    });

    // Quantity input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            updateCartItem(this.dataset.cartId, this.value);
        });
    });

    // Remove item
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Are you sure you want to remove this item?')) {
                removeCartItem(this.dataset.cartId);
            }
        });
    });

    // Clear cart
    document.getElementById('clear-cart').addEventListener('click', function() {
        if (confirm('Are you sure you want to clear your cart?')) {
            clearCart();
        }
    });
});

function updateCartItem(cartId, quantity) {
    fetch('{{ route("cart.update") }}', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            cart_id: cartId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the cart.');
    });
}

function removeCartItem(cartId) {
    fetch('{{ route("cart.remove") }}', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            cart_id: cartId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while removing the item.');
    });
}

function clearCart() {
    fetch('{{ route("cart.clear") }}', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while clearing the cart.');
    });
}
</script>