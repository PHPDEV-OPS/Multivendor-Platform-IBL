@extends('layouts.main')

@section('content')
<!-- Category Banner -->
@include('components.promotion-banner', ['position' => 'category_banner'])

<div class="prodcuts_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('categories') }}">Categories</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                    </ol>
                </nav>

                <!-- Category Header -->
                <div class="category-header mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="mb-2">{{ $category->name }}</h1>
                            @if($category->description)
                                <p class="text-muted mb-0">{{ $category->description }}</p>
                            @endif
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-flex align-items-center justify-content-end">
                                <span class="text-muted me-3">{{ $products->total() }} products</span>
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Sort by
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest</a></li>
                                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}">Price: Low to High</a></li>
                                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}">Price: High to Low</a></li>
                                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}">Highest Rated</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subcategories -->
                @if($category->children->count() > 0)
                    <div class="subcategories mb-4">
                        <h5 class="mb-3">Subcategories:</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($category->children as $childCategory)
                                <a class="badge bg-light text-dark text-decoration-none p-2" 
                                   href="{{ route('category.products', $childCategory->slug) }}">
                                    {{ $childCategory->name }}
                                    @if($childCategory->products_count > 0)
                                        <span class="badge bg-primary ms-1">{{ $childCategory->products_count }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <x-vendor-product-card :product="$product" />
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-box fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No products found in this category</h5>
                        <p class="text-muted">Check back later for new products from our vendors.</p>
                        <a href="{{ route('categories') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Back to Categories
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.category-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 10px;
    margin-bottom: 2rem;
}

.category-header h1 {
    color: white;
    margin: 0;
}

.subcategories .badge {
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.subcategories .badge:hover {
    background-color: #007bff !important;
    color: white !important;
    transform: translateY(-1px);
}

.breadcrumb-item a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}
</style>
@endsection
