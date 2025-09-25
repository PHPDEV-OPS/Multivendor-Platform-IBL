@if($cartItems->count() > 0)
    <div class="cart-submenu">
        <div class="cart-items">
            @foreach($cartItems as $item)
                <div class="cart-item d-flex align-items-center mb-2">
                    <div class="cart-item-image me-2">
                        <img src="{{ $item->product->main_image ? (str_starts_with($item->product->main_image, 'frontend/') ? asset($item->product->main_image) : Storage::url($item->product->main_image)) : asset('frontend/amazy/img/67b5a3c9e4224.png') }}" 
                             alt="{{ $item->product->name }}" 
                             style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                    </div>
                    <div class="cart-item-details flex-grow-1">
                        <div class="cart-item-name">{{ Str::limit($item->product->name, 30) }}</div>
                        <div class="cart-item-price">KSh {{ number_format($item->price, 0) }} x {{ $item->quantity }}</div>
                    </div>
                    <div class="cart-item-remove">
                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                onclick="cartProductDelete({{ $item->id }}, {{ $item->product_id }}, this)">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="cart-summary mt-3 pt-3 border-top">
            <div class="d-flex justify-content-between mb-2">
                <span>Subtotal:</span>
                <span>KSh {{ number_format($cartSummary['subtotal'], 0) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span>Total:</span>
                <span class="fw-bold">KSh {{ number_format($cartSummary['total'], 0) }}</span>
            </div>
            <div class="d-grid gap-2">
                <a href="{{ route('cart') }}" class="btn btn-primary btn-sm">View Cart</a>
                <a href="{{ route('checkout') }}" class="btn btn-success btn-sm">Checkout</a>
            </div>
        </div>
    </div>
@else
    <div class="cart-submenu">
        <div class="text-center py-4">
            <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
            <p class="text-muted">Your cart is empty</p>
            <a href="{{ route('categories') }}" class="btn btn-primary btn-sm">Start Shopping</a>
        </div>
    </div>
@endif
