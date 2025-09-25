@extends('layouts.unified')

@push('styles')
<style>
.pagination {
    --bs-pagination-padding-x: 0.75rem;
    --bs-pagination-padding-y: 0.375rem;
    --bs-pagination-font-size: 0.875rem;
    --bs-pagination-color: #6c757d;
    --bs-pagination-bg: #fff;
    --bs-pagination-border-width: 1px;
    --bs-pagination-border-color: #dee2e6;
    --bs-pagination-border-radius: 0.375rem;
    --bs-pagination-hover-color: #0d6efd;
    --bs-pagination-hover-bg: #e9ecef;
    --bs-pagination-hover-border-color: #dee2e6;
    --bs-pagination-focus-color: #0d6efd;
    --bs-pagination-focus-bg: #e9ecef;
    --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    --bs-pagination-active-color: #fff;
    --bs-pagination-active-bg: #0d6efd;
    --bs-pagination-active-border-color: #0d6efd;
    --bs-pagination-disabled-color: #6c757d;
    --bs-pagination-disabled-bg: #fff;
    --bs-pagination-disabled-border-color: #dee2e6;
}

.pagination .page-link {
    position: relative;
    display: block;
    padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x);
    font-size: var(--bs-pagination-font-size);
    color: var(--bs-pagination-color);
    text-decoration: none;
    background-color: var(--bs-pagination-bg);
    border: var(--bs-pagination-border-width) solid var(--bs-pagination-border-color);
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.pagination .page-link:hover {
    z-index: 2;
    color: var(--bs-pagination-hover-color);
    background-color: var(--bs-pagination-hover-bg);
    border-color: var(--bs-pagination-hover-border-color);
}

.pagination .page-link:focus {
    z-index: 3;
    color: var(--bs-pagination-focus-color);
    background-color: var(--bs-pagination-focus-bg);
    outline: 0;
    box-shadow: var(--bs-pagination-focus-box-shadow);
}

.pagination .page-item:not(:first-child) .page-link {
    margin-left: -1px;
}

.pagination .page-item:first-child .page-link {
    border-top-left-radius: var(--bs-pagination-border-radius);
    border-bottom-left-radius: var(--bs-pagination-border-radius);
}

.pagination .page-item:last-child .page-link {
    border-top-right-radius: var(--bs-pagination-border-radius);
    border-bottom-right-radius: var(--bs-pagination-border-radius);
}

.pagination .page-item.active .page-link {
    z-index: 3;
    color: var(--bs-pagination-active-color);
    background-color: var(--bs-pagination-active-bg);
    border-color: var(--bs-pagination-active-border-color);
}

.pagination .page-item.disabled .page-link {
    color: var(--bs-pagination-disabled-color);
    pointer-events: none;
    background-color: var(--bs-pagination-disabled-bg);
    border-color: var(--bs-pagination-disabled-border-color);
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-active {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-pending {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}


</style>
@endpush

@section('page-title', 'My Orders')
@section('page-subtitle', 'View and track your orders')

@section('content')
<!-- Header -->
<div class="mb-4">
    <h4 class="mb-0">My Orders</h4>
    <p class="text-muted mb-0">View and track your orders</p>
</div>

<!-- Order Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="dashboard-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $totalOrders }}</h3>
                    <p>Total Orders</p>
                </div>
                <div>
                    <i class="fas fa-shopping-cart fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $pendingOrders }}</h3>
                    <p>Pending</p>
                </div>
                <div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $processingOrders }}</h3>
                    <p>Processing</p>
                </div>
                <div>
                    <i class="fas fa-cog fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $deliveredOrders }}</h3>
                    <p>Delivered</p>
                </div>
                <div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="user-card mb-4">
    <div class="row align-items-end">
        <div class="col-md-4">
            <div class="form-group">
                <label for="order_search" class="form-label">Search Orders</label>
                <input type="text" class="form-control" id="order_search" placeholder="Search by order number or product name..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="order_status" class="form-label">Status</label>
                <select class="form-select" id="order_status">
                    <option value="">All Orders</option>
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
                <input type="date" class="form-control" id="date_from" value="{{ request('date_from') }}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="date_to" class="form-label">To Date</label>
                <input type="date" class="form-control" id="date_to" value="{{ request('date_to') }}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary flex-fill" id="filter_btn">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <button class="btn btn-outline-secondary" id="clear_btn" title="Clear filters">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="user-card">
    <div class="table-responsive">
        <table class="table user-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Products</th>
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
                            @if($order->items->count() > 1)
                                <strong>{{ $order->items->first()->product_name }}</strong>
                                <br>
                                <small class="text-muted">+{{ $order->items->count() - 1 }} more items</small>
                            @else
                                <strong>{{ $order->items->first()->product_name ?? 'N/A' }}</strong>
                                <br>
                                <small class="text-muted">Qty: {{ $order->items->first()->quantity ?? 0 }}</small>
                            @endif
                        </div>
                    </td>
                    <td>
                        <strong>KSh {{ number_format($order->total_amount, 0) }}</strong>
                        <br>
                        @if($order->shipping_amount > 0)
                            <small class="text-muted">+ KSh {{ number_format($order->shipping_amount, 0) }} shipping</small>
                        @else
                            <small class="text-muted">Free shipping</small>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge status-{{ $order->status == 'delivered' ? 'active' : ($order->status == 'pending' ? 'pending' : 'active') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                        @if($order->shipped_at)
                            <br>
                            <small class="text-muted">{{ $order->shipped_at->format('Y-m-d') }}</small>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge status-{{ $order->payment_status == 'paid' ? 'active' : 'pending' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                        <br>
                        <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</small>
                    </td>
                    <td>
                        <div>
                            <strong>{{ $order->created_at->format('Y-m-d') }}</strong>
                            <br>
                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="View Order Details">
                                <i class="fas fa-eye"></i> View
                            </a>
                            @if($order->payment_status == 'paid')
                                <button class="btn btn-sm btn-outline-success" onclick="printReceipt({{ $order->id }})" title="Print Receipt">
                                    <i class="fas fa-print"></i>
                                </button>
                                <a href="{{ route('user.orders.download-pdf', $order->id) }}" class="btn btn-sm btn-outline-info" title="Download PDF Receipt">
                                    <i class="fas fa-download"></i>
                                </a>
                            @endif
                            @if($order->status == 'pending' && $order->payment_status == 'pending')
                                <button class="btn btn-sm btn-outline-danger" onclick="cancelOrder({{ $order->id }})" title="Cancel Order">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                            <h5>No orders found</h5>
                            <p>You haven't placed any orders yet.</p>
                            <a href="{{ route('home') }}" class="btn btn-primary">Start Shopping</a>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <p class="text-muted mb-0">
                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
            </p>
        </div>
        <nav aria-label="Orders pagination">
            <ul class="pagination mb-0">
                {{-- Previous Page Link --}}
                @if ($orders->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $orders->previousPageUrl() }}">Previous</a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                    @if ($page == $orders->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($orders->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $orders->nextPageUrl() }}">Next</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function printReceipt(orderId) {
    // Open order details in new window for printing with print parameter
    const printWindow = window.open('/user/orders/' + orderId + '?print=1', '_blank', 'width=800,height=600');

    // Wait for the window to load then print
    printWindow.onload = function() {
        setTimeout(function() {
            printWindow.print();
        }, 500);
    };
}

function cancelOrder(orderId) {
    if (confirm('Are you sure you want to cancel this order?')) {
        // Here you would typically make an AJAX call to cancel the order
        fetch('/user/orders/' + orderId + '/cancel', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to cancel order. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
}

// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('order_search');
    const statusSelect = document.getElementById('order_status');
    const dateFromInput = document.getElementById('date_from');
    const dateToInput = document.getElementById('date_to');
    const filterBtn = document.getElementById('filter_btn');
    const clearBtn = document.getElementById('clear_btn');

    // Filter button click
    filterBtn.addEventListener('click', function() {
        const params = new URLSearchParams();

        if (searchInput.value.trim()) params.append('search', searchInput.value.trim());
        if (statusSelect.value) params.append('status', statusSelect.value);
        if (dateFromInput.value) params.append('date_from', dateFromInput.value);
        if (dateToInput.value) params.append('date_to', dateToInput.value);

        const url = '{{ route("user.orders") }}' + (params.toString() ? '?' + params.toString() : '');
        window.location.href = url;
    });

    // Clear filters
    clearBtn.addEventListener('click', function() {
        window.location.href = '{{ route("user.orders") }}';
    });

    // Enter key on search
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            filterBtn.click();
        }
    });

    // Auto-filter on status change
    statusSelect.addEventListener('change', function() {
        if (this.value || searchInput.value.trim() || dateFromInput.value || dateToInput.value) {
            filterBtn.click();
        }
    });
});
</script>
@endpush
