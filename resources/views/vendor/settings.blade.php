@extends('vendor.layouts.app')

@section('page-title', 'Settings')
@section('page-subtitle', 'Manage your account settings and preferences')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Settings Navigation -->
        <div class="col-md-3">
            <div class="vendor-card">
                <div class="card-header">
                    <h6 class="mb-0">Settings</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#account" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                            <i class="fas fa-user me-2"></i>Account Settings
                        </a>
                        <a href="#notifications" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-bell me-2"></i>Notifications
                        </a>
                        <a href="#security" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-shield-alt me-2"></i>Security
                        </a>
                        <a href="#billing" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-credit-card me-2"></i>Billing & Payments
                        </a>
                        <a href="#privacy" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-lock me-2"></i>Privacy
                        </a>
                        <a href="#integrations" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-plug me-2"></i>Integrations
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="col-md-9">
            <div class="tab-content">
                <!-- Account Settings -->
                <div class="tab-pane fade show active" id="account">
                    <div class="vendor-card">
                        <div class="card-header">
                            <h5 class="mb-0">Account Settings</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Display Name</label>
                                            <input type="text" class="form-control" value="TechGear Pro">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" value="techgearpro" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" value="john.doe@example.com">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control" value="+1 (555) 123-4567">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Time Zone</label>
                                    <select class="form-select">
                                        <option value="UTC-8">Pacific Time (UTC-8)</option>
                                        <option value="UTC-7">Mountain Time (UTC-7)</option>
                                        <option value="UTC-6">Central Time (UTC-6)</option>
                                        <option value="UTC-5" selected>Eastern Time (UTC-5)</option>
                                        <option value="UTC+0">UTC</option>
                                        <option value="UTC+1">Central European Time (UTC+1)</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Language</label>
                                    <select class="form-select">
                                        <option value="en" selected>English</option>
                                        <option value="es">Spanish</option>
                                        <option value="fr">French</option>
                                        <option value="de">German</option>
                                        <option value="it">Italian</option>
                                        <option value="pt">Portuguese</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Currency</label>
                                    <select class="form-select">
                                        <option value="USD" selected>US Dollar ($)</option>
                                        <option value="EUR">Euro (€)</option>
                                        <option value="GBP">British Pound (£)</option>
                                        <option value="CAD">Canadian Dollar (C$)</option>
                                        <option value="AUD">Australian Dollar (A$)</option>
                                    </select>
                                </div>
                                <button type="submit" class="vendor-btn vendor-btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="tab-pane fade" id="notifications">
                    <div class="vendor-card">
                        <div class="card-header">
                            <h5 class="mb-0">Notification Settings</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <h6 class="text-primary mb-3">Email Notifications</h6>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="newOrder" checked>
                                    <label class="form-check-label" for="newOrder">
                                        New order notifications
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="orderStatus" checked>
                                    <label class="form-check-label" for="orderStatus">
                                        Order status updates
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="payment" checked>
                                    <label class="form-check-label" for="payment">
                                        Payment confirmations
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="refund">
                                    <label class="form-check-label" for="refund">
                                        Refund requests
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="lowStock" checked>
                                    <label class="form-check-label" for="lowStock">
                                        Low stock alerts
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="marketing">
                                    <label class="form-check-label" for="marketing">
                                        Marketing emails
                                    </label>
                                </div>

                                <hr>

                                <h6 class="text-primary mb-3">Push Notifications</h6>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="pushNewOrder" checked>
                                    <label class="form-check-label" for="pushNewOrder">
                                        New orders
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="pushMessages" checked>
                                    <label class="form-check-label" for="pushMessages">
                                        Customer messages
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="pushReviews">
                                    <label class="form-check-label" for="pushReviews">
                                        New reviews
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="pushSystem">
                                    <label class="form-check-label" for="pushSystem">
                                        System updates
                                    </label>
                                </div>

                                <hr>

                                <h6 class="text-primary mb-3">Notification Frequency</h6>
                                <div class="form-group mb-3">
                                    <label class="form-label">Email Digest</label>
                                    <select class="form-select">
                                        <option value="immediate">Immediate</option>
                                        <option value="hourly">Hourly</option>
                                        <option value="daily" selected>Daily</option>
                                        <option value="weekly">Weekly</option>
                                    </select>
                                </div>

                                <button type="submit" class="vendor-btn vendor-btn-primary">Save Notification Settings</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Security -->
                <div class="tab-pane fade" id="security">
                    <div class="vendor-card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Password & Security</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Current Password</label>
                                            <input type="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">New Password</label>
                                            <input type="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="vendor-btn vendor-btn-primary">Change Password</button>
                            </form>
                        </div>
                    </div>

                    <div class="vendor-card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Two-Factor Authentication</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-1">Two-Factor Authentication</h6>
                                    <small class="text-muted">Add an extra layer of security to your account</small>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                                    <label class="form-check-label" for="twoFactorAuth"></label>
                                </div>
                            </div>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Two-factor authentication adds an extra layer of security by requiring a verification code in addition to your password.
                            </div>
                            <button class="vendor-btn vendor-btn-outline">Setup Two-Factor Auth</button>
                        </div>
                    </div>

                    <div class="vendor-card">
                        <div class="card-header">
                            <h5 class="mb-0">Login Sessions</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="vendor-table">
                                    <thead>
                                        <tr>
                                            <th>Device</th>
                                            <th>Location</th>
                                            <th>Last Activity</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Chrome on Windows</td>
                                            <td>New York, US</td>
                                            <td>2 hours ago</td>
                                            <td><span class="status-badge status-active">Active</span></td>
                                            <td><button class="btn btn-sm btn-outline-danger">Revoke</button></td>
                                        </tr>
                                        <tr>
                                            <td>Safari on iPhone</td>
                                            <td>New York, US</td>
                                            <td>1 day ago</td>
                                            <td><span class="status-badge status-inactive">Inactive</span></td>
                                            <td><button class="btn btn-sm btn-outline-danger">Revoke</button></td>
                                        </tr>
                                        <tr>
                                            <td>Firefox on Mac</td>
                                            <td>Los Angeles, US</td>
                                            <td>3 days ago</td>
                                            <td><span class="status-badge status-inactive">Inactive</span></td>
                                            <td><button class="btn btn-sm btn-outline-danger">Revoke</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="vendor-btn vendor-btn-outline mt-3">Revoke All Sessions</button>
                        </div>
                    </div>
                </div>

                <!-- Billing & Payments -->
                <div class="tab-pane fade" id="billing">
                    <div class="vendor-card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Payment Methods</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Visa ending in 4242</h6>
                                                    <small class="text-muted">Expires 12/25</small>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="defaultPayment" checked>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">Mastercard ending in 8888</h6>
                                                    <small class="text-muted">Expires 08/26</small>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="defaultPayment">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="vendor-btn vendor-btn-outline me-2">Add Payment Method</button>
                            <button class="vendor-btn vendor-btn-outline">Remove Selected</button>
                        </div>
                    </div>

                    <div class="vendor-card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Billing Information</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Billing Name</label>
                                            <input type="text" class="form-control" value="TechGear Pro">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Tax ID</label>
                                            <input type="text" class="form-control" value="12-3456789">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Billing Address</label>
                                    <textarea class="form-control" rows="3">123 Business Street, New York, NY 10001, United States</textarea>
                                </div>
                                <button type="submit" class="vendor-btn vendor-btn-primary">Update Billing Info</button>
                            </form>
                        </div>
                    </div>

                    <div class="vendor-card">
                        <div class="card-header">
                            <h5 class="mb-0">Billing History</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="vendor-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Jan 15, 2024</td>
                                            <td>Platform Commission</td>
                                            <td>-$45.00</td>
                                            <td><span class="status-badge status-paid">Paid</span></td>
                                            <td><button class="btn btn-sm btn-outline-primary">Download</button></td>
                                        </tr>
                                        <tr>
                                            <td>Dec 15, 2023</td>
                                            <td>Platform Commission</td>
                                            <td>-$38.50</td>
                                            <td><span class="status-badge status-paid">Paid</span></td>
                                            <td><button class="btn btn-sm btn-outline-primary">Download</button></td>
                                        </tr>
                                        <tr>
                                            <td>Nov 15, 2023</td>
                                            <td>Platform Commission</td>
                                            <td>-$42.75</td>
                                            <td><span class="status-badge status-paid">Paid</span></td>
                                            <td><button class="btn btn-sm btn-outline-primary">Download</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Privacy -->
                <div class="tab-pane fade" id="privacy">
                    <div class="vendor-card">
                        <div class="card-header">
                            <h5 class="mb-0">Privacy Settings</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <h6 class="text-primary mb-3">Data Sharing</h6>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="shareAnalytics" checked>
                                    <label class="form-check-label" for="shareAnalytics">
                                        Share analytics data to improve services
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="shareMarketing">
                                    <label class="form-check-label" for="shareMarketing">
                                        Allow marketing communications
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="shareThirdParty">
                                    <label class="form-check-label" for="shareThirdParty">
                                        Share data with third-party partners
                                    </label>
                                </div>

                                <hr>

                                <h6 class="text-primary mb-3">Account Privacy</h6>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="profilePublic" checked>
                                    <label class="form-check-label" for="profilePublic">
                                        Make profile publicly visible
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="showContact">
                                    <label class="form-check-label" for="showContact">
                                        Show contact information to customers
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="showLocation">
                                    <label class="form-check-label" for="showLocation">
                                        Show business location
                                    </label>
                                </div>

                                <hr>

                                <h6 class="text-primary mb-3">Data Management</h6>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Warning:</strong> Deleting your account will permanently remove all your data and cannot be undone.
                                </div>
                                <button type="button" class="vendor-btn vendor-btn-outline me-2">Export My Data</button>
                                <button type="button" class="vendor-btn vendor-btn-danger">Delete Account</button>

                                <button type="submit" class="vendor-btn vendor-btn-primary mt-3">Save Privacy Settings</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Integrations -->
                <div class="tab-pane fade" id="integrations">
                    <div class="vendor-card">
                        <div class="card-header">
                            <h5 class="mb-0">Third-Party Integrations</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h6 class="mb-1">Google Analytics</h6>
                                                    <small class="text-muted">Track your store performance</small>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="googleAnalytics" checked>
                                                </div>
                                            </div>
                                            <button class="vendor-btn vendor-btn-outline btn-sm">Configure</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h6 class="mb-1">Facebook Pixel</h6>
                                                    <small class="text-muted">Track conversions and optimize ads</small>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="facebookPixel">
                                                </div>
                                            </div>
                                            <button class="vendor-btn vendor-btn-outline btn-sm">Configure</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h6 class="mb-1">Mailchimp</h6>
                                                    <small class="text-muted">Email marketing automation</small>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="mailchimp">
                                                </div>
                                            </div>
                                            <button class="vendor-btn vendor-btn-outline btn-sm">Configure</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h6 class="mb-1">Zapier</h6>
                                                    <small class="text-muted">Automate workflows</small>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="zapier">
                                                </div>
                                            </div>
                                            <button class="vendor-btn vendor-btn-outline btn-sm">Configure</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    // Handle form submissions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = form.querySelector('.vendor-btn-primary');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                submitBtn.disabled = true;
                
                // Simulate API call
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    showAlert('Settings saved successfully!', 'success');
                }, 2000);
            }
        });
    });

    // Handle tab navigation
    const tabLinks = document.querySelectorAll('[data-bs-toggle="list"]');
    tabLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Remove active class from all links
            tabLinks.forEach(l => l.classList.remove('active'));
            // Add active class to clicked link
            this.classList.add('active');
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
