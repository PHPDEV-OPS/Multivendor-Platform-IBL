@extends('admin.layouts.app')

@section('page-title', 'Edit Promotion')
@section('page-subtitle', 'Update promotion details and banner settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Promotion: {{ $promotion->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.promotions.update', $promotion) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="section-title">Basic Information</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Promotion Name *</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="e.g., Summer Sale 2024" value="{{ old('name', $promotion->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Coupon Code</label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                           placeholder="e.g., SUMMER20" value="{{ old('code', $promotion->code) }}">
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
                                              rows="3" placeholder="Enter promotion description...">{{ old('description', $promotion->description) }}</textarea>
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
                                            <option value="{{ $key }}" {{ old('type', $promotion->type) == $key ? 'selected' : '' }}>
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
                                               placeholder="20" value="{{ old('discount_value', $promotion->discount_value) }}" step="0.01" required>
                                        <span class="input-group-text discount-suffix">
                                            {{ $promotion->type === 'fixed_amount' ? '$' : '%' }}
                                        </span>
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
                                               placeholder="50.00" value="{{ old('minimum_order_amount', $promotion->minimum_order_amount) }}" step="0.01">
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
                                               placeholder="100.00" value="{{ old('maximum_discount', $promotion->maximum_discount) }}" step="0.01">
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
                                           placeholder="100" value="{{ old('usage_limit', $promotion->usage_limit) }}" min="1">
                                    <small class="text-muted">Leave blank for unlimited. Current usage: {{ $promotion->used_count }}</small>
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Usage Per Customer *</label>
                                    <input type="number" name="per_user_limit" class="form-control @error('per_user_limit') is-invalid @enderror" 
                                           placeholder="1" value="{{ old('per_user_limit', $promotion->per_user_limit) }}" min="1" required>
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
                                           value="{{ old('start_date', $promotion->start_date->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">End Date *</label>
                                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                                           value="{{ old('end_date', $promotion->end_date->format('Y-m-d')) }}" required>
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
                                                {{ in_array($product->id, old('applicable_products', $promotion->applicable_products ?? [])) ? 'selected' : '' }}>
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
                                                {{ in_array($category->id, old('applicable_categories', $promotion->applicable_categories ?? [])) ? 'selected' : '' }}>
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
                                           {{ old('is_active', $promotion->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="is_first_time_only" class="form-check-input" value="1" 
                                           {{ old('is_first_time_only', $promotion->is_first_time_only) ? 'checked' : '' }}>
                                    <label class="form-check-label">First Time Only</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="is_new_customer_only" class="form-check-input" value="1" 
                                           {{ old('is_new_customer_only', $promotion->is_new_customer_only) ? 'checked' : '' }}>
                                    <label class="form-check-label">New Customers Only</label>
                                </div>
                            </div>
                        </div>

                        <!-- Banner Management -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="section-title">Banner Management (Optional)</h6>
                                <p class="text-muted">Update banner settings for this promotion</p>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Banner Image</label>
                                    @if($promotion->banner_image)
                                        <div class="mb-2">
                                            <img src="{{ $promotion->banner_image_url }}" alt="Current Banner" 
                                                 class="img-thumbnail" style="max-height: 100px;">
                                            <small class="d-block text-muted">Current banner</small>
                                        </div>
                                    @endif
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
                                            <option value="{{ $key }}" {{ old('banner_position', $promotion->banner_position) == $key ? 'selected' : '' }}>
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
                                           placeholder="e.g., Summer Sale!" value="{{ old('banner_title', $promotion->banner_title) }}">
                                    @error('banner_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Banner Subtitle</label>
                                    <input type="text" name="banner_subtitle" class="form-control @error('banner_subtitle') is-invalid @enderror" 
                                           placeholder="e.g., Up to 50% off" value="{{ old('banner_subtitle', $promotion->banner_subtitle) }}">
                                    @error('banner_subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Banner Link</label>
                                    <input type="url" name="banner_link" class="form-control @error('banner_link') is-invalid @enderror" 
                                           placeholder="https://example.com/promotion" value="{{ old('banner_link', $promotion->banner_link) }}">
                                    <small class="text-muted">Where should the banner link to?</small>
                                    @error('banner_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check mb-3">
                                    <input type="checkbox" name="banner_is_active" class="form-check-input" value="1" 
                                           {{ old('banner_is_active', $promotion->banner_is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label">Activate Banner</label>
                                    <small class="text-muted d-block">Check this to display the banner</small>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.promotions.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
                                    <button type="submit" class="admin-btn admin-btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Promotion
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
            <!-- Current Status -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Current Status</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge {{ $promotion->status === 'active' ? 'bg-success' : ($promotion->status === 'scheduled' ? 'bg-warning' : ($promotion->status === 'expired' ? 'bg-danger' : 'bg-secondary')) }}">
                            {{ ucfirst($promotion->status) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <strong>Usage:</strong>
                        <div class="mt-1">
                            <small>{{ $promotion->used_count }}/{{ $promotion->usage_limit ?: '∞' }}</small>
                            @if($promotion->usage_limit)
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar" style="width: {{ $promotion->usage_percentage }}%"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Banner Status:</strong>
                        @if($promotion->banner_image)
                            <span class="badge {{ $promotion->banner_is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $promotion->banner_is_active ? 'Active' : 'Inactive' }}
                            </span>
                        @else
                            <span class="text-muted">No banner</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.promotions.toggle-status', $promotion) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="admin-btn admin-btn-outline w-100">
                                <i class="fas fa-{{ $promotion->is_active ? 'pause' : 'play' }} me-2"></i>
                                {{ $promotion->is_active ? 'Pause' : 'Activate' }} Promotion
                            </button>
                        </form>
                        @if($promotion->banner_image)
                        <form action="{{ route('admin.promotions.toggle-banner', $promotion) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="admin-btn admin-btn-outline w-100">
                                <i class="fas fa-{{ $promotion->banner_is_active ? 'eye-slash' : 'eye' }} me-2"></i>
                                {{ $promotion->banner_is_active ? 'Hide' : 'Show' }} Banner
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('admin.promotions.duplicate', $promotion) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="admin-btn admin-btn-outline w-100">
                                <i class="fas fa-copy me-2"></i>Duplicate Promotion
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Banner Preview -->
            @if($promotion->banner_image)
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0">Banner Preview</h6>
                </div>
                <div class="card-body">
                    <img src="{{ $promotion->banner_image_url }}" alt="Banner Preview" 
                         class="img-fluid rounded" style="max-height: 150px; width: 100%; object-fit: cover;">
                    @if($promotion->banner_title)
                        <div class="mt-2">
                            <strong>{{ $promotion->banner_title }}</strong>
                            @if($promotion->banner_subtitle)
                                <br><small class="text-muted">{{ $promotion->banner_subtitle }}</small>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @endif
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
