@extends('admin.layouts.app')

@section('page-title', 'Order Details')
@section('page-subtitle', 'Order #{{ $id }}')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Order Information -->
        <div class="col-md-8">
            <div class="admin-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Order #{{ $id }}</h5>
                    <div>
                        <button class="admin-btn admin-btn-outline me-2">
                            <i class="fas fa-print"></i> Print Invoice
                        </button>
                        <button class="admin-btn admin-btn-primary">
                            <i class="fas fa-envelope"></i> Send Email
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Order Status -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <span class="status-badge status-processing me-3">Processing</span>
                                <span class="text-muted">Order placed on Jan 15, 2024 at 2:30 PM</span>
                            </div>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar bg-primary" style="width: 60%"></div>
                            </div>
                            <div class="d-flex justify-content-between text-sm">
                                <span>Order Placed</span>
                                <span>Processing</span>
                                <span>Shipped</span>
                                <span>Delivered</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <h6 class="text-primary mb-2">Order Total</h6>
                                <h4 class="mb-0">$156.98</h4>
                                <small class="text-muted">Including tax and shipping</small>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <h6 class="text-primary mb-3">Order Items</h6>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/50x50?text=Product" alt="Product" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-1">Wireless Bluetooth Headphones</h6>
                                                <small class="text-muted">Color: Black</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>WH-BT-001</td>
                                    <td>$89.99</td>
                                    <td>1</td>
                                    <td>$89.99</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://via.placeholder.com/50x50?text=Product" alt="Product" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-1">Phone Case - Premium</h6>
                                                <small class="text-muted">Size: iPhone 13</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>PC-PREM-001</td>
                                    <td>$24.99</td>
                                    <td>2</td>
                                    <td>$49.98</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Order Summary -->
                    <div class="row mt-4">
                        <div class="col-md-6 offset-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-primary mb-3">Order Summary</h6>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span>$139.97</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Shipping:</span>
                                        <span>$5.99</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Tax:</span>
                                        <span>$11.02</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total:</span>
                                        <span>$156.98</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Customer Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Billing Address</h6>
                            <p class="mb-1"><strong>John Doe</strong></p>
                            <p class="mb-1">123 Main Street</p>
                            <p class="mb-1">Apt 4B</p>
                            <p class="mb-1">New York, NY 10001</p>
                            <p class="mb-1">United States</p>
                            <p class="mb-0">Phone: (555) 123-4567</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Shipping Address</h6>
                            <p class="mb-1"><strong>John Doe</strong></p>
                            <p class="mb-1">123 Main Street</p>
                            <p class="mb-1">Apt 4B</p>
                            <p class="mb-1">New York, NY 10001</p>
                            <p class="mb-1">United States</p>
                            <p class="mb-0">Phone: (555) 123-4567</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0">Order Notes</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <textarea class="form-control" rows="3" placeholder="Add a note about this order..."></textarea>
                    </div>
                    <button class="admin-btn admin-btn-primary">Add Note</button>
                    
                    <div class="mt-4">
                        <h6 class="text-primary mb-3">Previous Notes</h6>
                        <div class="border-start border-primary ps-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Jan 15, 2024 - 3:45 PM</small>
                                <small class="text-muted">Admin</small>
                            </div>
                            <p class="mb-0">Order confirmed and payment received. Processing for shipment.</p>
                        </div>
                        <div class="border-start border-primary ps-3">
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Jan 15, 2024 - 2:30 PM</small>
                                <small class="text-muted">System</small>
                            </div>
                            <p class="mb-0">Order placed successfully.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Order Actions -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Order Actions</h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Update Status</label>
                        <select class="form-select">
                            <option>Pending</option>
                            <option selected>Processing</option>
                            <option>Shipped</option>
                            <option>Delivered</option>
                            <option>Cancelled</option>
                        </select>
                    </div>
                    <button class="admin-btn admin-btn-primary w-100 mb-2">Update Status</button>
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <button class="admin-btn admin-btn-outline">
                            <i class="fas fa-truck me-2"></i>Mark as Shipped
                        </button>
                        <button class="admin-btn admin-btn-outline">
                            <i class="fas fa-check me-2"></i>Mark as Delivered
                        </button>
                        <button class="admin-btn admin-btn-outline">
                            <i class="fas fa-times me-2"></i>Cancel Order
                        </button>
                        <button class="admin-btn admin-btn-outline">
                            <i class="fas fa-undo me-2"></i>Refund Order
                        </button>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Payment Information</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Payment Method:</span>
                        <span>Credit Card</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Payment Status:</span>
                        <span class="status-badge status-paid">Paid</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Transaction ID:</span>
                        <span>TXN-123456789</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Paid Amount:</span>
                        <span>$156.98</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Payment Date:</span>
                        <span>Jan 15, 2024</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="admin-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Shipping Information</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping Method:</span>
                        <span>Standard Shipping</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping Cost:</span>
                        <span>$5.99</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Estimated Delivery:</span>
                        <span>Jan 18-20, 2024</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tracking Number:</span>
                        <span>1Z999AA1234567890</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Carrier:</span>
                        <span>UPS</span>
                    </div>
                    
                    <hr>
                    
                    <div class="form-group mb-3">
                        <label class="form-label">Add Tracking Number</label>
                        <input type="text" class="form-control" placeholder="Enter tracking number">
                    </div>
                    <button class="admin-btn admin-btn-outline w-100">Update Tracking</button>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="admin-card">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-file-pdf me-3 text-danger"></i>
                            <div>
                                <h6 class="mb-1">Download Invoice</h6>
                                <small class="text-muted">PDF format</small>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-envelope me-3 text-primary"></i>
                            <div>
                                <h6 class="mb-1">Send Invoice</h6>
                                <small class="text-muted">Email to customer</small>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-print me-3 text-success"></i>
                            <div>
                                <h6 class="mb-1">Print Packing Slip</h6>
                                <small class="text-muted">For shipping</small>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-history me-3 text-warning"></i>
                            <div>
                                <h6 class="mb-1">Order History</h6>
                                <small class="text-muted">View all orders</small>
                            </div>
                        </a>
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
    // Update order status
    const statusSelect = document.querySelector('select');
    const updateBtn = document.querySelector('.admin-btn-primary');
    
    updateBtn.addEventListener('click', function() {
        const newStatus = statusSelect.value;
        // Here you would typically make an AJAX call to update the order status
        alert(`Order status updated to: ${newStatus}`);
    });
    
    // Add note functionality
    const noteTextarea = document.querySelector('textarea');
    const addNoteBtn = document.querySelector('.admin-btn-primary:last-of-type');
    
    addNoteBtn.addEventListener('click', function() {
        const note = noteTextarea.value.trim();
        if (note) {
            // Here you would typically make an AJAX call to add the note
            alert('Note added successfully!');
            noteTextarea.value = '';
        } else {
            alert('Please enter a note before adding.');
        }
    });
});
</script>
@endpush
