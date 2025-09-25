@extends('layouts.main')

@section('content')
<style>
/* Product Detail Page Styles */
.product_detail_area {
    background: var(--background_color);
    padding: 40px 0;
}

.product-detail-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.product-gallery {
    position: relative;
}

.main-image-container {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    background: #f8f9fa;
}

.main-product-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.main-product-image:hover {
    transform: scale(1.05);
}

.zoom-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 5px 8px;
    border-radius: 4px;
    font-size: 12px;
}

.thumbnail-gallery {
    margin-top: 15px;
}

.thumbnail-container {
    display: flex;
    gap: 10px;
    overflow-x: auto;
}

.thumbnail-item {
    flex-shrink: 0;
}

.thumbnail-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: border-color 0.3s ease;
}

.thumbnail-image.active,
.thumbnail-image:hover {
    border-color: var(--base_color);
}

.product-info-section {
    padding: 20px;
}

.product-title {
    font-size: 28px;
    font-weight: 700;
    color: var(--text_color);
    margin-bottom: 10px;
    line-height: 1.2;
}

.vendor-badge-container {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 15px;
}

.vendor-label {
    font-size: 14px;
    color: #6c757d;
}

.vendor-badge {
    background: var(--base_color_10);
    color: var(--base_color);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.rating-section {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.stars-container {
    display: flex;
    gap: 2px;
}

.star-filled {
    color: #ffc107;
}

.star-empty {
    color: #e4e5e9;
}

.rating-text {
    font-size: 14px;
    color: #6c757d;
}

.price-container {
    margin-bottom: 25px;
}

.current-price {
    font-size: 32px;
    font-weight: 700;
    color: var(--base_color);
}

.original-price {
    font-size: 18px;
    color: #6c757d;
    text-decoration: line-through;
    margin-left: 10px;
}

.discount-badge {
    background: #dc3545;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    margin-left: 10px;
}

.quantity-section {
    margin-bottom: 25px;
}

.quantity-label {
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 10px;
    max-width: 150px;
}

.quantity-btn {
    width: 40px;
    height: 40px;
    border: 1px solid #dee2e6;
    background: white;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quantity-btn:hover {
    background: var(--base_color);
    color: white;
    border-color: var(--base_color);
}

.quantity-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.quantity-input {
    flex: 1;
    text-align: center;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 8px;
    font-weight: 600;
}

.action-buttons {
    margin-bottom: 20px;
}

.add-to-cart-btn {
    width: 100%;
    background: var(--base_color);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.add-to-cart-btn:hover {
    background: var(--base_color);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 111, 32, 0.3);
}

.add-to-cart-btn:disabled {
    background: #6c757d;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.secondary-actions {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.secondary-btn {
    flex: 1;
    background: white;
    color: var(--text_color);
    border: 2px solid #dee2e6;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.secondary-btn:hover {
    border-color: var(--base_color);
    color: var(--base_color);
    background: var(--base_color_10);
}

.secondary-btn.is_wishlist {
    border-color: #dc3545;
    color: #dc3545;
    background: #dc35451a;
}

.secondary-btn.is_compare {
    border-color: var(--base_color);
    color: var(--base_color);
    background: var(--base_color_10);
}

.product-meta {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-top: 20px;
}

.product-meta strong {
    color: var(--text_color);
}

/* Compare button specific styles */
.compare-btn {
    position: relative;
    overflow: hidden;
}

.compare-btn:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.5s;
}

.compare-btn:hover:before {
    left: 100%;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .product-title {
        font-size: 24px;
    }
    
    .current-price {
        font-size: 28px;
    }
    
    .secondary-actions {
        flex-direction: column;
    }
    
    .main-product-image {
        height: 300px;
    }
}
</style>

<div class="product_detail_area" style="background: var(--background_color); padding: 40px 0;">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb modern-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories') }}">Categories</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="{{ route('category.products', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Product Details -->
        <div class="product-detail-card">
            <div class="row g-5">
                <!-- Product Images -->
                <div class="col-lg-6">
                    <div class="product-gallery">
                        <div class="main-image-container">
                            @if($product->main_image)
                                @if(str_starts_with($product->main_image, 'frontend/'))
                                    <img src="{{ asset($product->main_image) }}"
                                         class="main-product-image"
                                         alt="{{ $product->name }}"
                                         id="mainProductImage">
                                @else
                                    <img src="{{ Storage::url($product->main_image) }}"
                                         class="main-product-image"
                                         alt="{{ $product->name }}"
                                         id="mainProductImage">
                                @endif
                            @else
                                <img src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}"
                                     class="main-product-image"
                                     alt="{{ $product->name }}"
                                     id="mainProductImage">
                            @endif

                            <!-- Image Zoom Badge -->
                            <div class="zoom-badge">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>

                        @if($product->images && count($product->images) > 0)
                            <div class="thumbnail-gallery">
                                <div class="thumbnail-container">
                                    @if($product->main_image)
                                    <div class="thumbnail-item">
                                        @if(str_starts_with($product->main_image, 'frontend/'))
                                            <img src="{{ asset($product->main_image) }}"
                                                 class="thumbnail-image active"
                                                 alt="{{ $product->name }}"
                                                 onclick="changeMainImage(this, '{{ asset($product->main_image) }}')">
                                        @else
                                            <img src="{{ Storage::url($product->main_image) }}"
                                                 class="thumbnail-image active"
                                                 alt="{{ $product->name }}"
                                                 onclick="changeMainImage(this, '{{ Storage::url($product->main_image) }}')">
                                        @endif
                                    </div>
                                    @endif
                                    @foreach($product->images as $image)
                                        <div class="thumbnail-item">
                                            <img src="{{ Storage::url($image) }}"
                                                 class="thumbnail-image"
                                                 alt="{{ $product->name }}"
                                                 onclick="changeMainImage(this, '{{ Storage::url($image) }}')">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6">
                    <div class="product-info-section">
                        <!-- Product Title -->
                        <h1 class="product-title">{{ $product->name }}</h1>

                        <!-- Vendor Badge -->
                        <div class="vendor-badge-container">
                            <span class="vendor-label">Sold by</span>
                            <span class="vendor-badge">{{ $product->vendor->name ?? 'Vendor' }}</span>
                        </div>

                        <!-- Rating Section -->
                        <div class="rating-section">
                            <div class="stars-container">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($product->rating ?? 0))
                                        <i class="fas fa-star star-filled"></i>
                                    @else
                                        <i class="far fa-star star-empty"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-text">({{ $product->review_count ?? 0 }} reviews)</span>
                        </div>

                        <!-- Price Section -->
                        <div class="price-container">
                            @if($product->sale_price && $product->price > $product->sale_price)
                                <div class="price-wrapper">
                                    <span class="current-price">KSh {{ number_format($product->sale_price, 0) }}</span>
                                    <span class="original-price">KSh {{ number_format($product->price, 0) }}</span>
                                </div>
                                <div class="discount-badge">
                                    <span class="discount-text">{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF</span>
                                </div>
                            @else
                                <div class="price-wrapper">
                                    <span class="current-price">KSh {{ number_format($product->price, 0) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        <div class="stock-status-container">
                            @if($product->stock_quantity > 0)
                                <div class="stock-badge in-stock">
                                    <i class="fas fa-check-circle"></i>
                                    <span>In Stock ({{ $product->stock_quantity }} available)</span>
                                </div>
                            @else
                                <div class="stock-badge out-of-stock">
                                    <i class="fas fa-times-circle"></i>
                                    <span>Out of Stock</span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Flags -->
                        <div class="product-badges">
                            @if($product->is_new)
                                <span class="product-badge new-badge">New</span>
                            @endif
                            @if($product->is_featured)
                                <span class="product-badge featured-badge">Featured</span>
                            @endif
                            @if($product->is_bestseller)
                                <span class="product-badge bestseller-badge">Best Seller</span>
                            @endif
                        </div>

                        <!-- Product Description Preview -->
                        <div class="description-preview">
                            <p>{{ Str::limit($product->description ?? 'No description available.', 150) }}</p>
                        </div>

                        <!-- Purchase Section -->
                        <div class="purchase-section">
                            <div class="quantity-selector">
                                <label class="quantity-label">Quantity</label>
                                <div class="quantity-controls">
                                    <button class="quantity-btn decrease" type="button" onclick="decreaseQuantity()">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="quantity-input" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}">
                                    <button class="quantity-btn increase" type="button" onclick="increaseQuantity()">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="action-buttons">
                                <button class="add-to-cart-btn" onclick="addToCart({{ $product->id }})" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Add to Cart</span>
                                </button>
                            </div>
                        </div>

                        <!-- Secondary Actions -->
                        <div class="secondary-actions">
                            <button class="secondary-btn wishlist-btn" onclick="addToWishlist({{ $product->id }})">
                                <i class="far fa-heart"></i>
                                <span>Add to Wishlist</span>
                            </button>
                            <button class="secondary-btn compare-btn" onclick="addToCompare({{ $product->id }})">
                                <i class="fas fa-exchange-alt"></i>
                                <span>Compare</span>
                            </button>
                        </div>

                            <!-- Product Meta -->
                            <div class="product-meta">
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">SKU:</small><br>
                                        <strong>{{ $product->sku }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Category:</small><br>
                                        <strong>{{ $product->category->name ?? 'Uncategorized' }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="row">
                    <div class="col-12">
                        <div class="product-description">
                            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                                        Description
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab">
                                        Specifications
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                                        Reviews ({{ $product->review_count ?? 0 }})
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="productTabsContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel">
                                    <div class="p-4">
                                        @if($product->description)
                                            {!! nl2br(e($product->description)) !!}
                                        @else
                                            <p class="text-muted">No description available.</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="specifications" role="tabpanel">
                                    <div class="p-4">
                                        @if($product->specifications && count($product->specifications) > 0)
                                            <div class="row">
                                                @foreach($product->specifications as $key => $value)
                                                    <div class="col-md-6 mb-2">
                                                        <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">No specifications available.</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="reviews" role="tabpanel">
                                    <div class="p-4">
                                        @if($product->reviews && $product->reviews->count() > 0)
                                            @foreach($product->reviews as $review)
                                                <div class="review-item border-bottom pb-3 mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                                                            <div class="rating">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    @if($i <= $review->rating)
                                                                        <i class="fas fa-star text-warning"></i>
                                                                    @else
                                                                        <i class="far fa-star"></i>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <p class="mt-2">{{ $review->comment }}</p>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.thumbnail-image {
    cursor: pointer;
    transition: all 0.3s ease;
}

.thumbnail-image:hover {
    transform: scale(1.05);
}

.thumbnail-image.active {
    border-color: #007bff;
}

.product-info h1 {
    color: #333;
    font-size: 2rem;
}

.price-section .h3 {
    color: #007bff;
}

.stock-status {
    font-size: 1.1rem;
}

.product-actions .btn {
    transition: all 0.3s ease;
}

.product-actions .btn:hover {
    transform: translateY(-2px);
}

.nav-tabs .nav-link {
    color: #666;
    border: none;
    border-bottom: 2px solid transparent;
}

.nav-tabs .nav-link.active {
    color: #007bff;
    border-bottom-color: #007bff;
    background: none;
}

.tab-content {
    border: 1px solid #dee2e6;
    border-top: none;
    border-radius: 0 0 5px 5px;
}

.review-item:last-child {
    border-bottom: none !important;
}
</style>

<script>
function changeMainImage(thumbnail, imageSrc) {
    document.getElementById('mainProductImage').src = imageSrc;

    // Remove active class from all thumbnails
    document.querySelectorAll('.thumbnail-image').forEach(img => {
        img.classList.remove('active');
    });

    // Add active class to clicked thumbnail
    thumbnail.classList.add('active');
}

function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    const addToCartBtn = document.querySelector('.add-to-cart-btn');

    // Disable button and show loading state
    addToCartBtn.disabled = true;
    addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Adding...</span>';

    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message using toastr if available, otherwise alert
            if (typeof toastr !== 'undefined') {
                toastr.success(data.message, "Success");
            } else {
                alert(data.message);
            }

            // Update cart count in header
            const cartCountElements = document.querySelectorAll('.cart_count_bottom, .cart-count');
            cartCountElements.forEach(element => {
                element.textContent = data.cart_count || data.count_bottom;
            });

            // Update cart submenu if it exists
            if (data.cart_details_submenu) {
                const cartSubmenu = document.querySelector('.cart-submenu-container');
                if (cartSubmenu) {
                    cartSubmenu.innerHTML = data.cart_details_submenu;
                }
            }
        } else {
            // Show error message
            if (typeof toastr !== 'undefined') {
                toastr.error(data.message, "Error");
            } else {
                alert(data.message);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof toastr !== 'undefined') {
            toastr.error('An error occurred while adding the product to cart.', "Error");
        } else {
            alert('An error occurred while adding the product to cart.');
        }
    })
    .finally(() => {
        // Re-enable button and restore original text
        addToCartBtn.disabled = false;
        addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart"></i> <span>Add to Cart</span>';
    });
}

function addToWishlist(productId) {
    // Check if user is logged in
    let is_login = $('#login_check').val();
    if (is_login != 1) {
        if (typeof toastr !== 'undefined') {
            toastr.warning("Please login first", "Warning");
        } else {
            alert("Please login first");
        }
        return;
    }

    const wishlistBtn = document.querySelector('.wishlist-btn');
    if (wishlistBtn) {
        wishlistBtn.disabled = true;
        wishlistBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Adding...</span>';
    }

    // Show preloader if it exists
    const preloader = document.getElementById('pre-loader');
    if (preloader) preloader.style.display = 'block';

    const formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('product_id', productId);

    $.ajax({
        url: '{{ route("wishlist.store") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.result == 1) {
                if (typeof toastr !== 'undefined') {
                    toastr.success(response.message, "Success");
                } else {
                    alert(response.message);
                }

                // Update wishlist count if element exists
                const wishlistCountElements = document.querySelectorAll('.wishlist_count');
                wishlistCountElements.forEach(element => {
                    element.textContent = response.totalItems;
                });

                // Update button state
                if (wishlistBtn) {
                    wishlistBtn.classList.add('is_wishlist');
                    wishlistBtn.innerHTML = '<i class="fas fa-heart"></i> <span>Added to Wishlist</span>';
                }
            } else {
                if (typeof toastr !== 'undefined') {
                    toastr.warning(response.message, "Warning");
                } else {
                    alert(response.message);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Wishlist error:', error);
            if (typeof toastr !== 'undefined') {
                toastr.error('An error occurred while adding to wishlist.', "Error");
            } else {
                alert('An error occurred while adding to wishlist.');
            }
        },
        complete: function() {
            // Hide preloader
            if (preloader) preloader.style.display = 'none';

            // Re-enable button
            if (wishlistBtn) {
                wishlistBtn.disabled = false;
                if (!wishlistBtn.classList.contains('is_wishlist')) {
                    wishlistBtn.innerHTML = '<i class="far fa-heart"></i> <span>Add to Wishlist</span>';
                }
            }
        }
    });
}

function addToCompare(productId) {
    const compareBtn = document.querySelector('.compare-btn');
    if (compareBtn) {
        compareBtn.disabled = true;
        compareBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Adding...</span>';
    }

    // Show preloader if it exists
    const preloader = document.getElementById('pre-loader');
    if (preloader) preloader.style.display = 'block';

    const data = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'product_id': productId
    };

    $.post('{{ route("compare.add") }}', data, function(response) {
        if (response.success) {
            if (typeof toastr !== 'undefined') {
                toastr.success(response.message, "Success");
            } else {
                alert(response.message);
            }

            // Update compare count if element exists
            const compareCountElements = document.querySelectorAll('.compare_count');
            compareCountElements.forEach(element => {
                element.textContent = response.totalItems;
            });

            // Update button state
            if (compareBtn) {
                compareBtn.classList.add('is_compare');
                compareBtn.innerHTML = '<i class="fas fa-exchange-alt"></i> <span>Added to Compare</span>';
            }
        } else {
            if (typeof toastr !== 'undefined') {
                toastr.error(response.message, "Error");
            } else {
                alert(response.message);
            }
        }
    })
    .fail(function() {
        if (typeof toastr !== 'undefined') {
            toastr.error("Error adding product to compare", "Error");
        } else {
            alert("Error adding product to compare");
        }
    })
    .always(function() {
        // Hide preloader
        if (preloader) preloader.style.display = 'none';

        // Re-enable button
        if (compareBtn) {
            compareBtn.disabled = false;
            if (!compareBtn.classList.contains('is_compare')) {
                compareBtn.innerHTML = '<i class="fas fa-exchange-alt"></i> <span>Compare</span>';
            }
        }
    });
}

function buyNow(productId) {
    // Add to cart first, then redirect to checkout
    const quantity = document.getElementById('quantity').value;

    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to checkout
            window.location.href = '{{ route("checkout") }}';
        } else {
            if (typeof toastr !== 'undefined') {
                toastr.error(data.message, "Error");
            } else {
                alert(data.message);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (typeof toastr !== 'undefined') {
            toastr.error('An error occurred while processing your request.', "Error");
        } else {
            alert('An error occurred while processing your request.');
        }
    });
}

// Initialize compare count when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Load compare count
    fetch('{{ route("compare.count") }}')
        .then(response => response.json())
        .then(data => {
            const compareCountElements = document.querySelectorAll('.compare_count');
            compareCountElements.forEach(element => {
                element.textContent = data.totalItems;
            });
        })
        .catch(error => {
            console.error('Error loading compare count:', error);
        });

    // Check if current product is in compare list
    const currentProductId = {{ $product->id }};
    fetch(`{{ route('compare.check', ':productId') }}`.replace(':productId', currentProductId))
        .then(response => response.json())
        .then(data => {
            const compareBtn = document.querySelector('.compare-btn');
            if (compareBtn && data.isInCompare) {
                compareBtn.classList.add('is_compare');
                compareBtn.innerHTML = '<i class="fas fa-exchange-alt"></i> <span>Added to Compare</span>';
            }
        })
        .catch(error => {
            console.error('Error checking compare status:', error);
        });
});

function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const maxValue = parseInt(quantityInput.max);

    if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const minValue = parseInt(quantityInput.min);

    if (currentValue > minValue) {
        quantityInput.value = currentValue - 1;
    }
}
</script>

<style>
/* Modern Product Detail Page Styling */
.product_detail_area {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    min-height: 100vh;
}

.modern-breadcrumb {
    background: transparent;
    padding: 0;
    margin-bottom: 2rem;
}

.modern-breadcrumb .breadcrumb-item a {
    color: var(--base_color);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.modern-breadcrumb .breadcrumb-item a:hover {
    color: #e55a1a;
    transform: translateY(-1px);
}

.modern-breadcrumb .breadcrumb-item.active {
    color: #6c757d;
    font-weight: 600;
}

.product-detail-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    padding: 3rem;
    margin-bottom: 3rem;
}

/* Product Gallery Styling */
.product-gallery {
    position: relative;
}

.main-image-container {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    background: #f8f9fa;
    margin-bottom: 1.5rem;
}

.main-product-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.main-product-image:hover {
    transform: scale(1.05);
}

.zoom-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 111, 32, 0.9);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.zoom-badge:hover {
    background: var(--base_color);
    transform: scale(1.1);
}

.thumbnail-gallery {
    margin-top: 1rem;
}

.thumbnail-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.thumbnail-item {
    flex: 0 0 80px;
}

.thumbnail-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 10px;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s ease;
}

.thumbnail-image:hover,
.thumbnail-image.active {
    border-color: var(--base_color);
    transform: scale(1.05);
}

/* Product Info Styling */
.product-info-section {
    padding-left: 2rem;
}

.product-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.vendor-badge-container {
    margin-bottom: 1.5rem;
}

.vendor-label {
    color: #6c757d;
    font-size: 0.9rem;
    margin-right: 0.5rem;
}

.vendor-badge {
    background: linear-gradient(135deg, var(--base_color), #e55a1a);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.9rem;
}

.rating-section {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.stars-container {
    display: flex;
    gap: 2px;
}

.star-filled {
    color: #ffc107;
    font-size: 1.2rem;
}

.star-empty {
    color: #e9ecef;
    font-size: 1.2rem;
}

.rating-text {
    color: #6c757d;
    font-weight: 500;
}

/* Price Styling */
.price-container {
    margin-bottom: 2rem;
}

.price-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.current-price {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--base_color);
}

.original-price {
    font-size: 1.5rem;
    color: #6c757d;
    text-decoration: line-through;
}

.discount-badge {
    display: inline-block;
}

.discount-text {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-weight: 600;
    font-size: 0.8rem;
    animation: pulse 2s infinite;
}

/* Stock Status */
.stock-status-container {
    margin-bottom: 1.5rem;
}

.stock-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.2rem;
    border-radius: 10px;
    font-weight: 600;
    width: fit-content;
}

.stock-badge.in-stock {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
    border: 2px solid rgba(40, 167, 69, 0.2);
}

.stock-badge.out-of-stock {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
    border: 2px solid rgba(220, 53, 69, 0.2);
}

/* Product Badges */
.product-badges {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.product-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.new-badge {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.featured-badge {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
    color: white;
}

.bestseller-badge {
    background: linear-gradient(135deg, #17a2b8, #6f42c1);
    color: white;
}

/* Description Preview */
.description-preview {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid var(--base_color);
}

.description-preview p {
    margin: 0;
    color: #6c757d;
    line-height: 1.6;
}

/* Purchase Section */
.purchase-section {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
}

.quantity-selector {
    margin-bottom: 1.5rem;
}

.quantity-label {
    display: block;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.quantity-controls {
    display: flex;
    align-items: center;
    width: fit-content;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    overflow: hidden;
    background: white;
}

.quantity-btn {
    background: var(--base_color);
    color: white;
    border: none;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quantity-btn:hover {
    background: #e55a1a;
    transform: scale(1.05);
}

.quantity-input {
    border: none;
    width: 80px;
    height: 45px;
    text-align: center;
    font-weight: 600;
    font-size: 1.1rem;
    background: white;
}

.quantity-input:focus {
    outline: none;
    box-shadow: none;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.add-to-cart-btn,
.buy-now-btn {
    flex: 1;
    min-width: 200px;
    padding: 1rem 2rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.add-to-cart-btn {
    background: linear-gradient(135deg, var(--base_color), #e55a1a);
    color: white;
    box-shadow: 0 5px 15px rgba(255, 111, 32, 0.3);
}

.add-to-cart-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 111, 32, 0.4);
}

.buy-now-btn {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
}

.buy-now-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
}

.add-to-cart-btn:disabled,
.buy-now-btn:disabled {
    background: #6c757d;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-detail-card {
        padding: 1.5rem;
    }

    .product-info-section {
        padding-left: 0;
        margin-top: 2rem;
    }

    .product-title {
        font-size: 2rem;
    }

    .current-price {
        font-size: 2rem;
    }

    .action-buttons {
        flex-direction: column;
    }

    .add-to-cart-btn,
    .buy-now-btn {
        min-width: 100%;
    }
}

/* Animation */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

/* Product tabs styling */
.nav-tabs {
    border-bottom: 2px solid #e9ecef;
    margin-bottom: 2rem;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 600;
    padding: 1rem 2rem;
    border-radius: 10px 10px 0 0;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link.active {
    background: var(--base_color);
    color: white;
    border-bottom: 3px solid var(--base_color);
}

.nav-tabs .nav-link:hover {
    color: var(--base_color);
    transform: translateY(-2px);
}

.tab-content {
    padding: 2rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Secondary Actions */
.secondary-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
}

.secondary-btn {
    flex: 1;
    padding: 0.8rem 1.5rem;
    border: 2px solid #e9ecef;
    background: white;
    border-radius: 10px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #6c757d;
}

.secondary-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.wishlist-btn:hover {
    border-color: #dc3545;
    color: #dc3545;
    background: rgba(220, 53, 69, 0.05);
}

.compare-btn:hover {
    border-color: #17a2b8;
    color: #17a2b8;
    background: rgba(23, 162, 184, 0.05);
}

/* Product Meta Styling */
.product-meta {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 2rem;
}

.product-meta .row > div {
    margin-bottom: 1rem;
}

.product-meta small {
    color: #6c757d;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.8rem;
}

.product-meta strong {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1rem;
}

/* Additional responsive improvements */
@media (max-width: 576px) {
    .secondary-actions {
        flex-direction: column;
    }

    .thumbnail-container {
        justify-content: center;
    }

    .quantity-controls {
        margin: 0 auto;
    }

    .secondary-btn {
        min-height: 50px;
        font-size: 1rem;
    }

    .add-to-cart-btn,
    .buy-now-btn {
        min-height: 55px;
        font-size: 1.1rem;
    }
}

/* Button loading states */
.add-to-cart-btn:disabled,
.wishlist-btn:disabled,
.compare-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.add-to-cart-btn .fa-spinner,
.wishlist-btn .fa-spinner,
.compare-btn .fa-spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Success states */
.wishlist-btn.is_wishlist {
    border-color: #dc3545;
    color: #dc3545;
    background: rgba(220, 53, 69, 0.1);
}

.compare-btn.is_compare {
    border-color: #17a2b8;
    color: #17a2b8;
    background: rgba(23, 162, 184, 0.1);
}

/* Touch-friendly improvements for mobile */
@media (max-width: 768px) {
    .secondary-btn,
    .add-to-cart-btn,
    .buy-now-btn {
        touch-action: manipulation;
        -webkit-tap-highlight-color: transparent;
    }

    .quantity-btn {
        min-width: 50px;
        min-height: 50px;
    }

    .quantity-input {
        min-height: 50px;
        font-size: 1.2rem;
    }
}
</style>
@endsection
