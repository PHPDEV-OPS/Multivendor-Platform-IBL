@extends('layouts.main')

@section('content')
<style>
/* Hot Categories Carousel Mobile Styles */
.hot_categories_active {
    overflow: hidden;
    position: relative;
}

.hot_categories_active .item {
    padding: 0 10px;
    transition: all 0.3s ease;
}

.hot_categories_active .amaz_home_cartBox {
    min-height: 120px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.hot_categories_active .amaz_home_cartBox:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Smooth scrolling indicator */
.hot_categories_active::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg,
        rgba(255,255,255,0.8) 0%,
        transparent 10%,
        transparent 90%,
        rgba(255,255,255,0.8) 100%);
    pointer-events: none;
    z-index: 1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.hot_categories_active.smooth-scroll-active::before {
    opacity: 1;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .hot_categories_active .amaz_home_cartBox {
        padding: 15px 20px;
        min-height: 100px;
    }

    .hot_categories_active .amaz_home_cartBox .img_box {
        width: 80px;
        height: 80px;
    }

    .hot_categories_active .amaz_home_cartBox .amazcat_text_box h4 a {
        font-size: 16px;
    }

    .hot_categories_active .amaz_home_cartBox .amazcat_text_box p {
        font-size: 12px;
        margin: 2px 0 15px 0;
    }

    .hot_categories_active .amaz_home_cartBox .amazcat_text_box .shop_now_text {
        font-size: 12px;
    }
}

@media (max-width: 576px) {
    .hot_categories_active .amaz_home_cartBox {
        padding: 12px 15px;
        min-height: 90px;
    }

    .hot_categories_active .amaz_home_cartBox .img_box {
        width: 60px;
        height: 60px;
    }

    .hot_categories_active .amaz_home_cartBox .amazcat_text_box h4 a {
        font-size: 14px;
    }
}

/* Owl Carousel Navigation Styles */
.hot_categories_active .owl-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    pointer-events: none;
}

.hot_categories_active .owl-nav button {
    position: absolute;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.9) !important;
    border: 1px solid #ddd !important;
    border-radius: 50%;
    color: #333 !important;
    font-size: 18px;
    pointer-events: auto;
    transition: all 0.3s ease;
}

.hot_categories_active .owl-nav button:hover {
    background: #fff !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.hot_categories_active .owl-nav .owl-prev {
    left: -20px;
}

.hot_categories_active .owl-nav .owl-next {
    right: -20px;
}

@media (max-width: 768px) {
    .hot_categories_active .owl-nav {
        display: none;
    }
}
</style>

<!-- home_banner::start  -->
@include('visitors.includes.banner')
<!-- home_banner::end  -->

<!-- Featured Products Section -->
@if($featuredProducts->count() > 0)
    <div id="featured_products" class="amaz_section section_spacing">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section__title d-flex align-items-center gap-3 mb_30 flex-wrap">
                        <h3 class="m-0 flex-fill">Featured Products</h3>
                        <a href="{{ route('categories') }}" class="title_link d-flex align-items-center lh-1">
                            <span class="title_text">View All</span>
                            <span class="title_icon">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="trending_product_active owl-carousel">
                        @foreach($featuredProducts as $product)
                            <x-vendor-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Best Sellers Section -->
@if($bestSellers->count() > 0)
    <div id="best_sellers" class="amaz_section section_spacing">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section__title d-flex align-items-center gap-3 mb_30 flex-wrap">
                        <h3 class="m-0 flex-fill">Best Sellers</h3>
                        <a href="{{ route('categories') }}" class="title_link d-flex align-items-center lh-1">
                            <span class="title_text">View All</span>
                            <span class="title_icon">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="trending_product_active owl-carousel">
                        @foreach($bestSellers as $product)
                            <x-vendor-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- New Products Section -->
@if($newProducts->count() > 0)
    <div id="new_products" class="amaz_section section_spacing">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section__title d-flex align-items-center gap-3 mb_30 flex-wrap">
                        <h3 class="m-0 flex-fill">New Arrivals</h3>
                        <a href="{{ route('categories') }}" class="title_link d-flex align-items-center lh-1">
                            <span class="title_text">View All</span>
                            <span class="title_icon">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="trending_product_active owl-carousel">
                        @foreach($newProducts as $product)
                            <x-vendor-product-card :product="$product" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Hot Categories Section -->
<div id="feature_categories" class="amaz_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title d-flex align-items-center gap-3 mb_30 flex-wrap">
                    <h3 class="m-0 flex-fill">Hot Categories</h3>
                    <a href="{{ route('categories') }}" class="title_link d-flex align-items-center lh-1">
                        <span class="title_text">View All</span>
                        <span class="title_icon">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="hot_categories_active owl-carousel">
                    @php
                        $categories = \App\Models\Category::with(['products' => function($query) {
                            $query->where('status', 'active')->where('stock_quantity', '>', 0);
                        }])->active()->root()->take(8)->get();
                    @endphp
                    @foreach($categories as $category)
                        <div class="item">
                            <div class="amaz_home_cartBox amaz_cat_bg1 d-flex justify-content-between mb_30">
                                <div class="img_box">
                                    <img class="lazyload"
                                         src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}"
                                         data-src="{{ $category->icon ? (str_starts_with($category->icon, 'frontend/') ? asset($category->icon) : Storage::url($category->icon)) : asset('frontend/amazy/img/67b5a3c9e4224.png') }}"
                                         alt="{{ $category->name }}"
                                         title="{{ $category->name }}">
                                </div>
                                <div class="amazcat_text_box">
                                    <h4>
                                        <a href="{{ route('category.products', $category->slug) }}">{{ $category->name }}</a>
                                    </h4>
                                    <p class="lh-1">{{ $category->products->count() }} Products</p>
                                    <a class="shop_now_text" href="{{ route('category.products', $category->slug) }}">Shop now »</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Banner Section -->
@include('components.promotion-banner', ['position' => 'cta_banner'])

<!-- Top Rated Products Section -->
<div class="amaz_section section_spacing3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav amzcart_tabs d-flex align-items-center justify-content-center flex-wrap" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="top_rating-tab" data-bs-toggle="tab" data-bs-target="#top_rating" type="button" role="tab">
                            <span>Top Rating</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="people_choices-tab" data-bs-toggle="tab" data-bs-target="#people_choices" type="button" role="tab">
                            <span>People Choices</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="top_picks-tab" data-bs-toggle="tab" data-bs-target="#top_picks" type="button" role="tab">
                            <span>Top Picks</span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="col-xl-12">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="top_rating" role="tabpanel">
                        <div class="amaz_fieature_active fieature_crousel_area owl-carousel">
                            @php
                                $topRatedProducts = \App\Models\Product::with(['vendor', 'category'])
                                    ->where('status', 'active')
                                    ->where('stock_quantity', '>', 0)
                                    ->orderBy('rating', 'desc')
                                    ->take(6)
                                    ->get();
                            @endphp
                            @foreach($topRatedProducts as $product)
                                <x-vendor-product-card :product="$product" />
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="people_choices" role="tabpanel">
                        <div class="amaz_fieature_active fieature_crousel_area owl-carousel">
                            @php
                                $peopleChoices = \App\Models\Product::with(['vendor', 'category'])
                                    ->where('status', 'active')
                                    ->where('stock_quantity', '>', 0)
                                    ->orderBy('sold_count', 'desc')
                                    ->take(6)
                                    ->get();
                            @endphp
                            @foreach($peopleChoices as $product)
                                <x-vendor-product-card :product="$product" />
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-pane fade" id="top_picks" role="tabpanel">
                        <div class="amaz_fieature_active fieature_crousel_area owl-carousel">
                            @php
                                $topPicks = \App\Models\Product::with(['vendor', 'category'])
                                    ->where('status', 'active')
                                    ->where('stock_quantity', '>', 0)
                                    ->where('is_featured', true)
                                    ->take(6)
                                    ->get();
                            @endphp
                            @foreach($topPicks as $product)
                                <x-vendor-product-card :product="$product" />
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
