@extends('vendor.layouts.app')

@section('page-title', 'Edit Product')
@section('page-subtitle', 'Update product information')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="vendor-card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Product - {{ $product->name }}</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('vendor.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Basic Information</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Product Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">SKU</label>
                                    <input type="text" class="form-control" value="{{ $product->sku }}" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                              name="short_description" rows="2">{{ old('short_description', $product->short_description) }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Category *</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Inventory -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Pricing & Inventory</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Regular Price *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">KSh</span>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                               name="price" value="{{ old('price', $product->price) }}" step="0.01" required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Sale Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">KSh</span>
                                        <input type="number" class="form-control @error('sale_price') is-invalid @enderror" 
                                               name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01">
                                    </div>
                                    @error('sale_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Cost Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">KSh</span>
                                        <input type="number" class="form-control @error('cost_price') is-invalid @enderror" 
                                               name="cost_price" value="{{ old('cost_price', $product->cost_price) }}" step="0.01">
                                    </div>
                                    @error('cost_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Stock Quantity *</label>
                                    <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                           name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                                    @error('stock_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Low Stock Alert</label>
                                    <input type="number" class="form-control @error('min_stock_alert') is-invalid @enderror" 
                                           name="min_stock_alert" value="{{ old('min_stock_alert', $product->min_stock_alert) }}">
                                    @error('min_stock_alert')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Product Images -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Product Images</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Main Image</label>
                                    <div class="image-upload-container">
                                        @if($product->main_image)
                                            <img src="{{ str_starts_with($product->main_image, 'frontend/') ? asset($product->main_image) : Storage::url($product->main_image) }}" 
                                                 alt="Main Product Image" class="img-thumbnail mb-2" id="mainImagePreview" style="max-width: 200px;">
                                        @else
                                            <img src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}" 
                                                 alt="Main Product Image" class="img-thumbnail mb-2" id="mainImagePreview" style="max-width: 200px;">
                                        @endif
                                        <input type="file" class="form-control @error('main_image') is-invalid @enderror" 
                                               name="main_image" accept="image/*" onchange="previewImage(this, 'mainImagePreview')">
                                    </div>
                                    @error('main_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Additional Images</label>
                                    <div class="image-upload-container">
                                        <div class="row" id="additionalImagesPreview">
                                            @if($product->images)
                                                @foreach($product->images as $image)
                                                    <div class="col-4 mb-2">
                                                        <img src="{{ str_starts_with($image, 'frontend/') ? asset($image) : Storage::url($image) }}" 
                                                             class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <input type="file" class="form-control @error('additional_images.*') is-invalid @enderror" 
                                               name="additional_images[]" accept="image/*" multiple onchange="previewMultipleImages(this, 'additionalImagesPreview')">
                                    </div>
                                    @error('additional_images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Product Specifications -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Product Specifications</h6>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Weight (kg)</label>
                                    <input type="number" class="form-control @error('weight') is-invalid @enderror" 
                                           name="weight" value="{{ old('weight', $product->weight) }}" step="0.01">
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Length (cm)</label>
                                    <input type="number" class="form-control @error('length') is-invalid @enderror" 
                                           name="length" value="{{ old('length', $product->length) }}" step="0.1">
                                    @error('length')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Width (cm)</label>
                                    <input type="number" class="form-control @error('width') is-invalid @enderror" 
                                           name="width" value="{{ old('width', $product->width) }}" step="0.1">
                                    @error('width')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Height (cm)</label>
                                    <input type="number" class="form-control @error('height') is-invalid @enderror" 
                                           name="height" value="{{ old('height', $product->height) }}" step="0.1">
                                    @error('height')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- SEO Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">SEO Information</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Meta Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                           name="meta_title" value="{{ old('meta_title', $product->meta_title) }}">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                           name="meta_keywords" value="{{ old('meta_keywords', is_array($product->meta_keywords) ? implode(', ', $product->meta_keywords) : $product->meta_keywords) }}" 
                                           placeholder="Separate keywords with commas">
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                              name="meta_description" rows="2">{{ old('meta_description', $product->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('vendor.products') }}" class="vendor-btn vendor-btn-secondary">Cancel</a>
                                    <div>
                                        <button type="submit" class="vendor-btn vendor-btn-primary">Update Product</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Publishing Options -->
            <div class="vendor-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Product Options</h6>
                </div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_featured" id="featured" 
                               {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="featured">
                            Featured Product
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_bestseller" id="bestSeller" 
                               {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }}>
                        <label class="form-check-label" for="bestSeller">
                            Best Seller
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="is_new" id="newArrival" 
                               {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                        <label class="form-check-label" for="newArrival">
                            New Arrival
                        </label>
                    </div>
                </div>
            </div>

            <!-- Product Statistics -->
            <div class="vendor-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Product Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="stat-item">
                                <h4 class="text-primary mb-1">{{ $product->view_count ?? 0 }}</h4>
                                <small class="text-muted">Views</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <h4 class="text-success mb-1">{{ $product->sold_count ?? 0 }}</h4>
                                <small class="text-muted">Sold</small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="stat-item">
                                <h4 class="text-info mb-1">{{ $product->review_count ?? 0 }}</h4>
                                <small class="text-muted">Reviews</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-item">
                                <h4 class="text-warning mb-1">{{ number_format($product->rating ?? 0, 1) }}</h4>
                                <small class="text-muted">Rating</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="vendor-card">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('vendor.products') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Products
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteProduct()">
                            <i class="fas fa-trash"></i> Delete Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this product? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('vendor.products.destroy', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewMultipleImages(input, previewContainerId) {
    const container = document.getElementById(previewContainerId);
    container.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-4 mb-2';
                col.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">`;
                container.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    }
}

function deleteProduct() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Auto-save functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, textarea, select');
    
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            // Save form data to localStorage
            const formData = new FormData(form);
            const data = {};
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }
            localStorage.setItem('productEditDraft', JSON.stringify(data));
        });
    });
});
</script>
@endpush
