@extends('admin.layouts.app')

@section('page-title', 'Create Promotion')
@section('page-subtitle', 'Create a new promotion with optional banner')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">Create New Promotion</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h6 class="alert-heading">Please fix the following errors:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="section-title">Basic Information</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Promotion Name *</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="e.g., Summer Sale 2024" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Coupon Code</label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                           placeholder="e.g., SUMMER20" value="{{ old('code') }}">
                                    <small class="text-muted">Leave blank for automatic generation</small>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                              rows="3" placeholder="Enter promotion description...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Promotion Type & Discount -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="section-title">Promotion Type & Discount</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Promotion Type *</label>
                                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="">Select Promotion Type</option>
                                        @foreach($types as $key => $type)
                                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Discount Value *</label>
                                    <div class="input-group">
                                                                            <input type="number" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" 
                                           placeholder="20" value="{{ old('discount_value') }}" step="0.01" required min="0">
                                        <span class="input-group-text discount-suffix">%</span>
                                    </div>
                                    @error('discount_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Minimum Order Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="minimum_order_amount" class="form-control @error('minimum_order_amount') is-invalid @enderror" 
                                               placeholder="50.00" value="{{ old('minimum_order_amount') }}" step="0.01">
                                    </div>
                                    @error('minimum_order_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Maximum Discount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="maximum_discount" class="form-control @error('maximum_discount') is-invalid @enderror" 
                                               placeholder="100.00" value="{{ old('maximum_discount') }}" step="0.01">
                                    </div>
                                    <small class="text-muted">Only applies to percentage discounts</small>
                                    @error('maximum_discount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Usage Limits -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="section-title">Usage Limits</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Maximum Usage</label>
                                    <input type="number" name="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" 
                                           placeholder="100" value="{{ old('usage_limit') }}" min="1">
                                    <small class="text-muted">Leave blank for unlimited</small>
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Usage Per Customer *</label>
                                    <input type="number" name="per_user_limit" class="form-control @error('per_user_limit') is-invalid @enderror" 
                                           placeholder="1" value="{{ old('per_user_limit', 1) }}" min="1" required>
                                    @error('per_user_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Date Range -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="section-title">Date Range</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Start Date *</label>
                                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                                           value="{{ old('start_date') }}" required min="{{ date('Y-m-d') }}">
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">End Date *</label>
                                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                                           value="{{ old('end_date') }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Applicable Products/Categories -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="section-title">Applicable Products & Categories</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Applicable Products</label>
                                    <select name="applicable_products[]" class="form-select" multiple>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" 
                                                {{ in_array($product->id, old('applicable_products', [])) ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Hold Ctrl/Cmd to select multiple. Leave empty for all products.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Applicable Categories</label>
                                    <select name="applicable_categories[]" class="form-select" multiple>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ in_array($category->id, old('applicable_categories', [])) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Hold Ctrl/Cmd to select multiple. Leave empty for all categories.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Options -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="section-title">Options</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="is_active" class="form-check-input" value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="is_first_time_only" class="form-check-input" value="1" 
                                           {{ old('is_first_time_only') ? 'checked' : '' }}>
                                    <label class="form-check-label">First Time Only</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="is_new_customer_only" class="form-check-input" value="1" 
                                           {{ old('is_new_customer_only') ? 'checked' : '' }}>
                                    <label class="form-check-label">New Customers Only</label>
                                </div>
                            </div>
                        </div>

                        <!-- Banner Management -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="section-title">Banner Management (Optional)</h6>
                                <p class="text-muted">Create a banner to display this promotion on your website</p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Banner Image</label>
                                    <input type="file" name="banner_image" class="form-control @error('banner_image') is-invalid @enderror" 
                                           accept="image/*">
                                    <small class="text-muted">Recommended size: 1200x400px. Max 2MB.</small>
                                    @error('banner_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Banner Position</label>
                                    <select name="banner_position" class="form-select @error('banner_position') is-invalid @enderror">
                                        <option value="">Select Position</option>
                                        @foreach($bannerPositions as $key => $position)
                                            <option value="{{ $key }}" {{ old('banner_position') == $key ? 'selected' : '' }}>
                                                {{ $position }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('banner_position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Banner Title</label>
                                    <input type="text" name="banner_title" class="form-control @error('banner_title') is-invalid @enderror" 
                                           placeholder="e.g., Summer Sale!" value="{{ old('banner_title') }}">
                                    @error('banner_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Banner Subtitle</label>
                                    <input type="text" name="banner_subtitle" class="form-control @error('banner_subtitle') is-invalid @enderror" 
                                           placeholder="e.g., Up to 50% off" value="{{ old('banner_subtitle') }}">
                                    @error('banner_subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Banner Link</label>
                                    <input type="url" name="banner_link" class="form-control @error('banner_link') is-invalid @enderror" 
                                           placeholder="https://example.com/promotion" value="{{ old('banner_link') }}">
                                    <small class="text-muted">Where should the banner link to?</small>
                                    @error('banner_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="banner_is_active" class="form-check-input" value="1" 
                                           {{ old('banner_is_active') ? 'checked' : '' }}>
                                    <label class="form-check-label">Activate Banner</label>
                                    <small class="text-muted d-block">Check this to display the banner immediately</small>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.promotions.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
                                    <button type="submit" class="admin-btn admin-btn-primary">
                                        <i class="fas fa-save me-2"></i>Create Promotion
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Preview -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Banner Preview</h6>
                </div>
                <div class="card-body">
                    <div id="banner-preview" class="text-center p-3 border rounded" style="min-height: 200px; background: #f8f9fa;">
                        <div class="text-muted">
                            <i class="fas fa-image fa-3x mb-3"></i>
                            <p>Banner preview will appear here</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Promotion Tips</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading"><i class="fas fa-lightbulb me-2"></i>Best Practices</h6>
                        <ul class="mb-0">
                            <li>Keep promotions simple and clear</li>
                            <li>Set realistic usage limits</li>
                            <li>Use urgency to drive action</li>
                            <li>Test different discount amounts</li>
                            <li>Monitor performance regularly</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Banner Tips -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0">Banner Tips</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h6 class="alert-heading"><i class="fas fa-image me-2"></i>Banner Guidelines</h6>
                        <ul class="mb-0">
                            <li>Use high-quality images (1200x400px)</li>
                            <li>Keep text readable and concise</li>
                            <li>Use contrasting colors</li>
                            <li>Include clear call-to-action</li>
                            <li>Test on mobile devices</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const promotionTypeSelect = document.querySelector('select[name="type"]');
    const discountValueInput = document.querySelector('input[name="discount_value"]');
    const discountValueGroup = discountValueInput.parentElement;
    const suffix = discountValueGroup.querySelector('.input-group-text');
    
    // Handle promotion type change
    promotionTypeSelect.addEventListener('change', function() {
        const type = this.value;
        
        switch(type) {
            case 'percentage':
                suffix.textContent = '%';
                discountValueInput.placeholder = '20';
                discountValueInput.disabled = false;
                break;
            case 'fixed_amount':
                suffix.textContent = '$';
                discountValueInput.placeholder = '10.00';
                discountValueInput.disabled = false;
                break;
            case 'free_shipping':
                discountValueInput.value = '';
                discountValueInput.placeholder = 'N/A';
                discountValueInput.disabled = true;
                break;
            case 'buy_one_get_one':
                discountValueInput.value = '';
                discountValueInput.placeholder = 'N/A';
                discountValueInput.disabled = true;
                break;
            case 'flash_sale':
                suffix.textContent = '%';
                discountValueInput.placeholder = '50';
                discountValueInput.disabled = false;
                break;
            default:
                suffix.textContent = '%';
                discountValueInput.disabled = false;
                break;
        }
    });

    // Banner image preview
    const bannerImageInput = document.querySelector('input[name="banner_image"]');
    const bannerPreview = document.getElementById('banner-preview');
    
    bannerImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                bannerPreview.innerHTML = `
                    <img src="${e.target.result}" alt="Banner Preview" class="img-fluid rounded" style="max-height: 150px;">
                `;
            };
            reader.readAsDataURL(file);
        } else {
            bannerPreview.innerHTML = `
                <div class="text-muted">
                    <i class="fas fa-image fa-3x mb-3"></i>
                    <p>Banner preview will appear here</p>
                </div>
            `;
        }
    });

    // Auto-generate code if empty
    const codeInput = document.querySelector('input[name="code"]');
    const nameInput = document.querySelector('input[name="name"]');
    
    nameInput.addEventListener('blur', function() {
        if (!codeInput.value && this.value) {
            const code = this.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase().substring(0, 8);
            codeInput.value = code;
        }
    });

    // Handle URL parameters for pre-selecting banner position
    function getParameterByName(name) {
        const url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
        const results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    // Pre-select banner position from URL parameter
    const positionParam = getParameterByName('position');
    if (positionParam) {
        const bannerPositionSelect = document.querySelector('select[name="banner_position"]');
        if (bannerPositionSelect) {
            bannerPositionSelect.value = positionParam;
            console.log('Pre-selected banner position:', positionParam);
            
            // Trigger change event to update any dependent fields
            const event = new Event('change', { bubbles: true });
            bannerPositionSelect.dispatchEvent(event);
        }
    }

    // Add form submission debugging
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        console.log('Form submitted');
        console.log('Form data:', new FormData(form));
        
        // Log all form field values
        const formData = new FormData(form);
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.section-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}
</style>
@endpush
