@extends('admin.layouts.app')

@section('page-title', 'Orders')
@section('page-subtitle', 'Manage your store orders')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Orders</h4>
        <p class="text-muted mb-0">Manage your store orders</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.export') }}" class="admin-btn">
            <i class="fas fa-download"></i> Export
        </a>
        <button class="admin-btn">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
</div>

<!-- Order Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>Total Orders</p>
                </div>
                <div>
                    <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['pending']) }}</h3>
                    <p>Pending</p>
                </div>
                <div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['processing']) }}</h3>
                    <p>Processing</p>
                </div>
                <div>
                    <i class="fas fa-cog fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['delivered']) }}</h3>
                    <p>Delivered</p>
                </div>
                <div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="admin-card mb-4">
    <form method="GET" action="{{ route('admin.orders.index') }}">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="order_search" class="form-label">Search Orders</label>
                    <input type="text" class="form-control" id="order_search" name="search"
                           placeholder="Order ID, customer name..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="order_status" class="form-label">Status</label>
                    <select class="form-select" id="order_status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="date_from" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="date_to" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label for="per_page" class="form-label">Per Page</label>
                    <select class="form-select" id="per_page" name="per_page">
                        <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('per_page', '15') == '15' ? 'selected' : '' }}>15</option>
                        <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="admin-btn flex-fill">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Vendor</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>
                        <strong>{{ $order->order_number }}</strong>
                        <br>
                        <small class="text-muted">{{ $order->created_at->format('Y-m-d') }}</small>
                    </td>
                    <td>
                        <div>
                            <strong>{{ $order->user->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $order->user->email }}</small>
                            <br>
                            <small class="text-muted">{{ $order->user->phone }}</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>{{ $order->vendor->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $order->vendor->email }}</small>
                        </div>
                    </td>
                    <td>
                        <strong>KSh {{ number_format($order->total_amount, 0) }}</strong>
                        <br>
                        <small class="text-muted">
                            @if($order->shipping_amount > 0)
                                + KSh {{ number_format($order->shipping_amount, 0) }} shipping
                            @else
                                Free shipping
                            @endif
                        </small>
                    </td>
                    <td>
                        <span class="status-badge {{ $order->status_badge_class }}">{{ ucfirst($order->status) }}</span>
                        <br>
                        <small class="text-muted">
                            @if($order->delivered_at)
                                {{ $order->delivered_at->format('Y-m-d') }}
                            @elseif($order->shipped_at)
                                {{ $order->shipped_at->format('Y-m-d') }}
                            @else
                                {{ $order->created_at->format('Y-m-d') }}
                            @endif
                        </small>
                    </td>
                    <td>
                        <span class="status-badge {{ $order->payment_status_badge_class }}">{{ ucfirst($order->payment_status) }}</span>
                        <br>
                        <small class="text-muted">{{ $order->payment_method ?? 'N/A' }}</small>
                    </td>
                    <td>
                        <div>
                            <strong>{{ $order->created_at->format('Y-m-d') }}</strong>
                            <br>
                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.orders.show', $order) }}"><i class="fas fa-eye"></i> View Details</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateStatusModal" data-order-id="{{ $order->id }}"><i class="fas fa-edit"></i> Update Status</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-print"></i> Print Invoice</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-envelope"></i> Send Email</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No orders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages() || $orders->total() > 0)
    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
        <div>
            <p class="text-muted mb-0 small">
                @if($orders->total() > 0)
                    Showing <strong>{{ $orders->firstItem() }}</strong> to <strong>{{ $orders->lastItem() }}</strong>
                    of <strong>{{ number_format($orders->total()) }}</strong> orders
                    @if(request()->filled('search') || request()->filled('status') || request()->filled('date_from') || request()->filled('date_to'))
                        <span class="text-primary">(filtered)</span>
                    @endif
                @else
                    No orders found
                @endif
            </p>
        </div>
        @if($orders->hasPages())
        <div>
            {{ $orders->appends(request()->query())->links('admin.pagination.custom') }}
        </div>
        @endif
    </div>
    @endif
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="updateStatusForm">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when per_page changes
    const perPageSelect = document.getElementById('per_page');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }

    // Update status modal functionality
    const updateStatusModal = document.getElementById('updateStatusModal');
    if (updateStatusModal) {
        updateStatusModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const orderId = button.getAttribute('data-order-id');
            const form = updateStatusModal.querySelector('form');
            if (form && orderId) {
                form.action = form.action.replace(':id', orderId);
            }
        });
    }
});
</script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle status update modal
    const updateStatusModal = document.getElementById('updateStatusModal');
    const updateStatusForm = document.getElementById('updateStatusForm');

    updateStatusModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const orderId = button.getAttribute('data-order-id');
        const formAction = `/admin/orders/${orderId}/status`;
        updateStatusForm.setAttribute('action', formAction);
    });
});
</script>
@endpush
