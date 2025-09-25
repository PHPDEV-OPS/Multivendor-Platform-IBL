@if($cartItems->count() > 0)
    <div class="cart-main">
        <div class="cart-items">
            @foreach($cartItems as $item)
                <div class="cart-item d-flex align-items-center mb-3 p-3 border rounded">
                    <div class="cart-item-image me-3">
                        <img src="{{ $item->product->main_image ? (str_starts_with($item->product->main_image, 'frontend/') ? asset($item->product->main_image) : Storage::url($item->product->main_image)) : asset('frontend/amazy/img/67b5a3c9e4224.png') }}" 
                             alt="{{ $item->product->name }}" 
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                    </div>
                    <div class="cart-item-details flex-grow-1">
                        <h6 class="mb-1">{{ $item->product->name }}</h6>
                        <p class="text-muted mb-1">{{ $item->product->vendor->name ?? 'Vendor' }}</p>
                        <div class="d-flex align-items-center gap-3">
                            <div class="quantity-controls">
                                <button type="button" class="btn btn-sm btn-outline-secondary" 
                                        onclick="updateCartQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">-</button>
                                <span class="px-2">{{ $item->quantity }}</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary" 
                                        onclick="updateCartQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">+</button>
                            </div>
                            <div class="cart-item-price">
                                <strong>KSh {{ number_format($item->price * $item->quantity, 0) }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="cart-item-remove">
                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                onclick="cartProductDelete({{ $item->id }}, {{ $item->product_id }}, this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="cart-summary mt-4 p-3 border rounded">
            <h5>Order Summary</h5>
            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal:</span>
                <span>KSh {{ number_format($cartSummary['subtotal'], 0) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Shipping:</span>
                <span>KSh {{ number_format($cartSummary['shipping'], 0) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Tax:</span>
                <span>KSh {{ number_format($cartSummary['tax'], 0) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="fw-bold">Total:</span>
                <span class="fw-bold">KSh {{ number_format($cartSummary['total'], 0) }}</span>
            </div>
            <div class="d-grid gap-2">
                <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a>
                <button type="button" class="btn btn-outline-danger" onclick="deleteAlItem()">Clear Cart</button>
            </div>
        </div>
    </div>
@else
    <div class="cart-main">
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">Your cart is empty</h4>
            <p class="text-muted mb-4">Add some products to your cart to get started</p>
            <a href="{{ route('categories') }}" class="btn btn-primary">Start Shopping</a>
        </div>
    </div>
@endif
