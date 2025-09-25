@extends('vendor.layouts.app')

@section('page-title', 'Products')
@section('page-subtitle', 'Manage your product catalog')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Products</h4>
        <p class="text-muted mb-0">Manage your product catalog</p>
    </div>
    <a href="{{ route('vendor.products.create') }}" class="vendor-btn">
        <i class="fas fa-plus"></i> Add New Product
    </a>
</div>

<!-- Filters and Search -->
<div class="vendor-card mb-4">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="search" class="form-label">Search Products</label>
                <input type="text" class="form-control" id="search" placeholder="Search by name, SKU, or category...">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category">
                    <option value="">All Categories</option>
                    <option value="electronics">Electronics</option>
                    <option value="beauty">Beauty & Personal Care</option>
                    <option value="home">Home & Garden</option>
                    <option value="fashion">Fashion</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="out_of_stock">Out of Stock</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label">&nbsp;</label>
                <button class="vendor-btn w-100">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="vendor-card">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($products->count() > 0)
        <div class="table-responsive">
            <table class="table vendor-table">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="form-check-input" id="selectAll">
                        </th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Sales</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input product-checkbox" value="{{ $product->id }}">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $product->main_image ? (str_starts_with($product->main_image, 'frontend/') ? asset($product->main_image) : Storage::url($product->main_image)) : asset('frontend/amazy/img/67b5a3c9e4224.png') }}" 
                                         alt="{{ $product->name }}" 
                                         class="rounded me-3" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-1">{{ Str::limit($product->name, 40) }}</h6>
                                        <small class="text-muted">{{ Str::limit($product->short_description, 50) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                            <td>
                                @if($product->sale_price)
                                    <span class="text-decoration-line-through text-muted">KSh {{ number_format($product->price, 0) }}</span><br>
                                    <strong class="text-danger">KSh {{ number_format($product->sale_price, 0) }}</strong>
                                @else
                                    <strong>KSh {{ number_format($product->price, 0) }}</strong>
                                @endif
                            </td>
                            <td>
                                @if($product->stock_quantity > 0)
                                    <span class="text-success">{{ $product->stock_quantity }} in stock</span>
                                @else
                                    <span class="text-danger">Out of stock</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge status-{{ $product->status }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td>{{ $product->sold_count ?? 0 }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('vendor.products.edit', $product->id) }}"><i class="fas fa-edit"></i> Edit</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="toggleProductStatus({{ $product->id }})">
                                            <i class="fas fa-{{ $product->status === 'active' ? 'eye-slash' : 'eye' }}"></i> 
                                            {{ $product->status === 'active' ? 'Deactivate' : 'Activate' }}
                                        </a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('vendor.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <p class="text-muted mb-0">
                    Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </p>
            </div>
            <nav aria-label="Products pagination">
                {{ $products->links() }}
            </nav>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-box fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No products found</h5>
            <p class="text-muted">Start by adding your first product to your store.</p>
            <a href="{{ route('vendor.products.create') }}" class="vendor-btn">
                <i class="fas fa-plus"></i> Add Your First Product
            </a>
        </div>
    @endif
</div>

<!-- Bulk Actions -->
<div class="vendor-card mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <span class="text-muted">Selected items: <span id="selectedCount">0</span></span>
        </div>
        <div class="btn-group">
            <button class="btn btn-outline-secondary btn-sm" disabled>
                <i class="fas fa-edit"></i> Edit Selected
            </button>
            <button class="btn btn-outline-secondary btn-sm" disabled>
                <i class="fas fa-copy"></i> Duplicate
            </button>
            <button class="btn btn-outline-danger btn-sm" disabled>
                <i class="fas fa-trash"></i> Delete
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
    const selectedCount = document.getElementById('selectedCount');

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedCount();
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
            updateSelectAll();
        });
    });

    function updateSelectedCount() {
        const checked = document.querySelectorAll('tbody input[type="checkbox"]:checked').length;
        selectedCount.textContent = checked;
    }

    function updateSelectAll() {
        const checked = document.querySelectorAll('tbody input[type="checkbox"]:checked').length;
        const total = checkboxes.length;
        selectAll.checked = checked === total;
        selectAll.indeterminate = checked > 0 && checked < total;
    }
});

function toggleProductStatus(productId) {
    if (confirm('Are you sure you want to change this product status?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('meta[name="_token"]')?.getAttribute('content') || 
                         '{{ csrf_token() }}';
        
        fetch('/vendor/products/' + productId + '/toggle-status', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the product status.');
        });
    }
}
</script>
@endpush
