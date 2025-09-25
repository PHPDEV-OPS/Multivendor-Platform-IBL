@extends('admin.layouts.app')

@section('page-title', 'Products')
@section('page-subtitle', 'Manage your product catalog')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Products</h4>
        <p class="text-muted mb-0">Manage your product catalog</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="admin-btn">
        <i class="fas fa-plus"></i> Add New Product
    </a>
</div>

<!-- Filters and Search -->
<div class="admin-card mb-4">
    <form method="GET" action="{{ route('admin.products.index') }}">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="search" class="form-label">Search Products</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Search by name, SKU, or category..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="admin-btn w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Products Table -->
<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" class="form-check-input" id="selectAll">
                    </th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Vendor</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Sales</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <input type="checkbox" class="form-check-input product-checkbox" value="{{ $product->id }}">
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . $product->main_image) }}" alt="Product" 
                                 class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-1">{{ $product->name }}</h6>
                                <small class="text-muted">{{ $product->short_description }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->vendor->name }}</td>
                    <td>
                        @if($product->sale_price)
                            <span class="text-decoration-line-through text-muted">KSh {{ number_format($product->price, 0) }}</span>
                            <br>
                            <span class="text-danger fw-bold">KSh {{ number_format($product->sale_price, 0) }}</span>
                        @else
                            KSh {{ number_format($product->price, 0) }}
                        @endif
                    </td>
                    <td>
                        @if($product->stock_quantity > 0)
                            <span class="text-success">{{ $product->stock_quantity }} in stock</span>
                        @else
                            <span class="text-danger">0 in stock</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge 
                            @if($product->status == 'active') status-active
                            @elseif($product->status == 'inactive') status-inactive
                            @elseif($product->status == 'out_of_stock') status-inactive
                            @else status-pending
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                        </span>
                    </td>
                    <td>{{ $product->sold_count }} sales</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.products.edit', $product) }}"><i class="fas fa-edit"></i> Edit</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy"></i> Duplicate</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" 
                                                onclick="return confirm('Are you sure you want to delete this product?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">No products found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <p class="text-muted mb-0">
                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} 
                of {{ $products->total() }} products
            </p>
        </div>
        <div>
            {{ $products->links() }}
        </div>
    </div>
</div>

<!-- Bulk Actions -->
<div class="admin-card mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <span class="text-muted">Selected items: <span id="selectedCount">0</span></span>
        </div>
        <div class="btn-group">
            <button class="btn btn-outline-secondary btn-sm" disabled id="bulkEditBtn">
                <i class="fas fa-edit"></i> Edit Selected
            </button>
            <button class="btn btn-outline-secondary btn-sm" disabled id="bulkDuplicateBtn">
                <i class="fas fa-copy"></i> Duplicate
            </button>
            <button class="btn btn-outline-danger btn-sm" disabled id="bulkDeleteBtn">
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
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    const bulkEditBtn = document.getElementById('bulkEditBtn');
    const bulkDuplicateBtn = document.getElementById('bulkDuplicateBtn');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedCount();
        updateBulkButtons();
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
            updateSelectAll();
            updateBulkButtons();
        });
    });

    function updateSelectedCount() {
        const checked = document.querySelectorAll('.product-checkbox:checked').length;
        selectedCount.textContent = checked;
    }

    function updateSelectAll() {
        const checked = document.querySelectorAll('.product-checkbox:checked').length;
        const total = checkboxes.length;
        selectAll.checked = checked === total;
        selectAll.indeterminate = checked > 0 && checked < total;
    }

    function updateBulkButtons() {
        const checked = document.querySelectorAll('.product-checkbox:checked').length;
        const hasSelection = checked > 0;
        
        bulkEditBtn.disabled = !hasSelection;
        bulkDuplicateBtn.disabled = !hasSelection;
        bulkDeleteBtn.disabled = !hasSelection;
    }
});
</script>
@endpush
