@extends('vendor.layouts.app')

@section('page-title', 'Orders')
@section('page-subtitle', 'Manage your paid orders')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Paid Orders</h4>
        <p class="text-muted mb-0">Manage your paid orders ({{ number_format($stats['total']) }} total)</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('vendor.orders.export', request()->query()) }}" class="vendor-btn">
            <i class="fas fa-download"></i> Export
        </a>
        <button class="vendor-btn" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
</div>

<!-- Order Statistics -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>Total Paid Orders</p>
                </div>
                <div>
                    <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="vendor-stats-card">
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
    <div class="col-md-2">
        <div class="vendor-stats-card">
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
    <div class="col-md-2">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['shipped']) }}</h3>
                    <p>Shipped</p>
                </div>
                <div>
                    <i class="fas fa-truck fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="vendor-stats-card">
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
    <div class="col-md-2">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>KES {{ number_format($stats['total_revenue'], 0) }}</h3>
                    <p>Total Revenue</p>
                </div>
                <div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="vendor-card mb-4">
    <div class="card-header bg-light border-bottom">
        <h6 class="mb-0 text-muted">
            <i class="fas fa-filter me-2"></i>Search & Filter Orders
        </h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('vendor.orders') }}">
            <div class="row g-3">
                <!-- Search Input -->
                <div class="col-lg-4 col-md-6">
                    <label for="search" class="form-label fw-semibold">
                        <i class="fas fa-search me-1"></i>Search Orders
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="search" name="search"
                               value="{{ request('search') }}" placeholder="Order ID, customer, product...">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label for="status" class="form-label fw-semibold">
                        <i class="fas fa-flag me-1"></i>Status
                    </label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- From Date -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label for="date_from" class="form-label fw-semibold">
                        <i class="fas fa-calendar-alt me-1"></i>From Date
                    </label>
                    <input type="date" class="form-control" id="date_from" name="date_from"
                           value="{{ request('date_from') }}">
                </div>

                <!-- To Date -->
                <div class="col-lg-2 col-md-3 col-sm-6">
                    <label for="date_to" class="form-label fw-semibold">
                        <i class="fas fa-calendar-check me-1"></i>To Date
                    </label>
                    <input type="date" class="form-control" id="date_to" name="date_to"
                           value="{{ request('date_to') }}">
                </div>

                <!-- Per Page -->
                <div class="col-lg-1 col-md-2 col-sm-6">
                    <label for="per_page" class="form-label fw-semibold">
                        <i class="fas fa-list me-1"></i>Show
                    </label>
                    <select class="form-select" id="per_page" name="per_page">
                        <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('per_page', '15') == '15' ? 'selected' : '' }}>15</option>
                        <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-lg-1 col-md-1 col-sm-12">
                    <label class="form-label fw-semibold d-block">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="vendor-btn vendor-btn-primary flex-fill" title="Apply Filters">
                            <i class="fas fa-search"></i>
                            <span class="d-none d-lg-inline ms-1">Filter</span>
                        </button>
                        <a href="{{ route('vendor.orders') }}" class="btn btn-outline-secondary" title="Clear Filters">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Active Filters Display -->
            @if(request()->filled('search') || request()->filled('status') || request()->filled('date_from') || request()->filled('date_to'))
            <div class="row mt-3">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <small class="text-muted fw-semibold">Active Filters:</small>

                        @if(request()->filled('search'))
                        <span class="badge bg-primary">
                            <i class="fas fa-search me-1"></i>Search: "{{ request('search') }}"
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-white ms-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif

                        @if(request()->filled('status'))
                        <span class="badge bg-info">
                            <i class="fas fa-flag me-1"></i>Status: {{ ucfirst(request('status')) }}
                            <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="text-white ms-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif

                        @if(request()->filled('date_from'))
                        <span class="badge bg-success">
                            <i class="fas fa-calendar-alt me-1"></i>From: {{ request('date_from') }}
                            <a href="{{ request()->fullUrlWithQuery(['date_from' => null]) }}" class="text-white ms-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif

                        @if(request()->filled('date_to'))
                        <span class="badge bg-warning">
                            <i class="fas fa-calendar-check me-1"></i>To: {{ request('date_to') }}
                            <a href="{{ request()->fullUrlWithQuery(['date_to' => null]) }}" class="text-white ms-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif

                        <a href="{{ route('vendor.orders') }}" class="btn btn-sm btn-outline-secondary ms-2">
                            <i class="fas fa-times me-1"></i>Clear All
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="vendor-card">
    <div class="table-responsive">
        <table class="table vendor-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Products</th>
                    <th>Vendor Amount</th>
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
                        <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                    </td>
                    <td>
                        <div>
                            <strong>{{ $order->user->name ?? 'N/A' }}</strong>
                            <br>
                            <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                            <br>
                            <small class="text-muted">{{ $order->billing_address['phone'] ?? 'N/A' }}</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            @foreach($order->items->take(2) as $item)
                            <div class="d-flex align-items-center mb-1">
                                @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="Product"
                                     class="rounded me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                @else
                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                     style="width: 30px; height: 30px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                                <div>
                                    <small><strong>{{ $item->product_name }}</strong></small>
                                    <br>
                                    <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                </div>
                            </div>
                            @endforeach
                            @if($order->items->count() > 2)
                            <small class="text-muted">+{{ $order->items->count() - 2 }} more items</small>
                            @endif
                        </div>
                    </td>
                    <td>
                        <strong>KES {{ number_format($order->vendor_amount, 0) }}</strong>
                        <br>
                        <small class="text-muted">Total: KES {{ number_format($order->total_amount, 0) }}</small>
                    </td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        <br>
                        @if($order->tracking_number)
                        <small class="text-muted">Track: {{ $order->tracking_number }}</small>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge status-paid">{{ ucfirst($order->payment_status) }}</span>
                        <br>
                        <small class="text-muted">{{ $order->payment_method ?? 'N/A' }}</small>
                    </td>
                    <td>
                        <strong>{{ $order->created_at->format('M d, Y') }}</strong>
                        <br>
                        <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('vendor.orders.show', $order) }}" class="btn btn-sm btn-outline-primary" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(in_array($order->status, ['pending', 'processing']))
                            <button class="btn btn-sm btn-outline-success"
                                    onclick="updateOrderStatus({{ $order->id }}, 'processing')"
                                    title="Mark as Processing">
                                <i class="fas fa-play"></i>
                            </button>
                            @endif
                            @if(in_array($order->status, ['processing']))
                            <button class="btn btn-sm btn-outline-info"
                                    onclick="updateOrderStatus({{ $order->id }}, 'shipped')"
                                    title="Mark as Shipped">
                                <i class="fas fa-truck"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                            <h5>No Paid Orders Found</h5>
                            <p>You don't have any paid orders yet. Orders will appear here once customers complete their payments.</p>
                        </div>
                    </td>
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
                    of <strong>{{ number_format($orders->total()) }}</strong> paid orders
                    @if(request()->filled('search') || request()->filled('status') || request()->filled('date_from') || request()->filled('date_to'))
                        <span class="text-primary">(filtered)</span>
                    @endif
                @else
                    No paid orders found
                @endif
            </p>
        </div>
        @if($orders->hasPages())
        <div>
            {{ $orders->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
    @endif
</div>

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
});

function updateOrderStatus(orderId, status) {
    if (confirm('Are you sure you want to update this order status?')) {
        const baseUrl = document.querySelector('meta[name="base-url"]')?.getAttribute('content') || '{{ url("/") }}';
        const updateUrl = `${baseUrl}/vendor/orders/${orderId}/status`;

        fetch(updateUrl, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating order status: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the order status.');
        });
    }
}
</script>
@endpush

@endsection
