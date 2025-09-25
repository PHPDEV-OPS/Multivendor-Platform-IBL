@extends('layouts.unified')

@section('page-title', 'Promotions')
@section('page-subtitle', 'Manage discounts, coupons, and marketing campaigns')

@section('content')
<div class="container-fluid">
    <!-- Promotion Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="user-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="stats-content">
                        <h4>12</h4>
                        <p>Active Promotions</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="user-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="stats-content">
                        <h4>8</h4>
                        <p>Active Coupons</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="user-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stats-content">
                        <h4>$2,450</h4>
                        <p>Revenue from Promos</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="user-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-content">
                        <h4>156</h4>
                        <p>Promo Redemptions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Promotions List -->
        <div class="col-md-8">
            <div class="user-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Active Promotions</h5>
                    <button class="user-btn user-btn-primary" data-bs-toggle="modal" data-bs-target="#newPromotionModal">
                        <i class="fas fa-plus"></i> Create Promotion
                    </button>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-select">
                                <option>All Types</option>
                                <option>Discount</option>
                                <option>Free Shipping</option>
                                <option>Buy One Get One</option>
                                <option>Flash Sale</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select">
                                <option>All Status</option>
                                <option>Active</option>
                                <option>Scheduled</option>
                                <option>Paused</option>
                                <option>Expired</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" placeholder="Search promotions...">
                        </div>
                        <div class="col-md-2">
                            <button class="user-btn user-btn-secondary w-100">Filter</button>
                        </div>
                    </div>

                    <!-- Promotions Table -->
                    <div class="table-responsive">
                        <table class="user-table">
                            <thead>
                                <tr>
                                    <th>Promotion</th>
                                    <th>Type</th>
                                    <th>Discount</th>
                                    <th>Usage</th>
                                    <th>Status</th>
                                    <th>End Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">Summer Sale 2024</h6>
                                            <small class="text-muted">SUMMER20</small>
                                        </div>
                                    </td>
                                    <td>Percentage Discount</td>
                                    <td>20% OFF</td>
                                    <td>45/100</td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>Jan 31, 2024</td>
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
                                            <h6 class="mb-1">Free Shipping Weekend</h6>
                                            <small class="text-muted">FREESHIP</small>
                                        </div>
                                    </td>
                                    <td>Free Shipping</td>
                                    <td>Free Shipping</td>
                                    <td>23/50</td>
                                    <td><span class="status-badge status-active">Active</span></td>
                                    <td>Jan 28, 2024</td>
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
                                            <h6 class="mb-1">New Customer Discount</h6>
                                            <small class="text-muted">NEWCUST10</small>
                                        </div>
                                    </td>
                                    <td>Fixed Amount</td>
                                    <td>$10 OFF</td>
                                    <td>12/25</td>
                                    <td><span class="status-badge status-scheduled">Scheduled</span></td>
                                    <td>Feb 15, 2024</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-play me-2"></i>Activate</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">Buy 2 Get 1 Free</h6>
                                            <small class="text-muted">B2G1FREE</small>
                                        </div>
                                    </td>
                                    <td>Buy One Get One</td>
                                    <td>Buy 2 Get 1</td>
                                    <td>8/15</td>
                                    <td><span class="status-badge status-paused">Paused</span></td>
                                    <td>Jan 25, 2024</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-copy me-2"></i>Duplicate</a></li>
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-play me-2"></i>Resume</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-3">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="user-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="user-btn user-btn-outline" data-bs-toggle="modal" data-bs-target="#newPromotionModal">
                            <i class="fas fa-plus me-2"></i>Create New Promotion
                        </button>
                        <button class="user-btn user-btn-outline">
                            <i class="fas fa-import me-2"></i>Import Promotions
                        </button>
                        <button class="user-btn user-btn-outline">
                            <i class="fas fa-download me-2"></i>Export Data
                        </button>
                        <button class="user-btn user-btn-outline">
                            <i class="fas fa-chart-bar me-2"></i>View Analytics
                        </button>
                    </div>
                </div>
            </div>

            <!-- Promotion Performance -->
            <div class="user-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Top Performing Promotions</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Summer Sale 2024</h6>
                                <small class="text-muted">45 redemptions</small>
                            </div>
                            <span class="badge bg-success rounded-pill">$890</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Free Shipping Weekend</h6>
                                <small class="text-muted">23 redemptions</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">$450</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">New Customer Discount</h6>
                                <small class="text-muted">12 redemptions</small>
                            </div>
                            <span class="badge bg-warning rounded-pill">$120</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promotion Tips -->
            <div class="user-card">
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
        </div>
    </div>
</div>

<!-- New Promotion Modal -->
<div class="modal fade" id="newPromotionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Promotion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <!-- Basic Information -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Promotion Name *</label>
                                <input type="text" class="form-control" placeholder="e.g., Summer Sale 2024" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Coupon Code</label>
                                <input type="text" class="form-control" placeholder="e.g., SUMMER20">
                                <small class="text-muted">Leave blank for automatic generation</small>
                            </div>
                        </div>
                    </div>

                    <!-- Promotion Type -->
                    <div class="form-group mb-3">
                        <label class="form-label">Promotion Type *</label>
                        <select class="form-select" required>
                            <option value="">Select Promotion Type</option>
                            <option value="percentage">Percentage Discount</option>
                            <option value="fixed">Fixed Amount Discount</option>
                            <option value="free_shipping">Free Shipping</option>
                            <option value="buy_one_get_one">Buy One Get One</option>
                            <option value="flash_sale">Flash Sale</option>
                        </select>
                    </div>

                    <!-- Discount Details -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Discount Value *</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" placeholder="20" required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Minimum Order Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" placeholder="50.00" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Usage Limits -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Maximum Usage</label>
                                <input type="number" class="form-control" placeholder="100">
                                <small class="text-muted">Leave blank for unlimited</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Usage Per Customer</label>
                                <input type="number" class="form-control" placeholder="1" value="1">
                            </div>
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Start Date *</label>
                                <input type="datetime-local" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">End Date *</label>
                                <input type="datetime-local" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- Applicable Products -->
                    <div class="form-group mb-3">
                        <label class="form-label">Applicable Products</label>
                        <select class="form-select">
                            <option value="all">All Products</option>
                            <option value="specific">Specific Products</option>
                            <option value="category">Specific Categories</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="form-group mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" placeholder="Enter promotion description..."></textarea>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="form-group mb-3">
                        <label class="form-label">Terms & Conditions</label>
                        <textarea class="form-control" rows="3" placeholder="Enter terms and conditions..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="user-btn user-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="user-btn user-btn-outline me-2">Save as Draft</button>
                <button type="button" class="user-btn user-btn-primary">Create Promotion</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle promotion type change
    const promotionTypeSelect = document.querySelector('#newPromotionModal select');
    const discountValueInput = document.querySelector('#newPromotionModal input[type="number"]');
    const discountValueGroup = discountValueInput.parentElement;
    
    promotionTypeSelect.addEventListener('change', function() {
        const type = this.value;
        const suffix = discountValueGroup.querySelector('.input-group-text');
        
        switch(type) {
            case 'percentage':
                suffix.textContent = '%';
                discountValueInput.placeholder = '20';
                break;
            case 'fixed':
                suffix.textContent = '$';
                discountValueInput.placeholder = '10.00';
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
            default:
                suffix.textContent = '%';
                discountValueInput.disabled = false;
                break;
        }
    });
    
    // Handle form submission
    const createPromotionBtn = document.querySelector('#newPromotionModal .user-btn-primary');
    createPromotionBtn.addEventListener('click', function() {
        // Show loading state
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
        this.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            this.innerHTML = originalText;
            this.disabled = false;
            
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('newPromotionModal')).hide();
            
            // Show success message
            showAlert('Promotion created successfully!', 'success');
        }, 2000);
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
