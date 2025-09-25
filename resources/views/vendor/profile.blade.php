@extends('vendor.layouts.app')

@section('page-title', 'Profile')
@section('page-subtitle', 'Manage your personal and business information')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-8">
            <!-- Personal Information -->
            <div class="vendor-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">First Name *</label>
                                    <input type="text" class="form-control" value="John" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" value="Doe" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" value="john.doe@example.com" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" value="+1 (555) 123-4567">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" value="1990-01-15">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Gender</label>
                                    <select class="form-select">
                                        <option value="">Select Gender</option>
                                        <option value="male" selected>Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                        <option value="prefer-not">Prefer not to say</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Bio</label>
                            <textarea class="form-control" rows="3" placeholder="Tell us about yourself...">Experienced vendor with 5+ years in e-commerce. Specializing in electronics and accessories.</textarea>
                        </div>
                        <button type="submit" class="vendor-btn vendor-btn-primary">Update Personal Information</button>
                    </form>
                </div>
            </div>

            <!-- Business Information -->
            <div class="vendor-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Business Information</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Business Name *</label>
                                    <input type="text" class="form-control" value="TechGear Pro" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Business Type</label>
                                    <select class="form-select">
                                        <option value="">Select Business Type</option>
                                        <option value="individual" selected>Individual</option>
                                        <option value="partnership">Partnership</option>
                                        <option value="corporation">Corporation</option>
                                        <option value="llc">LLC</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Tax ID / EIN</label>
                                    <input type="text" class="form-control" value="12-3456789" placeholder="Enter your tax identification number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Business Website</label>
                                    <input type="url" class="form-control" value="https://techgearpro.com" placeholder="https://yourwebsite.com">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Business Description</label>
                            <textarea class="form-control" rows="3" placeholder="Describe your business...">Leading provider of high-quality electronics and accessories. We specialize in wireless technology and mobile accessories.</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Years in Business</label>
                                    <input type="number" class="form-control" value="5" min="0" max="50">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Number of Employees</label>
                                    <input type="number" class="form-control" value="10" min="1" max="1000">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="vendor-btn vendor-btn-primary">Update Business Information</button>
                    </form>
                </div>
            </div>

            <!-- Address Information -->
            <div class="vendor-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Address Information</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Primary Address</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Street Address *</label>
                                    <input type="text" class="form-control" value="123 Business Street" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">City *</label>
                                    <input type="text" class="form-control" value="New York" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">State *</label>
                                            <input type="text" class="form-control" value="NY" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">ZIP Code *</label>
                                            <input type="text" class="form-control" value="10001" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Country *</label>
                                    <select class="form-select" required>
                                        <option value="US" selected>United States</option>
                                        <option value="CA">Canada</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="AU">Australia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Shipping Address</h6>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="sameAsPrimary" checked>
                                    <label class="form-check-label" for="sameAsPrimary">
                                        Same as primary address
                                    </label>
                                </div>
                                <div id="shippingAddress" style="display: none;">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Street Address</label>
                                        <input type="text" class="form-control" value="456 Shipping Lane">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">City</label>
                                        <input type="text" class="form-control" value="Los Angeles">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">State</label>
                                                <input type="text" class="form-control" value="CA">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">ZIP Code</label>
                                                <input type="text" class="form-control" value="90210">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Country</label>
                                        <select class="form-select">
                                            <option value="US" selected>United States</option>
                                            <option value="CA">Canada</option>
                                            <option value="UK">United Kingdom</option>
                                            <option value="AU">Australia</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="vendor-btn vendor-btn-primary">Update Address Information</button>
                    </form>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="vendor-card">
                <div class="card-header">
                    <h5 class="mb-0">Social Media Links</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Facebook</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                        <input type="url" class="form-control" value="https://facebook.com/techgearpro" placeholder="https://facebook.com/yourpage">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Twitter</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                        <input type="url" class="form-control" value="https://twitter.com/techgearpro" placeholder="https://twitter.com/yourhandle">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                        <input type="url" class="form-control" value="https://instagram.com/techgearpro" placeholder="https://instagram.com/yourprofile">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">LinkedIn</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                        <input type="url" class="form-control" value="https://linkedin.com/company/techgearpro" placeholder="https://linkedin.com/company/yourcompany">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">YouTube</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                        <input type="url" class="form-control" value="https://youtube.com/techgearpro" placeholder="https://youtube.com/yourchannel">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">TikTok</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                                        <input type="url" class="form-control" value="https://tiktok.com/@techgearpro" placeholder="https://tiktok.com/@yourhandle">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="vendor-btn vendor-btn-primary">Update Social Media Links</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Profile Picture -->
            <div class="vendor-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Profile Picture</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="https://via.placeholder.com/150x150?text=Profile" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <div class="mb-3">
                        <input type="file" class="form-control" accept="image/*" onchange="previewImage(this)">
                    </div>
                    <button class="vendor-btn vendor-btn-outline">Upload New Picture</button>
                </div>
            </div>

            <!-- Account Status -->
            <div class="vendor-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Account Status</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Account Status:</span>
                        <span class="status-badge status-active">Active</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Verification Status:</span>
                        <span class="status-badge status-verified">Verified</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Member Since:</span>
                        <span>Jan 2023</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Last Login:</span>
                        <span>2 hours ago</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="vendor-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="vendor-btn vendor-btn-outline">
                            <i class="fas fa-key me-2"></i>Change Password
                        </button>
                        <button class="vendor-btn vendor-btn-outline">
                            <i class="fas fa-shield-alt me-2"></i>Two-Factor Auth
                        </button>
                        <button class="vendor-btn vendor-btn-outline">
                            <i class="fas fa-bell me-2"></i>Notification Settings
                        </button>
                        <button class="vendor-btn vendor-btn-outline">
                            <i class="fas fa-download me-2"></i>Export Data
                        </button>
                    </div>
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="vendor-card">
                <div class="card-header">
                    <h6 class="mb-0">Account Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Total Sales:</span>
                        <span class="fw-bold">$45,230</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Products Listed:</span>
                        <span class="fw-bold">24</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Orders Completed:</span>
                        <span class="fw-bold">156</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Customer Rating:</span>
                        <span class="fw-bold">4.8/5</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Response Rate:</span>
                        <span class="fw-bold">98%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = input.parentElement.previousElementSibling.querySelector('img');
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Handle shipping address toggle
    const sameAsPrimaryCheckbox = document.getElementById('sameAsPrimary');
    const shippingAddressDiv = document.getElementById('shippingAddress');
    
    sameAsPrimaryCheckbox.addEventListener('change', function() {
        if (this.checked) {
            shippingAddressDiv.style.display = 'none';
        } else {
            shippingAddressDiv.style.display = 'block';
        }
    });
    
    // Form submission handlers
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = form.querySelector('.vendor-btn-primary');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
            submitBtn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                // Show success message
                showAlert('Information updated successfully!', 'success');
            }, 2000);
        });
    });
});

function showAlert(message, type) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}
</script>
@endpush
