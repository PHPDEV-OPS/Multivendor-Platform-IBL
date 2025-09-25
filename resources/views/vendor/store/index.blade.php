@extends('vendor.layouts.app')

@section('page-title', 'Store Settings')
@section('page-subtitle', 'Manage your store information and branding')

@section('content')
<div class="container-fluid">
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

    <!-- Store Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="vendor-card h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-box text-primary fa-2x"></i>
                        </div>
                    </div>
                    <h3 class="text-primary mb-1">{{ $stats['total_products'] }}</h3>
                    <p class="text-muted mb-0">Total Products</p>
                    <small class="text-success">{{ $stats['active_products'] }} Active</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="vendor-card h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="stat-icon bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-shopping-cart text-success fa-2x"></i>
                        </div>
                    </div>
                    <h3 class="text-success mb-1">{{ $stats['total_orders'] }}</h3>
                    <p class="text-muted mb-0">Total Orders</p>
                    <small class="text-primary">KSh {{ number_format($stats['total_revenue'], 0) }}</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="vendor-card h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="stat-icon bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-star text-warning fa-2x"></i>
                        </div>
                    </div>
                    <h3 class="text-warning mb-1">{{ number_format($stats['average_rating'], 1) }}</h3>
                    <p class="text-muted mb-0">Average Rating</p>
                    <small class="text-info">{{ $stats['total_reviews'] }} Reviews</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="vendor-card h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="stat-icon bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-store text-info fa-2x"></i>
                        </div>
                    </div>
                    <h3 class="text-info mb-1">{{ $profile->status ?? 'Pending' }}</h3>
                    <p class="text-muted mb-0">Store Status</p>
                    <small class="text-{{ $profile->status === 'approved' ? 'success' : 'warning' }}">{{ ucfirst($profile->status ?? 'pending') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Store Information Form -->
        <div class="col-lg-8">
            <form action="{{ route('vendor.store.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Store Branding -->
                <div class="vendor-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-palette text-primary me-2"></i>Store Branding</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Store Logo</label>
                                    <div class="logo-upload-container text-center">
                                        @if($profile->store_logo)
                                            <img src="{{ Storage::url($profile->store_logo) }}" 
                                                 alt="Store Logo" class="img-thumbnail mb-2" id="logoPreview" 
                                                 style="max-width: 150px; max-height: 150px;">
                                        @else
                                            <img src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}" 
                                                 alt="Store Logo" class="img-thumbnail mb-2" id="logoPreview" 
                                                 style="max-width: 150px; max-height: 150px;">
                                        @endif
                                        <input type="file" class="form-control" name="store_logo" 
                                               accept="image/*" onchange="previewLogo(this)">
                                        <small class="text-muted">Recommended: 300x300px, PNG/JPG</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Store Banner</label>
                                    <div class="banner-upload-container text-center">
                                        @if($profile->store_banner)
                                            <img src="{{ Storage::url($profile->store_banner) }}" 
                                                 alt="Store Banner" class="img-thumbnail mb-2" id="bannerPreview" 
                                                 style="max-width: 100%; max-height: 150px;">
                                        @else
                                            <img src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}" 
                                                 alt="Store Banner" class="img-thumbnail mb-2" id="bannerPreview" 
                                                 style="max-width: 100%; max-height: 150px;">
                                        @endif
                                        <input type="file" class="form-control" name="store_banner" 
                                               accept="image/*" onchange="previewBanner(this)">
                                        <small class="text-muted">Recommended: 1200x400px, PNG/JPG</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="vendor-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Company Name *</label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                           name="company_name" value="{{ old('company_name', $profile->company_name ?? '') }}" required>
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Business Type</label>
                                    <select class="form-select @error('business_type') is-invalid @enderror" name="business_type">
                                        <option value="">Select Business Type</option>
                                        <option value="Retail" {{ old('business_type', $profile->business_type ?? '') == 'Retail' ? 'selected' : '' }}>Retail</option>
                                        <option value="Wholesale" {{ old('business_type', $profile->business_type ?? '') == 'Wholesale' ? 'selected' : '' }}>Wholesale</option>
                                        <option value="Manufacturing" {{ old('business_type', $profile->business_type ?? '') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                        <option value="Service" {{ old('business_type', $profile->business_type ?? '') == 'Service' ? 'selected' : '' }}>Service</option>
                                        <option value="Online" {{ old('business_type', $profile->business_type ?? '') == 'Online' ? 'selected' : '' }}>Online</option>
                                    </select>
                                    @error('business_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tax ID</label>
                                    <input type="text" class="form-control @error('tax_id') is-invalid @enderror" 
                                           name="tax_id" value="{{ old('tax_id', $profile->tax_id ?? '') }}">
                                    @error('tax_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Business License</label>
                                    <input type="text" class="form-control @error('business_license') is-invalid @enderror" 
                                           name="business_license" value="{{ old('business_license', $profile->business_license ?? '') }}">
                                    @error('business_license')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Business Address *</label>
                                    <textarea class="form-control @error('business_address') is-invalid @enderror" 
                                              name="business_address" rows="3" required>{{ old('business_address', $profile->business_address ?? '') }}</textarea>
                                    @error('business_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="vendor-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-address-book text-primary me-2"></i>Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Contact Person *</label>
                                    <input type="text" class="form-control @error('contact_person') is-invalid @enderror" 
                                           name="contact_person" value="{{ old('contact_person', $profile->contact_person ?? '') }}" required>
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Contact Phone *</label>
                                    <input type="text" class="form-control @error('contact_phone') is-invalid @enderror" 
                                           name="contact_phone" value="{{ old('contact_phone', $profile->contact_phone ?? '') }}" required>
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Contact Email *</label>
                                    <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                           name="contact_email" value="{{ old('contact_email', $profile->contact_email ?? '') }}" required>
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Store Policies -->
                <div class="vendor-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-file-contract text-primary me-2"></i>Store Policies</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Store Description</label>
                                    <textarea class="form-control @error('store_description') is-invalid @enderror" 
                                              name="store_description" rows="4" 
                                              placeholder="Tell customers about your store...">{{ old('store_description', $profile->store_settings['store_description'] ?? '') }}</textarea>
                                    @error('store_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Store Policy</label>
                                    <textarea class="form-control @error('store_policy') is-invalid @enderror" 
                                              name="store_policy" rows="4" 
                                              placeholder="Your store policies...">{{ old('store_policy', $profile->store_settings['store_policy'] ?? '') }}</textarea>
                                    @error('store_policy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Shipping Policy</label>
                                    <textarea class="form-control @error('shipping_policy') is-invalid @enderror" 
                                              name="shipping_policy" rows="4" 
                                              placeholder="Your shipping policies...">{{ old('shipping_policy', $profile->store_settings['shipping_policy'] ?? '') }}</textarea>
                                    @error('shipping_policy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">Return Policy</label>
                                    <textarea class="form-control @error('return_policy') is-invalid @enderror" 
                                              name="return_policy" rows="4" 
                                              placeholder="Your return policies...">{{ old('return_policy', $profile->store_settings['return_policy'] ?? '') }}</textarea>
                                    @error('return_policy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="vendor-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-share-alt text-primary me-2"></i>Social Media</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Facebook</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-facebook text-primary"></i></span>
                                        <input type="url" class="form-control @error('social_facebook') is-invalid @enderror" 
                                               name="social_facebook" value="{{ old('social_facebook', $profile->store_settings['social_facebook'] ?? '') }}" 
                                               placeholder="https://facebook.com/yourpage">
                                    </div>
                                    @error('social_facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Twitter</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-twitter text-info"></i></span>
                                        <input type="url" class="form-control @error('social_twitter') is-invalid @enderror" 
                                               name="social_twitter" value="{{ old('social_twitter', $profile->store_settings['social_twitter'] ?? '') }}" 
                                               placeholder="https://twitter.com/yourhandle">
                                    </div>
                                    @error('social_twitter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-instagram text-danger"></i></span>
                                        <input type="url" class="form-control @error('social_instagram') is-invalid @enderror" 
                                               name="social_instagram" value="{{ old('social_instagram', $profile->store_settings['social_instagram'] ?? '') }}" 
                                               placeholder="https://instagram.com/yourprofile">
                                    </div>
                                    @error('social_instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">LinkedIn</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-linkedin text-primary"></i></span>
                                        <input type="url" class="form-control @error('social_linkedin') is-invalid @enderror" 
                                               name="social_linkedin" value="{{ old('social_linkedin', $profile->store_settings['social_linkedin'] ?? '') }}" 
                                               placeholder="https://linkedin.com/company/yourcompany">
                                    </div>
                                    @error('social_linkedin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Details -->
                <div class="vendor-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-university text-primary me-2"></i>Bank Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                           name="bank_name" value="{{ old('bank_name', $profile->bank_details['bank_name'] ?? '') }}">
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control @error('bank_account_number') is-invalid @enderror" 
                                           name="bank_account_number" value="{{ old('bank_account_number', $profile->bank_details['bank_account_number'] ?? '') }}">
                                    @error('bank_account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Account Name</label>
                                    <input type="text" class="form-control @error('bank_account_name') is-invalid @enderror" 
                                           name="bank_account_name" value="{{ old('bank_account_name', $profile->bank_details['bank_account_name'] ?? '') }}">
                                    @error('bank_account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Swift Code</label>
                                    <input type="text" class="form-control @error('bank_swift_code') is-invalid @enderror" 
                                           name="bank_swift_code" value="{{ old('bank_swift_code', $profile->bank_details['bank_swift_code'] ?? '') }}">
                                    @error('bank_swift_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="vendor-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="vendor-btn vendor-btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button type="submit" class="vendor-btn vendor-btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Store Preview -->
            <div class="vendor-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-eye text-primary me-2"></i>Store Preview</h6>
                </div>
                <div class="card-body">
                    <div class="store-preview">
                        @if($profile->store_banner)
                            <img src="{{ Storage::url($profile->store_banner) }}" 
                                 alt="Store Banner" class="img-fluid rounded mb-3">
                        @else
                            <div class="bg-light rounded p-4 text-center mb-3">
                                <i class="fas fa-image fa-3x text-muted"></i>
                                <p class="text-muted mt-2">No banner uploaded</p>
                            </div>
                        @endif
                        
                        <div class="d-flex align-items-center mb-3">
                            @if($profile->store_logo)
                                <img src="{{ Storage::url($profile->store_logo) }}" 
                                     alt="Store Logo" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-store text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-1">{{ $profile->company_name ?? 'Your Store Name' }}</h6>
                                <small class="text-muted">{{ $profile->business_type ?? 'Business Type' }}</small>
                            </div>
                        </div>
                        
                        <div class="store-stats">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h6 class="text-primary mb-1">{{ $stats['total_products'] }}</h6>
                                        <small class="text-muted">Products</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h6 class="text-success mb-1">{{ $stats['total_orders'] }}</h6>
                                        <small class="text-muted">Orders</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h6 class="text-warning mb-1">{{ number_format($stats['average_rating'], 1) }}</h6>
                                        <small class="text-muted">Rating</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="vendor-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-bolt text-primary me-2"></i>Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('vendor.products') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-box"></i> Manage Products
                        </a>
                        <a href="{{ route('vendor.orders') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-shopping-cart"></i> View Orders
                        </a>
                        <a href="{{ route('vendor.analytics') }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-chart-line"></i> Analytics
                        </a>
                        <a href="{{ route('vendor.promotions') }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-bullhorn"></i> Promotions
                        </a>
                    </div>
                </div>
            </div>

            <!-- Store Status -->
            <div class="vendor-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Store Status</h6>
                </div>
                <div class="card-body">
                    <div class="status-indicator mb-3">
                        <div class="d-flex align-items-center">
                            <div class="status-dot status-{{ $profile->status ?? 'pending' }} me-2"></div>
                            <span class="text-capitalize">{{ $profile->status ?? 'pending' }}</span>
                        </div>
                    </div>
                    
                    @if($profile->status === 'rejected' && $profile->rejection_reason)
                        <div class="alert alert-danger">
                            <strong>Rejection Reason:</strong><br>
                            {{ $profile->rejection_reason }}
                        </div>
                    @endif
                    
                    <div class="store-info">
                        <p><strong>Vendor Code:</strong> {{ $profile->vendor_code ?? 'N/A' }}</p>
                        <p><strong>Commission Rate:</strong> {{ $profile->commission_rate ?? 0 }}%</p>
                        <p><strong>Joined:</strong> {{ $profile->created_at ? $profile->created_at->format('M d, Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logoPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewBanner(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('bannerPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function resetForm() {
    if (confirm('Are you sure you want to reset all changes?')) {
        document.querySelector('form').reset();
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
            localStorage.setItem('storeSettingsDraft', JSON.stringify(data));
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.stat-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
}

.status-pending {
    background-color: #ffc107;
}

.status-approved {
    background-color: #28a745;
}

.status-suspended {
    background-color: #dc3545;
}

.status-rejected {
    background-color: #6c757d;
}

.store-preview {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 15px;
}

.logo-upload-container,
.banner-upload-container {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 20px;
    transition: border-color 0.3s ease;
}

.logo-upload-container:hover,
.banner-upload-container:hover {
    border-color: #007bff;
}

.store-stats .stat-item {
    padding: 10px;
    border-radius: 6px;
    background-color: #f8f9fa;
}

.store-info p {
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.store-info strong {
    color: #495057;
}
</style>
@endpush
