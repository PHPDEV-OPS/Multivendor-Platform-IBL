@props(['product'])

<div class="product_widget5 mb_30 style5">
    <div class="product_thumb_upper">
        <a href="{{ route('product.show', $product->slug) }}" class="thumb">
            <img data-src="{{ $product->main_image ? (str_starts_with($product->main_image, 'frontend/') ? asset($product->main_image) : Storage::url($product->main_image)) : asset('frontend/amazy/img/67b5a3c9e4224.png') }}"
                src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}"
                alt="{{ $product->name }}"
                title="{{ $product->name }}"
                class="lazyload">
        </a>
        <div class="product_action">
            <a href="javascript:void(0)" class="addToCompareFromThumnail" data-producttype="1"
                data-seller="{{ $product->vendor_id }}" data-product-sku="{{ $product->id }}" data-product-id="{{ $product->id }}">
                <i class="ti-control-shuffle" title="Compare"></i>
            </a>
            <a href="javascript:void(0)" class="add_to_wishlist" id="wishlistbtn_{{ $product->id }}"
                data-product_id="{{ $product->id }}" data-seller_id="{{ $product->vendor_id }}">
                <i class="far fa-heart" title="Wishlist"></i>
            </a>
            <a class="quickView" data-product_id="{{ $product->id }}" data-type="product">
                <i class="ti-eye" title="Quick View"></i>
            </a>
        </div>
        <div class="product_badge">
            @if($product->sale_price && $product->price > $product->sale_price)
                <span class="badge bg-danger">{{ $product->discount_percentage }}% OFF</span>
            @endif
            @if($product->is_new)
                <span class="badge bg-success">New</span>
            @endif
            @if($product->is_featured)
                <span class="badge bg-warning">Featured</span>
            @endif
        </div>
    </div>
    <div class="product_star mx-auto">
        @for($i = 1; $i <= 5; $i++)
            @if($i <= ($product->rating ?? 0))
                <i class="fas fa-star text-warning"></i>
            @else
                <i class="far fa-star"></i>
            @endif
        @endfor
    </div>
    <div class="product__meta text-center">
        <span class="product_banding">{{ $product->vendor->name ?? 'Vendor' }}</span>
        <a href="{{ route('product.show', $product->slug) }}">
            <h4>{{ Str::limit($product->name, 50) }}</h4>
        </a>

        <div class="product_price d-flex align-items-center justify-content-between flex-wrap">
            <a class="amaz_primary_btn addToCartFromThumnail" 
               data-producttype="1" 
               data-seller="{{ $product->vendor_id }}"
               data-product-sku="{{ $product->id }}" 
               data-base-price="{{ $product->final_price }}" 
               data-shipping-method="0" 
               data-product-id="{{ $product->id }}"
               data-stock_manage="1" 
               data-stock="{{ $product->stock_quantity }}" 
               data-min_qty="1"
               data-prod_info="{{ json_encode([
                   'name' => $product->name,
                   'url' => route('product.show', $product->slug),
                   'price' => 'KSh ' . number_format($product->final_price, 2),
                   'thumbnail' => $product->main_image ? (str_starts_with($product->main_image, 'frontend/') ? asset($product->main_image) : Storage::url($product->main_image)) : asset('frontend/amazy/img/67b5a3c9e4224.png')
               ]) }}">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path
                        d="M0.464844 1.14286C0.464844 0.78782 0.751726 0.5 1.10561 0.5H1.58256C2.39459 0.5 2.88079 1.04771 3.15883 1.55685C3.34414 1.89623 3.47821 2.28987 3.58307 2.64624C3.61147 2.64401 3.64024 2.64286 3.66934 2.64286H14.3464C15.0557 2.64286 15.5679 3.32379 15.3734 4.00811L13.8119 9.50163C13.5241 10.5142 12.6019 11.2124 11.5525 11.2124H6.47073C5.41263 11.2124 4.48508 10.5028 4.20505 9.47909L3.55532 7.10386L2.48004 3.4621L2.47829 3.45572C2.34527 2.96901 2.22042 2.51433 2.03491 2.1746C1.85475 1.84469 1.71115 1.78571 1.58256 1.78571H1.10561C0.751726 1.78571 0.464844 1.49789 0.464844 1.14286ZM4.79882 6.79169L5.44087 9.1388C5.56816 9.60414 5.98978 9.92669 6.47073 9.92669H11.5525C12.0295 9.92669 12.4487 9.60929 12.5795 9.14909L14.0634 3.92857H3.95529L4.78706 6.74583C4.79157 6.76109 4.79548 6.77634 4.79882 6.79169ZM7.72683 13.7857C7.72683 14.7325 6.96184 15.5 6.01812 15.5C5.07443 15.5 4.30942 14.7325 4.30942 13.7857C4.30942 12.8389 5.07443 12.0714 6.01812 12.0714C6.96184 12.0714 7.72683 12.8389 7.72683 13.7857ZM6.4453 13.7857C6.4453 13.5491 6.25405 13.3571 6.01812 13.3571C5.7822 13.3571 5.59095 13.5491 5.59095 13.7857C5.59095 14.0224 5.7822 14.2143 6.01812 14.2143C6.25405 14.2143 6.4453 14.0224 6.4453 13.7857ZM13.7073 13.7857C13.7073 14.7325 12.9423 15.5 11.9986 15.5C11.0549 15.5 10.2899 14.7325 10.2899 13.7857C10.2899 12.8389 11.0549 12.0714 11.9986 12.0714C12.9423 12.0714 13.7073 12.8389 13.7073 13.7857ZM12.4258 13.7857C12.4258 13.5491 12.2345 13.3571 11.9986 13.3571C11.7627 13.3571 11.5714 13.5491 11.5714 13.7857C11.5714 14.0224 11.7627 14.2143 11.9986 14.2143C12.2345 14.2143 12.4258 14.0224 12.4258 13.7857Z"
                        fill="currentColor" />
                </svg>
                Add to Cart
            </a>
            <p>
                <strong>
                    @if($product->sale_price && $product->price > $product->sale_price)
                        <span class="text-decoration-line-through text-muted">KSh {{ number_format($product->price, 0) }}</span><br>
                        <span class="text-danger">KSh {{ number_format($product->sale_price, 0) }}</span>
                    @else
                        KSh {{ number_format($product->price, 0) }}
                    @endif
                </strong>
            </p>
        </div>
    </div>
</div>
