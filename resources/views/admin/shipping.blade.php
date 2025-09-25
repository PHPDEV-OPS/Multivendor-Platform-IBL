@extends('admin.layouts.app')

@section('page-title', 'Shipping')
@section('page-subtitle', 'Manage shipping zones, rates, and methods')

@section('content')
<div class="container-fluid">
    <!-- Shipping Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="stats-content">
                        <h4>8</h4>
                        <p>Shipping Zones</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="stats-content">
                        <h4>12</h4>
                        <p>Shipping Methods</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stats-content">
                        <h4>156</h4>
                        <p>Orders Shipped</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stats-content">
                        <h4>$890</h4>
                        <p>Shipping Revenue</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Shipping Zones -->
        <div class="col-md-8">
            <div class="admin-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Shipping Zones</h5>
                    <button class="admin-btn admin-btn-primary" data-bs-toggle="modal" data-bs-target="#newZoneModal">
                        <i class="fas fa-plus"></i> Add Zone
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Zone Name</th>
                                    <th>Countries/Regions</th>
                                    <th>Shipping Methods</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">United States</h6>
                                            <small class="text-muted">Domestic shipping</small>
                                        </div>
                                    </td>
                                    <td>United States (All states)</td>
                                    <td>3 methods</td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Manage Methods</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">Canada</h6>
                                            <small class="text-muted">International shipping</small>
                                        </div>
                                    </td>
                                    <td>Canada (All provinces)</td>
                                    <td>2 methods</td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Manage Methods</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">Europe</h6>
                                            <small class="text-muted">International shipping</small>
                                        </div>
                                    </td>
                                    <td>EU Countries (27 countries)</td>
                                    <td>1 method</td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Manage Methods</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">Rest of World</h6>
                                            <small class="text-muted">International shipping</small>
                                        </div>
                                    </td>
                                    <td>All other countries</td>
                                    <td>1 method</td>
                                    <td><span class="status-badge status-inactive">Inactive</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Manage Methods</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Shipping Methods -->
            <div class="admin-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Shipping Methods</h5>
                    <button class="admin-btn admin-btn-primary" data-bs-toggle="modal" data-bs-target="#newMethodModal">
                        <i class="fas fa-plus"></i> Add Method
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Method Name</th>
                                    <th>Zone</th>
                                    <th>Cost</th>
                                    <th>Delivery Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">Standard Shipping</h6>
                                            <small class="text-muted">USPS Ground</small>
                                        </div>
                                    </td>
                                    <td>United States</td>
                                    <td>$5.99</td>
                                    <td>3-5 business days</td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-pause me-2"></i>Pause</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">Express Shipping</h6>
                                            <small class="text-muted">FedEx 2Day</small>
                                        </div>
                                    </td>
                                    <td>United States</td>
                                    <td>$12.99</td>
                                    <td>2 business days</td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-pause me-2"></i>Pause</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">Overnight Shipping</h6>
                                            <small class="text-muted">FedEx Overnight</small>
                                        </div>
                                    </td>
                                    <td>United States</td>
                                    <td>$24.99</td>
                                    <td>1 business day</td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-pause me-2"></i>Pause</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">Canada Standard</h6>
                                            <small class="text-muted">Canada Post</small>
                                        </div>
                                    </td>
                                    <td>Canada</td>
                                    <td>$15.99</td>
                                    <td>5-7 business days</td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-pause me-2"></i>Pause</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">International Standard</h6>
                                            <small class="text-muted">DHL International</small>
                                        </div>
                                    </td>
                                    <td>Europe</td>
                                    <td>$29.99</td>
                                    <td>7-10 business days</td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-pause me-2"></i>Pause</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="admin-btn admin-btn-outline" data-bs-toggle="modal" data-bs-target="#newZoneModal">
                            <i class="fas fa-globe me-2"></i>Add Shipping Zone
                        </button>
                        <button class="admin-btn admin-btn-outline" data-bs-toggle="modal" data-bs-target="#newMethodModal">
                            <i class="fas fa-truck me-2"></i>Add Shipping Method
                        </button>
                        <button class="admin-btn admin-btn-outline">
                            <i class="fas fa-download me-2"></i>Export Settings
                        </button>
                        <button class="admin-btn admin-btn-outline">
                            <i class="fas fa-upload me-2"></i>Import Settings
                        </button>
                    </div>
                </div>
            </div>

            <!-- Shipping Statistics -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Shipping Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Total Orders Shipped:</span>
                        <span class="fw-bold">156</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Average Shipping Cost:</span>
                        <span class="fw-bold">$8.45</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Most Popular Method:</span>
                        <span class="fw-bold">Standard</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>On-Time Delivery Rate:</span>
                        <span class="fw-bold">98.5%</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Customer Satisfaction:</span>
                        <span class="fw-bold">4.8/5</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Tips -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0">Shipping Tips</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading"><i class="fas fa-lightbulb me-2"></i>Best Practices</h6>
                        <ul class="mb-0">
                            <li>Offer multiple shipping options</li>
                            <li>Set realistic delivery times</li>
                            <li>Provide tracking information</li>
                            <li>Consider free shipping thresholds</li>
                            <li>Regularly review shipping costs</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Zone Modal -->
<div class="modal fade" id="newZoneModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Shipping Zone</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group mb-3">
                        <label class="form-label">Zone Name *</label>
                        <input type="text" class="form-control" placeholder="e.g., United States" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Zone Type</label>
                        <select class="form-select">
                            <option value="countries">Countries</option>
                            <option value="states">States/Provinces</option>
                            <option value="postcodes">Postal Codes</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Select Countries/Regions</label>
                        <select class="form-select" multiple size="6">
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="MX">Mexico</option>
                            <option value="GB">United Kingdom</option>
                            <option value="DE">Germany</option>
                            <option value="FR">France</option>
                            <option value="IT">Italy</option>
                            <option value="ES">Spain</option>
                            <option value="AU">Australia</option>
                            <option value="JP">Japan</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" placeholder="Enter zone description..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="admin-btn admin-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="admin-btn admin-btn-primary">Create Zone</button>
            </div>
        </div>
    </div>
</div>

<!-- New Method Modal -->
<div class="modal fade" id="newMethodModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Shipping Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Method Name *</label>
                                <input type="text" class="form-control" placeholder="e.g., Standard Shipping" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Carrier</label>
                                <input type="text" class="form-control" placeholder="e.g., USPS, FedEx">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Shipping Zone *</label>
                                <select class="form-select" required>
                                    <option value="">Select Zone</option>
                                    <option value="us">United States</option>
                                    <option value="ca">Canada</option>
                                    <option value="eu">Europe</option>
                                    <option value="row">Rest of World</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Cost Type</label>
                                <select class="form-select">
                                    <option value="fixed">Fixed Cost</option>
                                    <option value="weight">Weight Based</option>
                                    <option value="price">Price Based</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Shipping Cost *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" placeholder="5.99" step="0.01" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Delivery Time</label>
                                <input type="text" class="form-control" placeholder="e.g., 3-5 business days">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Minimum Order Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" placeholder="0.00" step="0.01">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Maximum Order Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" placeholder="0.00" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" placeholder="Enter method description..."></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="freeShipping">
                        <label class="form-check-label" for="freeShipping">
                            Free shipping for orders above minimum amount
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="admin-btn admin-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="admin-btn admin-btn-primary">Create Method</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submissions
    const createZoneBtn = document.querySelector('#newZoneModal .admin-btn-primary');
    const createMethodBtn = document.querySelector('#newMethodModal .admin-btn-primary');
    
    if (createZoneBtn) {
        createZoneBtn.addEventListener('click', function() {
            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
            this.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
                
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('newZoneModal')).hide();
                
                // Show success message
                showAlert('Shipping zone created successfully!', 'success');
            }, 2000);
        });
    }
    
    if (createMethodBtn) {
        createMethodBtn.addEventListener('click', function() {
            // Show loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
            this.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
                
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('newMethodModal')).hide();
                
                // Show success message
                showAlert('Shipping method created successfully!', 'success');
            }, 2000);
        });
    }
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
