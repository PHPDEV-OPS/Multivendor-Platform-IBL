@extends('admin.layouts.app')

@section('page-title', 'Customers')
@section('page-subtitle', 'Manage your customer relationships')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Customers</h4>
        <p class="text-muted mb-0">Manage your customer relationships and insights</p>
    </div>
    <div class="d-flex gap-2">
        <button class="admin-btn">
            <i class="fas fa-download"></i> Export
        </button>
        <button class="admin-btn">
            <i class="fas fa-envelope"></i> Send Email
        </button>
    </div>
</div>

<!-- Customer Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>Total Customers</p>
                    <small class="text-success">All time</small>
                </div>
                <div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['active']) }}</h3>
                    <p>Active Customers</p>
                    <small class="text-success">{{ $stats['total'] > 0 ? round(($stats['active'] / $stats['total']) * 100) : 0 }}% of total</small>
                </div>
                <div>
                    <i class="fas fa-user-check fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['inactive']) }}</h3>
                    <p>Inactive Customers</p>
                    <small class="text-warning">{{ $stats['total'] > 0 ? round(($stats['inactive'] / $stats['total']) * 100) : 0 }}% of total</small>
                </div>
                <div>
                    <i class="fas fa-user-times fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $customers->count() }}</h3>
                    <p>Showing</p>
                    <small class="text-info">Page {{ $customers->currentPage() }} of {{ $customers->lastPage() }}</small>
                </div>
                <div>
                    <i class="fas fa-list fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="admin-card mb-4">
    <form method="GET" action="{{ route('admin.customers') }}">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="customer_search" class="form-label">Search Customers</label>
                    <input type="text" class="form-control" id="customer_search" name="search" 
                           placeholder="Name, email, phone..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="customer_status" class="form-label">Status</label>
                    <select class="form-select" id="customer_status" name="status">
                        <option value="">All Customers</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <a href="{{ route('admin.customers') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Customers Table -->
<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th>Orders</th>
                    <th>Total Spent</th>
                    <th>Last Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <span class="text-white fw-bold">{{ strtoupper(substr($customer->name, 0, 2)) }}</span>
                            </div>
                            <div>
                                <h6 class="mb-1">{{ $customer->name }}</h6>
                                <small class="text-muted">Customer since {{ $customer->created_at->format('M Y') }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <div>{{ $customer->email }}</div>
                            <small class="text-muted">{{ $customer->phone ?? 'No phone' }}</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>{{ $customer->orders_count }} orders</strong>
                            <br>
                            <small class="text-muted">Last 30 days: {{ $customer->recent_orders_count }}</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>KSh {{ number_format($customer->total_spent) }}</strong>
                            <br>
                            <small class="text-muted">Avg: KSh {{ $customer->orders_count > 0 ? number_format($customer->total_spent / $customer->orders_count) : 0 }}</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>{{ $customer->last_order_date ? $customer->last_order_date->format('Y-m-d') : 'No orders' }}</strong>
                            <br>
                            <small class="text-muted">{{ $customer->last_order_date ? $customer->last_order_date->diffForHumans() : 'Never' }}</small>
                        </div>
                    </td>
                    <td>
                        @if($customer->is_active)
                            <span class="status-badge status-active">Active</span>
                        @else
                            <span class="status-badge status-inactive">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.customers.show', $customer) }}"><i class="fas fa-eye"></i> View Profile</a></li>
                                <li><a class="dropdown-item" href="mailto:{{ $customer->email }}"><i class="fas fa-envelope"></i> Send Email</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-shopping-cart"></i> View Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-star"></i> Mark as VIP</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h5>No customers found</h5>
                            <p>There are no customers matching your criteria.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($customers->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $customers->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
