@extends('layouts.main')

@section('content')
<!-- wishlist_banner::start  -->
<div class="amaz_section section_spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title text-center mb_50">
                    <h2>My Wishlist</h2>
                    <p>Save your favorite items for later</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- wishlist_banner::end  -->

<!-- wishlist_content::start  -->
<div class="amaz_section section_spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="wishlist_content">
                    @auth
                        @if($wishlistItems->isEmpty())
                        <!-- Empty wishlist state -->
                        <div class="empty_wishlist text-center" id="empty_wishlist">
                            <div class="empty_icon mb_30">
                                <i class="far fa-heart" style="font-size: 80px; color: #fd4949;"></i>
                            </div>
                            <h4 class="mb_20">Your wishlist is empty</h4>
                            <p class="mb_30">Start adding items to your wishlist to save them for later.</p>
                            <a href="{{ url('/') }}" class="amaz_primary_btn">Continue Shopping</a>
                        </div>
                        @else

                        <!-- Wishlist items -->
                        <div class="wishlist_items" id="wishlist_items">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4>My Wishlist ({{ $wishlistItems->count() }} items)</h4>
                                <a href="{{ url('/') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-shopping-bag me-1"></i>Continue Shopping
                                </a>
                            </div>

                            <div class="row">
                                @foreach($wishlistItems as $item)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb_30">
                                    <div class="product_widget5 style5">
                                        <div class="product_thumb_upper">
                                            <a href="{{ route('product.show', $item->product->slug) }}" class="thumb">
                                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('frontend/amazy/img/default-product.png') }}"
                                                     alt="{{ $item->product->name }}" class="img-fluid">
                                            </a>
                                            <div class="product_action">
                                                <button onclick="removeFromWishlist({{ $item->id }})"
                                                        class="remove_from_wishlist"
                                                        title="Remove from Wishlist">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @if($item->product->stock_quantity > 0)
                                                    <button onclick="addToCart({{ $item->product->id }})"
                                                            class="add_to_cart"
                                                            title="Add to Cart">
                                                        <i class="ti-shopping-cart"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="product__meta text-center">
                                            <span class="product_banding">{{ $item->vendor->name ?? 'N/A' }}</span>
                                            <a href="{{ route('product.show', $item->product->slug) }}">
                                                <h4>{{ $item->product->name }}</h4>
                                            </a>
                                            <div class="product_price d-flex align-items-center justify-content-between flex-wrap">
                                                @if($item->product->stock_quantity > 0)
                                                    <button onclick="addToCart({{ $item->product->id }})" class="amaz_primary_btn">
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                            <path d="M0.464844 1.14286C0.464844 0.78782 0.751726 0.5 1.10561 0.5H1.58256C2.39459 0.5 2.88079 1.04771 3.15883 1.55685C3.34414 1.89623 3.47821 2.28987 3.58307 2.64624C3.61147 2.64401 3.64024 2.64286 3.66934 2.64286H14.3464C15.0557 2.64286 15.5679 3.32379 15.3734 4.00811L13.8119 9.50163C13.5241 10.5142 12.6019 11.2124 11.5525 11.2124H6.47073C5.41263 11.2124 4.48508 10.5028 4.20505 9.47909L3.55532 7.10386L2.48004 3.4621L2.47829 3.45572C2.34527 2.96901 2.22042 2.51433 2.03491 2.1746C1.85475 1.84469 1.71115 1.78571 1.58256 1.78571H1.10561C0.751726 1.78571 0.464844 1.49789 0.464844 1.14286ZM4.79882 6.79169L5.44087 9.1388C5.56816 9.60414 5.98978 9.92669 6.47073 9.92669H11.5525C12.0295 9.92669 12.4487 9.60929 12.5795 9.14909L14.0634 3.92857H3.95529L4.78706 6.74583C4.79157 6.76109 4.79548 6.77634 4.79882 6.79169ZM7.72683 13.7857C7.72683 14.7325 6.96184 15.5 6.01812 15.5C5.07443 15.5 4.30942 14.7325 4.30942 13.7857C4.30942 12.8389 5.07443 12.0714 6.01812 12.0714C6.96184 12.0714 7.72683 12.8389 7.72683 13.7857ZM6.4453 13.7857C6.4453 13.5491 6.25405 13.3571 6.01812 13.3571C5.7822 13.3571 5.59095 13.5491 5.59095 13.7857C5.59095 14.0224 5.7822 14.2143 6.01812 14.2143C6.25405 14.2143 6.4453 14.0224 6.4453 13.7857ZM13.7073 13.7857C13.7073 14.7325 12.9423 15.5 11.9986 15.5C11.0549 15.5 10.2899 14.7325 10.2899 13.7857C10.2899 12.8389 11.0549 12.0714 11.9986 12.0714C12.9423 12.0714 13.7073 12.8389 13.7073 13.7857ZM12.4258 13.7857C12.4258 13.5491 12.2345 13.3571 11.9986 13.3571C11.7627 13.3571 11.5714 13.5491 11.5714 13.7857C11.5714 14.0224 11.7627 14.2143 11.9986 14.2143C12.2345 14.2143 12.4258 14.0224 12.4258 13.7857Z" fill="currentColor"/>
                                                        </svg>
                                                        Add to Cart
                                                    </button>
                                                @else
                                                    <button class="amaz_primary_btn" disabled>
                                                        Out of Stock
                                                    </button>
                                                @endif
                                                <p>
                                                    @if($item->product->sale_price && $item->product->sale_price < $item->product->price)
                                                        <strong>KES {{ number_format($item->product->sale_price, 0) }}</strong>
                                                        <span class="text-muted text-decoration-line-through">KES {{ number_format($item->product->price, 0) }}</span>
                                                    @else
                                                        <strong>KES {{ number_format($item->product->price, 0) }}</strong>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @else
                        <!-- Not logged in state -->
                        <div class="empty_wishlist text-center">
                            <div class="empty_icon mb_30">
                                <i class="fas fa-user-lock" style="font-size: 80px; color: #fd4949;"></i>
                            </div>
                            <h4 class="mb_20">Please login to view your wishlist</h4>
                            <p class="mb_30">You need to be logged in to save and view your favorite items.</p>
                            <a href="{{ route('login') }}" class="amaz_primary_btn me-2">Login</a>
                            <a href="{{ route('register') }}" class="amaz_primary_btn style2">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
<!-- wishlist_content::end  -->
@endsection
