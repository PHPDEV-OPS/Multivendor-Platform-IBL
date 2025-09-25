@extends('admin.layouts.app')

@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Welcome back! Here\'s what\'s happening with your platform today.')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>KSh {{ number_format($stats['total_revenue'], 0) }}</h3>
                    <p>Total Revenue</p>
                </div>
                <div>
                    <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['total_orders']) }}</h3>
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
                    <h3>{{ number_format($stats['active_users']) }}</h3>
                    <p>Active Users</p>
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
                    <h3>{{ number_format($stats['vendors']) }}</h3>
                    <p>Vendors</p>
                </div>
                <div>
                    <i class="fas fa-store fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="admin-card">
            <h5 class="mb-3">Quick Actions</h5>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <a href="{{ route('admin.orders.index') }}" class="admin-btn w-100 text-center">
                        <i class="fas fa-eye"></i> Manage Orders
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('admin.customers') }}" class="admin-btn w-100 text-center">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('admin.analytics') }}" class="admin-btn w-100 text-center">
                        <i class="fas fa-chart-bar"></i> View Analytics
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('admin.reports') }}" class="admin-btn w-100 text-center">
                        <i class="fas fa-file-alt"></i> Generate Reports
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('admin.content.index') }}" class="admin-btn w-100 text-center">
                        <i class="fas fa-file-alt"></i> Manage Content
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Analytics -->
<div class="row">
    <!-- Recent Orders -->
    <div class="col-md-8">
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Recent Orders</h5>
                <a href="{{ route('admin.orders.index') }}" class="admin-btn">View All</a>
            </div>
            
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Vendor</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->vendor->name }}</td>
                            <td>KSh {{ number_format($order->total_amount, 0) }}</td>
                            <td><span class="status-badge {{ $order->status_badge_class }}">{{ ucfirst($order->status) }}</span></td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No orders found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Analytics Summary -->
    <div class="col-md-4">
        <div class="admin-card">
            <h5 class="mb-3">This Month</h5>
            
            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Revenue</span>
                    <span class="fw-bold">KSh {{ number_format($monthlyStats['revenue'], 0) }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: 75%; background: var(--base_color);"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Orders</span>
                    <span class="fw-bold">{{ number_format($monthlyStats['orders']) }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: 60%; background: var(--success_color);"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>New Users</span>
                    <span class="fw-bold">{{ number_format($monthlyStats['new_users']) }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: 85%; background: var(--warning_color);"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Active Vendors</span>
                    <span class="fw-bold">{{ number_format($monthlyStats['active_vendors']) }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: 98%; background: var(--danger_color);"></div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="admin-card">
            <h5 class="mb-3">Top Products</h5>
            <div class="list-group list-group-flush">
                @forelse($topProducts as $product)
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div>
                        <h6 class="mb-1">{{ $product->name }}</h6>
                        <small class="text-muted">{{ $product->sold_count }} sales this month</small>
                    </div>
                    <span class="badge bg-primary rounded-pill">KSh {{ number_format($product->price, 0) }}</span>
                </div>
                @empty
                <div class="list-group-item border-0 px-0">
                    <p class="text-muted text-center">No products found</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="admin-card">
            <h5 class="mb-3">Recent Activity</h5>
            <div class="timeline">
                @forelse($recentOrders->take(4) as $order)
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">New order received</h6>
                        <p class="text-muted mb-0">Order {{ $order->order_number }} placed by {{ $order->user->name }} for KSh {{ number_format($order->total_amount, 0) }}</p>
                        <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @empty
                <div class="text-center">
                    <p class="text-muted">No recent activity</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
