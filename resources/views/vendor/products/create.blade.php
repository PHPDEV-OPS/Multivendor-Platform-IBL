@extends('vendor.layouts.app')

@section('page-title', 'Add New Product')
@section('page-subtitle', 'Create a new product for your store')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Add New Product</h4>
        <p class="text-muted mb-0">Create a new product for your store</p>
    </div>
    <a href="{{ route('vendor.products') }}" class="vendor-btn">
        <i class="fas fa-arrow-left"></i> Back to Products
    </a>
</div>

<form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Basic Information -->
        <div class="col-md-8">
            <div class="vendor-card">
                <h5 class="mb-3">Basic Information</h5>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Product Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Enter product name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku" placeholder="Auto-generated">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Enter product description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="short_description" class="form-label">Short Description</label>
                    <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description" rows="2" placeholder="Brief product description (max 500 characters)">{{ old('short_description') }}</textarea>
                    @error('short_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">Category *</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" placeholder="Enter brand name">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="price" class="form-label">Price (KSh) *</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" step="0.01" required placeholder="0.00">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="sale_price" class="form-label">Sale Price (KSh)</label>
                            <input type="number" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" step="0.01" placeholder="0.00">
                            @error('sale_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="cost_price" class="form-label">Cost Price (KSh)</label>
                            <input type="number" class="form-control @error('cost_price') is-invalid @enderror" id="cost_price" name="cost_price" value="{{ old('cost_price') }}" step="0.01" placeholder="0.00">
                            @error('cost_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" required placeholder="0">
                            @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="min_stock_alert" class="form-label">Min Stock Alert</label>
                            <input type="number" class="form-control @error('min_stock_alert') is-invalid @enderror" id="min_stock_alert" name="min_stock_alert" value="{{ old('min_stock_alert', 5) }}" placeholder="5">
                            @error('min_stock_alert')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight') }}" step="0.01" placeholder="0.00">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="dimensions" class="form-label">Dimensions (cm)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="length" name="length" placeholder="L" step="0.1">
                                <span class="input-group-text">×</span>
                                <input type="number" class="form-control" id="width" name="width" placeholder="W" step="0.1">
                                <span class="input-group-text">×</span>
                                <input type="number" class="form-control" id="height" name="height" placeholder="H" step="0.1">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Flags -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Featured Product
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_bestseller" name="is_bestseller" value="1" {{ old('is_bestseller') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_bestseller">
                                Best Seller
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_new" name="is_new" value="1" {{ old('is_new') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_new">
                                New Product
                            </label>
                        </div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Product Images -->
            <div class="vendor-card">
                <h5 class="mb-3">Product Images</h5>
                
                <div class="form-group mb-3">
                    <label for="main_image" class="form-label">Main Product Image *</label>
                    <input type="file" class="form-control @error('main_image') is-invalid @enderror" id="main_image" name="main_image" accept="image/*" required>
                    <small class="text-muted">Recommended size: 800x800px, Max size: 2MB</small>
                    @error('main_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="additional_images" class="form-label">Additional Images</label>
                    <input type="file" class="form-control @error('additional_images.*') is-invalid @enderror" id="additional_images" name="additional_images[]" accept="image/*" multiple>
                    <small class="text-muted">You can select multiple images. Max 5 additional images.</small>
                    @error('additional_images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="imagePreview" class="row">
                    <!-- Image previews will be shown here -->
                </div>
            </div>

            <!-- SEO Information -->
            <div class="vendor-card">
                <h5 class="mb-3">SEO Information</h5>
                
                <div class="form-group mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Enter meta title for SEO">
                </div>

                <div class="form-group mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Enter meta description for SEO"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" placeholder="Enter keywords separated by commas">
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Publishing -->
            <div class="vendor-card">
                <h5 class="mb-3">Publishing</h5>
                
                <div class="form-group mb-3">
                    <label for="publish_date" class="form-label">Publish Date</label>
                    <input type="datetime-local" class="form-control" id="publish_date" name="publish_date">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="featured" name="featured">
                    <label class="form-check-label" for="featured">
                        Featured Product
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="best_seller" name="best_seller">
                    <label class="form-check-label" for="best_seller">
                        Best Seller
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="new_arrival" name="new_arrival">
                    <label class="form-check-label" for="new_arrival">
                        New Arrival
                    </label>
                </div>
            </div>

            <!-- Shipping -->
            <div class="vendor-card">
                <h5 class="mb-3">Shipping</h5>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="free_shipping" name="free_shipping">
                    <label class="form-check-label" for="free_shipping">
                        Free Shipping
                    </label>
                </div>

                <div class="form-group mb-3">
                    <label for="shipping_cost" class="form-label">Shipping Cost (KSh)</label>
                    <input type="number" class="form-control" id="shipping_cost" name="shipping_cost" step="0.01" placeholder="0.00">
                </div>

                <div class="form-group mb-3">
                    <label for="shipping_time" class="form-label">Shipping Time (days)</label>
                    <input type="number" class="form-control" id="shipping_time" name="shipping_time" placeholder="1-3">
                </div>
            </div>

            <!-- Tax -->
            <div class="vendor-card">
                <h5 class="mb-3">Tax</h5>
                
                <div class="form-group mb-3">
                    <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                    <input type="number" class="form-control" id="tax_rate" name="tax_rate" step="0.01" placeholder="16.00">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="tax_included" name="tax_included">
                    <label class="form-check-label" for="tax_included">
                        Tax Included in Price
                    </label>
                </div>
            </div>

            <!-- Actions -->
            <div class="vendor-card">
                <div class="d-grid gap-2">
                    <button type="submit" class="vendor-btn">
                        <i class="fas fa-save"></i> Save Product
                    </button>
                    <button type="button" class="btn btn-outline-secondary">
                        <i class="fas fa-eye"></i> Preview
                    </button>
                    <a href="{{ route('vendor.products') }}" class="btn btn-outline-danger">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate SKU
    const productNameInput = document.getElementById('product_name');
    const skuInput = document.getElementById('sku');
    
    productNameInput.addEventListener('input', function() {
        if (!skuInput.value) {
            const sku = this.value
                .toUpperCase()
                .replace(/[^A-Z0-9]/g, '')
                .substring(0, 8);
            skuInput.value = sku + '-' + Math.random().toString(36).substr(2, 4).toUpperCase();
        }
    });

    // Image preview
    const mainImageInput = document.getElementById('main_image');
    const imagePreview = document.getElementById('imagePreview');
    
    mainImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `
                    <div class="col-md-6 mb-3">
                        <div class="position-relative">
                            <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 200px;">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" onclick="removeImage(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }
    });
});

function removeImage(button) {
    button.closest('.col-md-6').remove();
    document.getElementById('main_image').value = '';
}
</script>
@endpush
