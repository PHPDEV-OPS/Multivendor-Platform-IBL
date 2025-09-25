@extends('admin.layouts.app')

@section('page-title', 'Edit Product')
@section('page-subtitle', 'Update product information')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Product - {{ $id }}</h5>
                </div>
                <div class="card-body">
                    <form>
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Basic Information</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Product Name *</label>
                                    <input type="text" class="form-control" value="Wireless Bluetooth Headphones" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">SKU</label>
                                    <input type="text" class="form-control" value="WH-BT-001" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" rows="4">High-quality wireless headphones with noise cancellation and 30-hour battery life. Perfect for music lovers and professionals.</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Category *</label>
                                    <select class="form-select" required>
                                        <option>Electronics</option>
                                        <option>Clothing</option>
                                        <option>Home & Garden</option>
                                        <option>Sports</option>
                                        <option>Books</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Brand</label>
                                    <input type="text" class="form-control" value="AudioTech">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tags</label>
                                    <input type="text" class="form-control" value="wireless, bluetooth, headphones, audio" placeholder="Separate tags with commas">
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Inventory -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">Pricing & Inventory</h6>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Regular Price *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" value="89.99" step="0.01" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Sale Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" value="69.99" step="0.01">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Stock Quantity *</label>
                                    <input type="number" class="form-control" value="150" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Low Stock Alert</label>
                                    <input type="number" class="form-control" value="10">
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
                                    <label class="form-label">Main Image *</label>
                                    <div class="image-upload-container">
                                        <img src="https://via.placeholder.com/300x300?text=Product+Image" alt="Main Product Image" class="img-thumbnail mb-2" id="mainImagePreview" style="max-width: 200px;">
                                        <input type="file" class="form-control" accept="image/*" onchange="previewImage(this, 'mainImagePreview')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Additional Images</label>
                                    <div class="image-upload-container">
                                        <div class="row" id="additionalImagesPreview">
                                            <div class="col-4 mb-2">
                                                <img src="https://via.placeholder.com/100x100?text=Img+1" class="img-thumbnail">
                                            </div>
                                            <div class="col-4 mb-2">
                                                <img src="https://via.placeholder.com/100x100?text=Img+2" class="img-thumbnail">
                                            </div>
                                            <div class="col-4 mb-2">
                                                <img src="https://via.placeholder.com/100x100?text=Img+3" class="img-thumbnail">
                                            </div>
                                        </div>
                                        <input type="file" class="form-control" accept="image/*" multiple onchange="previewMultipleImages(this, 'additionalImagesPreview')">
                                    </div>
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
                                    <input type="number" class="form-control" value="0.25" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Length (cm)</label>
                                    <input type="number" class="form-control" value="18" step="0.1">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Width (cm)</label>
                                    <input type="number" class="form-control" value="16" step="0.1">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">Height (cm)</label>
                                    <input type="number" class="form-control" value="8" step="0.1">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Additional Specifications</label>
                                    <textarea class="form-control" rows="3" placeholder="Enter additional product specifications...">Battery Life: 30 hours
Connectivity: Bluetooth 5.0
Noise Cancellation: Active
Water Resistance: IPX4</textarea>
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
                                    <input type="text" class="form-control" value="Wireless Bluetooth Headphones - AudioTech">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Meta Keywords</label>
                                    <input type="text" class="form-control" value="wireless headphones, bluetooth, audio, music">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Meta Description</label>
                                    <textarea class="form-control" rows="2">High-quality wireless Bluetooth headphones with noise cancellation. Perfect for music lovers and professionals.</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="admin-btn admin-btn-secondary">Cancel</button>
                                    <div>
                                        <button type="button" class="admin-btn admin-btn-outline me-2">Save as Draft</button>
                                        <button type="submit" class="admin-btn admin-btn-primary">Update Product</button>
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
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Publishing Options</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="pending">Pending Review</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Publish Date</label>
                        <input type="datetime-local" class="form-control" value="2024-01-15T10:00">
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="featured" checked>
                        <label class="form-check-label" for="featured">
                            Featured Product
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="bestSeller">
                        <label class="form-check-label" for="bestSeller">
                            Best Seller
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="newArrival">
                        <label class="form-check-label" for="newArrival">
                            New Arrival
                        </label>
                    </div>
                </div>
            </div>

            <!-- Shipping Options -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Shipping Options</h6>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="freeShipping">
                        <label class="form-check-label" for="freeShipping">
                            Free Shipping
                        </label>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Shipping Cost</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" value="5.99" step="0.01">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Shipping Time (days)</label>
                        <input type="number" class="form-control" value="3">
                    </div>
                </div>
            </div>

            <!-- Tax Settings -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0">Tax Settings</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Tax Class</label>
                        <select class="form-select">
                            <option>Standard Rate (10%)</option>
                            <option>Reduced Rate (5%)</option>
                            <option>Zero Rate (0%)</option>
                        </select>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="taxable" checked>
                        <label class="form-check-label" for="taxable">
                            Taxable Product
                        </label>
                    </div>
                </div>
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
                col.innerHTML = `<img src="${e.target.result}" class="img-thumbnail">`;
                container.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    }
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
