@extends('vendor.layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back! Here\'s what\'s happening with your store today.')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>KES {{ number_format($stats['total_revenue'], 0) }}</h3>
                    <p>Total Revenue</p>
                    <small class="text-muted">From {{ number_format($stats['total_orders']) }} paid orders</small>
                </div>
                <div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-75 text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['total_orders']) }}</h3>
                    <p>Paid Orders</p>
                    <small class="text-muted">{{ number_format($stats['total_items_sold']) }} items sold</small>
                </div>
                <div>
                    <i class="fas fa-shopping-cart fa-2x opacity-75 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['active_products']) }}/{{ number_format($stats['total_products']) }}</h3>
                    <p>Active Products</p>
                    <small class="text-muted">{{ number_format($stats['total_products'] - $stats['active_products']) }} inactive</small>
                </div>
                <div>
                    <i class="fas fa-box fa-2x opacity-75 text-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $stats['average_rating'] > 0 ? number_format($stats['average_rating'], 1) : 'N/A' }}</h3>
                    <p>Average Rating</p>
                    <small class="text-muted">
                        @if($stats['average_rating'] > 0)
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $stats['average_rating'])
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-muted"></i>
                                @endif
                            @endfor
                        @else
                            No ratings yet
                        @endif
                    </small>
                </div>
                <div>
                    <i class="fas fa-star fa-2x opacity-75 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Status Cards -->
<div class="row mb-4">
    <div class="col-lg-6 col-md-6 mb-3">
        <div class="vendor-stats-card border-start border-warning border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4>{{ number_format($stats['pending_orders']) }}</h4>
                    <p class="mb-0">Pending Orders</p>
                    <small class="text-muted">Awaiting processing</small>
                </div>
                <div>
                    <i class="fas fa-clock fa-2x opacity-75 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 mb-3">
        <div class="vendor-stats-card border-start border-info border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4>{{ number_format($stats['processing_orders']) }}</h4>
                    <p class="mb-0">Processing Orders</p>
                    <small class="text-muted">Being prepared</small>
                </div>
                <div>
                    <i class="fas fa-cog fa-2x opacity-75 text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="vendor-card">
            <h5 class="mb-3">Quick Actions</h5>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <a href="{{ route('vendor.products.create') }}" class="vendor-btn w-100 text-center">
                        <i class="fas fa-plus"></i> Add New Product
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('vendor.promotions') }}" class="vendor-btn w-100 text-center">
                        <i class="fas fa-gift"></i> Create Promotion
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('vendor.orders') }}" class="vendor-btn w-100 text-center">
                        <i class="fas fa-eye"></i> View Orders
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="{{ route('vendor.analytics') }}" class="vendor-btn w-100 text-center">
                        <i class="fas fa-chart-bar"></i> View Analytics
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
        <div class="vendor-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Recent Orders</h5>
                <a href="{{ route('vendor.orders') }}" class="vendor-btn">View All</a>
            </div>

            <div class="table-responsive">
                <table class="table vendor-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order['order_number'] }}</td>
                                <td>{{ $order['customer_name'] }}</td>
                                <td>{{ $order['product_name'] }}</td>
                                <td>KSh {{ number_format($order['amount'], 0) }}</td>
                                <td><span class="status-badge {{ $order['status_badge_class'] }}">{{ ucfirst($order['status']) }}</span></td>
                                <td>{{ $order['date'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Analytics Summary -->
    <div class="col-md-4">
        <div class="vendor-card">
            <h5 class="mb-3">This Month</h5>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Revenue</span>
                    <span class="fw-bold">KSh {{ number_format($monthlyStats['revenue'], 0) }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ $monthlyStats['revenue'] > 0 ? min(100, ($monthlyStats['revenue'] / max($stats['total_revenue'], 1)) * 100) : 0 }}%; background: var(--base_color);"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Orders</span>
                    <span class="fw-bold">{{ $monthlyStats['orders'] }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ $monthlyStats['orders'] > 0 ? min(100, ($monthlyStats['orders'] / max($stats['total_orders'], 1)) * 100) : 0 }}%; background: var(--success_color);"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Products Sold</span>
                    <span class="fw-bold">{{ $monthlyStats['products_sold'] }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ $monthlyStats['products_sold'] > 0 ? min(100, ($monthlyStats['products_sold'] / max($stats['total_products'], 1)) * 100) : 0 }}%; background: var(--warning_color);"></div>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span>Customer Rating</span>
                    <span class="fw-bold">{{ $monthlyStats['rating'] }}/5</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ $monthlyStats['rating'] > 0 ? ($monthlyStats['rating'] / 5) * 100 : 0 }}%; background: var(--danger_color);"></div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="vendor-card">
            <h5 class="mb-3">Top Products</h5>
            <div class="list-group list-group-flush">
                @forelse($topProducts as $product)
                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        <div>
                            <h6 class="mb-1">{{ $product['name'] }}</h6>
                            <small class="text-muted">{{ $product['sales'] }} sales</small>
                        </div>
                        <span class="badge bg-primary rounded-pill">KSh {{ number_format($product['price'], 0) }}</span>
                    </div>
                @empty
                    <div class="list-group-item border-0 px-0">
                        <small class="text-muted">No products sold yet</small>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-12">
                <div class="vendor-card">
                    <h5 class="mb-3">Recent Activity</h5>
                    <div class="timeline">
                        @forelse($recentActivity as $activity)
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <div class="{{ $activity['icon_bg'] }} rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="{{ $activity['icon'] }} text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ $activity['title'] }}</h6>
                                    <p class="text-muted mb-0">{{ $activity['description'] }}</p>
                                    <small class="text-muted">{{ $activity['time'] }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted">
                                <p>No recent activity</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
@endsection
