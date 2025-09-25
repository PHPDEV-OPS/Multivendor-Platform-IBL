@extends('layouts.main')

@section('content')
<!-- Category Banner -->
@include('components.promotion-banner', ['position' => 'category_banner'])

<div class="prodcuts_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section__title mb-4">
                    <h2 class="text-center">Shop by Category</h2>
                    <p class="text-center text-muted">Discover products from our trusted vendors</p>
                </div>
                
                @if($categories->count() > 0)
                    <div class="row">
                        @foreach($categories as $category)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="category-card h-100">
                                    <div class="parent-category">
                                        <a href="{{ route('category.products', $category->slug) }}" class="text-decoration-none">
                                            <div class="parent-category text-center">
                                                <div class="parent-img mb-3">
                                                    <img src="{{ $category->icon ? (str_starts_with($category->icon, 'frontend/') ? asset($category->icon) : Storage::url($category->icon)) : asset('frontend/amazy/img/67b5a3c9e4224.png') }}" 
                                                         class="category-image rounded" 
                                                         alt="{{ $category->name }}"
                                                         style="width: 120px; height: 120px; object-fit: cover;">
                                                </div>
                                                <div class="parent-name">
                                                    <h5 class="mb-2">{{ $category->name }}</h5>
                                                    <div class="category-stats">
                                                        @if($category->products_count > 0)
                                                            <span class="badge bg-primary me-2">{{ $category->products_count }} products</span>
                                                        @else
                                                            <span class="badge bg-secondary me-2">No products</span>
                                                        @endif
                                                        @if($category->children_count > 0)
                                                            <span class="badge bg-info">{{ $category->children_count }} subcategories</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    
                                    @if($category->children->count() > 0)
                                        <div class="child-categories mt-3">
                                            <h6 class="mb-2">Subcategories:</h6>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($category->children->take(4) as $childCategory)
                                                    <a class="child-category badge bg-light text-dark text-decoration-none" 
                                                       href="{{ route('category.products', $childCategory->slug) }}">
                                                        {{ $childCategory->name }}
                                                        @if($childCategory->products_count > 0)
                                                            <span class="badge bg-primary ms-1">{{ $childCategory->products_count }}</span>
                                                        @endif
                                                    </a>
                                                @endforeach
                                                @if($category->children->count() > 4)
                                                    <span class="badge bg-secondary">+{{ $category->children->count() - 4 }} more</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-folder fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No categories found</h5>
                        <p class="text-muted">Categories will appear here once they are created by administrators.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.category-card {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 20px;
    transition: all 0.3s ease;
    background: white;
}

.category-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.parent-category a {
    color: inherit;
}

.parent-category a:hover {
    color: inherit;
}

.category-image {
    transition: transform 0.3s ease;
}

.category-card:hover .category-image {
    transform: scale(1.05);
}

.category-stats {
    margin-top: 10px;
}

.child-category {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
    transition: all 0.3s ease;
}

.child-category:hover {
    background-color: #007bff !important;
    color: white !important;
}
</style>
@endsection