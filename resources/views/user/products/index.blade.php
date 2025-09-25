@extends('layouts.unified')

@section('page-title', 'Products')
@section('page-subtitle', 'Manage your product catalog')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Products</h4>
        <p class="text-muted mb-0">Manage your product catalog</p>
    </div>
    <a href="{{ route('vendor.products.create') }}" class="user-btn">
        <i class="fas fa-plus"></i> Add New Product
    </a>
</div>

<!-- Filters and Search -->
<div class="user-card mb-4">
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
                <button class="user-btn w-100">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="user-card">
    <div class="table-responsive">
        <table class="table user-table">
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
                <tr>
                    <td>
                        <input type="checkbox" class="form-check-input">
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}" alt="Product" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-1">Nova Hair Shaving Machine</h6>
                                <small class="text-muted">Beard Trimmer (Rechargeable)</small>
                            </div>
                        </div>
                    </td>
                    <td>NOVA-001</td>
                    <td>Beauty & Personal Care</td>
                    <td>KSh 1,000</td>
                    <td>
                        <span class="text-success">45 in stock</span>
                    </td>
                    <td><span class="status-badge status-active">Active</span></td>
                    <td>127 sales</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('vendor.products.edit', 1) }}"><i class="fas fa-edit"></i> Edit</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy"></i> Duplicate</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash"></i> Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" class="form-check-input">
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}" alt="Product" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-1">Ceriotti Super GEK 3000</h6>
                                <small class="text-muted">Blow Dry Hair Dryer - Black</small>
                            </div>
                        </div>
                    </td>
                    <td>CERI-002</td>
                    <td>Beauty & Personal Care</td>
                    <td>KSh 2,500</td>
                    <td>
                        <span class="text-warning">5 in stock</span>
                    </td>
                    <td><span class="status-badge status-active">Active</span></td>
                    <td>89 sales</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('vendor.products.edit', 2) }}"><i class="fas fa-edit"></i> Edit</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy"></i> Duplicate</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash"></i> Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" class="form-check-input">
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}" alt="Product" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-1">Professional Beard Trimmer</h6>
                                <small class="text-muted">Rechargeable Hair Clipper</small>
                            </div>
                        </div>
                    </td>
                    <td>BEARD-003</td>
                    <td>Beauty & Personal Care</td>
                    <td>KSh 800</td>
                    <td>
                        <span class="text-danger">0 in stock</span>
                    </td>
                    <td><span class="status-badge status-inactive">Out of Stock</span></td>
                    <td>156 sales</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('vendor.products.edit', 3) }}"><i class="fas fa-edit"></i> Edit</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy"></i> Duplicate</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash"></i> Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" class="form-check-input">
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}" alt="Product" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-1">Hair Clipper Set</h6>
                                <small class="text-muted">Professional Hair Cutting Kit</small>
                            </div>
                        </div>
                    </td>
                    <td>CLIP-004</td>
                    <td>Beauty & Personal Care</td>
                    <td>KSh 1,200</td>
                    <td>
                        <span class="text-success">23 in stock</span>
                    </td>
                    <td><span class="status-badge status-active">Active</span></td>
                    <td>67 sales</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('vendor.products.edit', 4) }}"><i class="fas fa-edit"></i> Edit</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy"></i> Duplicate</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash"></i> Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <p class="text-muted mb-0">Showing 1 to 4 of 4 products</p>
        </div>
        <nav aria-label="Products pagination">
            <ul class="pagination mb-0">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item disabled">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Bulk Actions -->
<div class="user-card mt-4">
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
</script>
@endpush
