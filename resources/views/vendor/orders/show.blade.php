@extends('vendor.layouts.app')

@section('page-title', 'Order Details')
@section('page-subtitle', 'Order #{{ $order->order_number }}')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Order Information -->
        <div class="col-md-8">
            <div class="vendor-card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Order #{{ $order->order_number }}</h5>
                    <div>
                        <button class="vendor-btn vendor-btn-outline me-2">
                            <i class="fas fa-print"></i> Print Invoice
                        </button>
                        <button class="vendor-btn vendor-btn-primary">
                            <i class="fas fa-envelope"></i> Send Email
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Order Status -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <span class="status-badge status-{{ $order->status }} me-3">{{ ucfirst($order->status) }}</span>
                                <span class="text-muted">Order placed on {{ $order->created_at->format('M d, Y \a\t g:i A') }}</span>
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
                                <h6 class="text-primary mb-2">Vendor Amount</h6>
                                <h4 class="mb-0">KSh {{ number_format($order->vendor_amount, 2) }}</h4>
                                <small class="text-muted">Your earnings from this order</small>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <h6 class="text-primary mb-3">Order Items</h6>
                    <div class="table-responsive">
                        <table class="vendor-table">
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
                                @forelse($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product_name }}" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <img src="https://via.placeholder.com/50x50?text=Product" alt="Product" class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ $item->product_name }}</h6>
                                                @if($item->product_variant)
                                                    <small class="text-muted">{{ $item->product_variant }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->product->sku ?? 'N/A' }}</td>
                                    <td>KSh {{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>KSh {{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No items found</td>
                                </tr>
                                @endforelse
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
                                        <span>KSh {{ number_format($order->subtotal_amount ?? $order->total_amount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Shipping:</span>
                                        <span>KSh {{ number_format($order->shipping_amount ?? 0, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Commission:</span>
                                        <span>KSh {{ number_format($order->commission_amount ?? 0, 2) }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Your Amount:</span>
                                        <span>KSh {{ number_format($order->vendor_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="vendor-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Customer Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Customer Details</h6>
                            <p class="mb-1"><strong>{{ $order->user->name ?? 'N/A' }}</strong></p>
                            <p class="mb-1">Email: {{ $order->user->email ?? 'N/A' }}</p>
                            <p class="mb-0">Phone: {{ $order->billing_address['phone'] ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Billing Address</h6>
                            <p class="mb-1"><strong>{{ $order->billing_address['name'] ?? $order->user->name ?? 'N/A' }}</strong></p>
                            @if(isset($order->billing_address['address']))
                                <p class="mb-1">{{ $order->billing_address['address'] }}</p>
                            @endif
                            @if(isset($order->billing_address['city']))
                                <p class="mb-1">{{ $order->billing_address['city'] }}</p>
                            @endif
                            @if(isset($order->billing_address['country']))
                                <p class="mb-1">{{ $order->billing_address['country'] }}</p>
                            @endif
                            <p class="mb-0">Phone: (555) 123-4567</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            <div class="vendor-card">
                <div class="card-header">
                    <h6 class="mb-0">Order Notes</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <textarea class="form-control" rows="3" placeholder="Add a note about this order..."></textarea>
                    </div>
                    <button class="vendor-btn vendor-btn-primary">Add Note</button>

                    @if($order->notes)
                    <div class="mt-4">
                        <h6 class="text-primary mb-3">Order Notes</h6>
                        <div class="border-start border-primary ps-3">
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">{{ $order->updated_at->format('M d, Y - g:i A') }}</small>
                                <small class="text-muted">Vendor</small>
                            </div>
                            <p class="mb-0">{{ $order->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Order Actions -->
            <div class="vendor-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Order Actions</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('vendor.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group mb-3">
                            <label class="form-label">Update Status</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Tracking Number (Optional)</label>
                            <input type="text" name="tracking_number" class="form-control" value="{{ $order->tracking_number }}" placeholder="Enter tracking number">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Notes (Optional)</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Add notes about this status update">{{ $order->notes }}</textarea>
                        </div>
                        <button type="submit" class="vendor-btn vendor-btn-primary w-100 mb-2">Update Status</button>
                    </form>

                    <hr>

                    <div class="d-grid gap-2">
                        <button class="vendor-btn vendor-btn-outline">
                            <i class="fas fa-truck me-2"></i>Mark as Shipped
                        </button>
                        <button class="vendor-btn vendor-btn-outline">
                            <i class="fas fa-check me-2"></i>Mark as Delivered
                        </button>
                        <button class="vendor-btn vendor-btn-outline">
                            <i class="fas fa-times me-2"></i>Cancel Order
                        </button>
                        <button class="vendor-btn vendor-btn-outline">
                            <i class="fas fa-undo me-2"></i>Refund Order
                        </button>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="vendor-card mb-4">
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
            <div class="vendor-card mb-4">
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
                    <button class="vendor-btn vendor-btn-outline w-100">Update Tracking</button>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="vendor-card">
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
    const updateBtn = document.querySelector('.vendor-btn-primary');

    updateBtn.addEventListener('click', function() {
        const newStatus = statusSelect.value;
        // Here you would typically make an AJAX call to update the order status
        alert(`Order status updated to: ${newStatus}`);
    });

    // Add note functionality
    const noteTextarea = document.querySelector('textarea');
    const addNoteBtn = document.querySelector('.vendor-btn-primary:last-of-type');

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
