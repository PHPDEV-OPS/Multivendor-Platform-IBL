@extends('layouts.unified')

@section('page-title', 'Store Settings')
@section('page-subtitle', 'Manage your store information and branding')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Store Settings</h4>
        <p class="text-muted mb-0">Manage your store information and branding</p>
    </div>
    <button class="user-btn" onclick="saveStoreSettings()">
        <i class="fas fa-save"></i> Save Changes
    </button>
</div>

<form id="storeSettingsForm">
    <div class="row">
        <!-- Store Information -->
        <div class="col-md-8">
            <div class="user-card">
                <h5 class="mb-3">Store Information</h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="store_name" class="form-label">Store Name *</label>
                            <input type="text" class="form-control" id="store_name" name="store_name" value="TUNUNUE Store" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="store_slug" class="form-label">Store URL</label>
                            <div class="input-group">
                                <span class="input-group-text">tununue.com/store/</span>
                                <input type="text" class="form-control" id="store_slug" name="store_slug" value="tununue-store">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="store_description" class="form-label">Store Description</label>
                    <textarea class="form-control" id="store_description" name="store_description" rows="4" placeholder="Tell customers about your store...">We are a leading provider of high-quality beauty and personal care products in Kenya. Our mission is to provide customers with the best products at competitive prices.</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="store_email" class="form-label">Store Email *</label>
                            <input type="email" class="form-control" id="store_email" name="store_email" value="store@tununue.com" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="store_phone" class="form-label">Store Phone</label>
                            <input type="tel" class="form-control" id="store_phone" name="store_phone" value="+254 700 123 456">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="store_address" class="form-label">Store Address</label>
                    <textarea class="form-control" id="store_address" name="store_address" rows="3" placeholder="Enter your store address...">123 Main Street, Nairobi, Kenya</textarea>
                </div>
            </div>

            <!-- Store Policies -->
            <div class="user-card">
                <h5 class="mb-3">Store Policies</h5>
                
                <div class="form-group mb-3">
                    <label for="return_policy" class="form-label">Return Policy</label>
                    <textarea class="form-control" id="return_policy" name="return_policy" rows="4" placeholder="Describe your return policy...">We accept returns within 14 days of purchase. Items must be in original condition with all packaging intact. Return shipping costs are the responsibility of the customer.</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="shipping_policy" class="form-label">Shipping Policy</label>
                    <textarea class="form-control" id="shipping_policy" name="shipping_policy" rows="4" placeholder="Describe your shipping policy...">Standard shipping takes 3-5 business days. Express shipping (1-2 days) is available for an additional fee. Free shipping on orders over KSh 5,000.</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="privacy_policy" class="form-label">Privacy Policy</label>
                    <textarea class="form-control" id="privacy_policy" name="privacy_policy" rows="4" placeholder="Describe your privacy policy...">We respect your privacy and are committed to protecting your personal information. We will never share your data with third parties without your consent.</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="terms_conditions" class="form-label">Terms & Conditions</label>
                    <textarea class="form-control" id="terms_conditions" name="terms_conditions" rows="4" placeholder="Describe your terms and conditions...">By using our store, you agree to these terms and conditions. We reserve the right to modify these terms at any time.</textarea>
                </div>
            </div>

            <!-- Business Hours -->
            <div class="user-card">
                <h5 class="mb-3">Business Hours</h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="business_hours" class="form-label">Business Hours</label>
                            <select class="form-select" id="business_hours" name="business_hours">
                                <option value="24_7">24/7 Online Store</option>
                                <option value="business_hours">Business Hours Only</option>
                                <option value="custom">Custom Hours</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="timezone" class="form-label">Timezone</label>
                            <select class="form-select" id="timezone" name="timezone">
                                <option value="Africa/Nairobi" selected>Africa/Nairobi (GMT+3)</option>
                                <option value="UTC">UTC</option>
                                <option value="America/New_York">America/New_York</option>
                                <option value="Europe/London">Europe/London</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="customHours" class="d-none">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="opening_time" class="form-label">Opening Time</label>
                                <input type="time" class="form-control" id="opening_time" name="opening_time" value="09:00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="closing_time" class="form-label">Closing Time</label>
                                <input type="time" class="form-control" id="closing_time" name="closing_time" value="18:00">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Store Logo -->
            <div class="user-card">
                <h5 class="mb-3">Store Logo</h5>
                
                <div class="text-center mb-3">
                    <img src="{{ asset('uploads/settings/67b5a3c7831f0.png') }}" alt="Store Logo" class="img-fluid rounded" style="max-height: 150px;">
                </div>
                
                <div class="form-group mb-3">
                    <label for="store_logo" class="form-label">Upload New Logo</label>
                    <input type="file" class="form-control" id="store_logo" name="store_logo" accept="image/*">
                    <small class="text-muted">Recommended size: 300x300px, Max size: 2MB</small>
                </div>
            </div>

            <!-- Store Banner -->
            <div class="user-card">
                <h5 class="mb-3">Store Banner</h5>
                
                <div class="text-center mb-3">
                    <div style="height: 100px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <span class="text-muted">No banner uploaded</span>
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="store_banner" class="form-label">Upload Banner</label>
                    <input type="file" class="form-control" id="store_banner" name="store_banner" accept="image/*">
                    <small class="text-muted">Recommended size: 1200x300px, Max size: 5MB</small>
                </div>
            </div>

            <!-- Social Media -->
            <div class="user-card">
                <h5 class="mb-3">Social Media</h5>
                
                <div class="form-group mb-3">
                    <label for="facebook_url" class="form-label">Facebook URL</label>
                    <input type="url" class="form-control" id="facebook_url" name="facebook_url" placeholder="https://facebook.com/yourstore">
                </div>

                <div class="form-group mb-3">
                    <label for="instagram_url" class="form-label">Instagram URL</label>
                    <input type="url" class="form-control" id="instagram_url" name="instagram_url" placeholder="https://instagram.com/yourstore">
                </div>

                <div class="form-group mb-3">
                    <label for="twitter_url" class="form-label">Twitter URL</label>
                    <input type="url" class="form-control" id="twitter_url" name="twitter_url" placeholder="https://twitter.com/yourstore">
                </div>

                <div class="form-group mb-3">
                    <label for="youtube_url" class="form-label">YouTube URL</label>
                    <input type="url" class="form-control" id="youtube_url" name="youtube_url" placeholder="https://youtube.com/yourstore">
                </div>
            </div>

            <!-- Store Status -->
            <div class="user-card">
                <h5 class="mb-3">Store Status</h5>
                
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="store_active" name="store_active" checked>
                    <label class="form-check-label" for="store_active">
                        Store is Active
                    </label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="accept_orders" name="accept_orders" checked>
                    <label class="form-check-label" for="accept_orders">
                        Accept New Orders
                    </label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="show_in_search" name="show_in_search" checked>
                    <label class="form-check-label" for="show_in_search">
                        Show in Search Results
                    </label>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="featured_store" name="featured_store">
                    <label class="form-check-label" for="featured_store">
                        Featured Store
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const businessHoursSelect = document.getElementById('business_hours');
    const customHoursDiv = document.getElementById('customHours');
    
    businessHoursSelect.addEventListener('change', function() {
        if (this.value === 'custom') {
            customHoursDiv.classList.remove('d-none');
        } else {
            customHoursDiv.classList.add('d-none');
        }
    });
});

function saveStoreSettings() {
    // Show loading state
    const saveBtn = document.querySelector('.user-btn');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    saveBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        // Show success message
        saveBtn.innerHTML = '<i class="fas fa-check"></i> Saved!';
        saveBtn.style.background = 'var(--success_color)';
        
        // Reset button after 2 seconds
        setTimeout(() => {
            saveBtn.innerHTML = originalText;
            saveBtn.style.background = '';
            saveBtn.disabled = false;
        }, 2000);
    }, 1500);
}
</script>
@endpush
