@extends('layouts.unified')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back! Here\'s what\'s happening with your account today.')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="dashboard-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>KSh {{ number_format($totalSpent, 0) }}</h3>
                    <p>Total Spent</p>
                </div>
                <div>
                    <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
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
                    <h3>{{ $wishlistItems }}</h3>
                    <p>Wishlist Items</p>
                </div>
                <div>
                    <i class="fas fa-heart fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="dashboard-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($averageRating, 1) }}</h3>
                    <p>Average Rating</p>
                </div>
                <div>
                    <i class="fas fa-star fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="dashboard-card">
            <h5 class="mb-3">Quick Actions</h5>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <a href="{{ route('user.orders') }}" class="dashboard-btn w-100 text-center">
                        <i class="fas fa-eye"></i> View Orders
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('user.profile') }}" class="dashboard-btn w-100 text-center">
                        <i class="fas fa-user"></i> Update Profile
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('user.analytics') }}" class="dashboard-btn w-100 text-center">
                        <i class="fas fa-chart-bar"></i> View Analytics
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('user.support') }}" class="dashboard-btn w-100 text-center">
                        <i class="fas fa-headset"></i> Get Support
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
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Recent Orders</h5>
                <a href="{{ route('user.orders') }}" class="dashboard-btn">View All</a>
            </div>

            <div class="table-responsive">
                <table class="table dashboard-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>
                                @if($order->items->count() > 1)
                                    {{ $order->items->first()->product_name }}
                                    <small class="text-muted">(+{{ $order->items->count() - 1 }} more)</small>
                                @else
                                    {{ $order->items->first()->product_name ?? 'N/A' }}
                                @endif
                            </td>
                            <td>KSh {{ number_format($order->total_amount, 0) }}</td>
                            <td>
                                <span class="status-badge status-{{ $order->status == 'delivered' ? 'active' : ($order->status == 'pending' ? 'pending' : 'active') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No orders found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Analytics Summary -->
    <div class="col-md-4">
        <div class="dashboard-card">
            <h5 class="mb-3">This Month</h5>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Spent</span>
                    <span class="fw-bold">KSh {{ number_format($thisMonthSpent, 0) }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ min(($thisMonthSpent / max($totalSpent, 1)) * 100, 100) }}%; background: var(--base_color);"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Orders</span>
                    <span class="fw-bold">{{ $thisMonthOrders }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ min(($thisMonthOrders / max($totalOrders, 1)) * 100, 100) }}%; background: var(--success_color);"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Items Purchased</span>
                    <span class="fw-bold">{{ $thisMonthItems }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ min($thisMonthItems * 5, 100) }}%; background: var(--warning_color);"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Average Rating</span>
                    <span class="fw-bold">{{ number_format($averageRating, 1) }}/5</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ ($averageRating / 5) * 100 }}%; background: var(--danger_color);"></div>
                </div>
            </div>
        </div>

        <!-- Most Purchased Products -->
        <div class="dashboard-card">
            <h5 class="mb-3">Most Purchased Products</h5>
            <div class="list-group list-group-flush">
                @forelse($favoriteProducts as $product)
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div>
                        <h6 class="mb-1">{{ $product->product_name }}</h6>
                        <small class="text-muted">Purchased {{ $product->total_quantity }} time{{ $product->total_quantity > 1 ? 's' : '' }}</small>
                    </div>
                    <span class="badge bg-primary rounded-pill">KSh {{ number_format($product->avg_price, 0) }}</span>
                </div>
                @empty
                <div class="list-group-item border-0 px-0">
                    <p class="text-muted mb-0">No purchases yet</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <h5 class="mb-3">Recent Activity</h5>
            <div class="timeline">
                @forelse($recentActivity as $activity)
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <div class="bg-{{ $activity['color'] }} rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="{{ $activity['icon'] }} text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1">{{ $activity['title'] }}</h6>
                        <p class="text-muted mb-0">{{ $activity['description'] }}</p>
                        <small class="text-muted">{{ $activity['created_at']->diffForHumans() }}</small>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-clock fa-2x mb-3"></i>
                    <p>No recent activity</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
