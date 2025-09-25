@extends('vendor.layouts.app')

@section('page-title', 'Analytics')
@section('page-subtitle', 'Track your store performance and insights')

@section('content')
<!-- Date Range Filter -->
<div class="vendor-card mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h5 class="mb-0">Analytics Overview</h5>
            <p class="text-muted mb-0">Track your store performance and customer insights</p>
        </div>
        <div class="col-md-6">
            <div class="d-flex gap-2 justify-content-end">
                <form method="GET" action="{{ route('vendor.analytics') }}" class="d-flex gap-2">
                    <select name="period" class="form-select" style="width: auto;" onchange="this.form.submit()">
                        <option value="7" {{ $period == '7' ? 'selected' : '' }}>Last 7 days</option>
                        <option value="30" {{ $period == '30' ? 'selected' : '' }}>Last 30 days</option>
                        <option value="90" {{ $period == '90' ? 'selected' : '' }}>Last 3 months</option>
                        <option value="180" {{ $period == '180' ? 'selected' : '' }}>Last 6 months</option>
                        <option value="365" {{ $period == '365' ? 'selected' : '' }}>Last year</option>
                    </select>
                </form>
                <a href="{{ route('vendor.analytics.export', ['period' => $period]) }}" class="vendor-btn">
                    <i class="fas fa-download"></i> Export
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Key Metrics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>KES {{ number_format($analytics['total_revenue'], 0) }}</h3>
                    <p>Total Revenue</p>
                    @php
                        $revenueChange = $previousAnalytics['total_revenue'] > 0
                            ? (($analytics['total_revenue'] - $previousAnalytics['total_revenue']) / $previousAnalytics['total_revenue']) * 100
                            : 0;
                    @endphp
                    <small class="{{ $revenueChange >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $revenueChange >= 0 ? '+' : '' }}{{ number_format($revenueChange, 1) }}% vs last period
                    </small>
                </div>
                <div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-75 text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($analytics['total_orders']) }}</h3>
                    <p>Total Orders</p>
                    @php
                        $ordersChange = $previousAnalytics['total_orders'] > 0
                            ? (($analytics['total_orders'] - $previousAnalytics['total_orders']) / $previousAnalytics['total_orders']) * 100
                            : 0;
                    @endphp
                    <small class="{{ $ordersChange >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $ordersChange >= 0 ? '+' : '' }}{{ number_format($ordersChange, 1) }}% vs last period
                    </small>
                </div>
                <div>
                    <i class="fas fa-shopping-cart fa-2x opacity-75 text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($analytics['products_sold']) }}</h3>
                    <p>Products Sold</p>
                    @php
                        $productsSoldChange = $previousAnalytics['products_sold'] > 0
                            ? (($analytics['products_sold'] - $previousAnalytics['products_sold']) / $previousAnalytics['products_sold']) * 100
                            : 0;
                    @endphp
                    <small class="{{ $productsSoldChange >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $productsSoldChange >= 0 ? '+' : '' }}{{ number_format($productsSoldChange, 1) }}% vs last period
                    </small>
                </div>
                <div>
                    <i class="fas fa-box fa-2x opacity-75 text-info"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ $analytics['average_rating'] > 0 ? number_format($analytics['average_rating'], 1) : 'N/A' }}</h3>
                    <p>Average Rating</p>
                    @php
                        $ratingChange = $previousAnalytics['average_rating'] > 0
                            ? $analytics['average_rating'] - $previousAnalytics['average_rating']
                            : 0;
                    @endphp
                    <small class="{{ $ratingChange >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $ratingChange >= 0 ? '+' : '' }}{{ number_format($ratingChange, 1) }} vs last period
                    </small>
                </div>
                <div>
                    <i class="fas fa-star fa-2x opacity-75 text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <!-- Revenue Chart -->
    <div class="col-md-8">
        <div class="vendor-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Revenue Trend</h5>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-secondary active">Daily</button>
                    <button class="btn btn-outline-secondary">Weekly</button>
                    <button class="btn btn-outline-secondary">Monthly</button>
                </div>
            </div>
            <div style="height: 300px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <div class="text-center">
                    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                    <h5>Revenue: KES {{ number_format($analytics['total_revenue'], 0) }}</h5>
                    <p class="text-muted">{{ $analytics['total_orders'] }} orders in selected period</p>
                    <small class="text-muted">Chart functionality can be added later</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-md-4">
        <div class="vendor-card">
            <h5 class="mb-3">Top Selling Products</h5>
            <div class="list-group list-group-flush">
                @forelse($topProducts->take(5) as $product)
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div class="d-flex align-items-center">
                        @if($product->main_image)
                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="Product" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fas fa-image text-muted"></i>
                        </div>
                        @endif
                        <div>
                            <h6 class="mb-1">{{ $product->name }}</h6>
                            <small class="text-muted">{{ $product->total_sold }} sales</small>
                        </div>
                    </div>
                    <span class="badge bg-primary rounded-pill">KES {{ number_format($product->total_revenue, 0) }}</span>
                </div>
                @empty
                <div class="list-group-item border-0 px-0 text-center">
                    <small class="text-muted">No sales data available</small>
                </div>
                @endforelse
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}" alt="Product" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                        <div>
                            <h6 class="mb-1">Ceriotti Hair Dryer</h6>
                            <small class="text-muted">32 sales</small>
                        </div>
                    </div>
                    <span class="badge bg-primary rounded-pill">KSh 80,000</span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}" alt="Product" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                        <div>
                            <h6 class="mb-1">Beard Trimmer</h6>
                            <small class="text-muted">28 sales</small>
                        </div>
                    </div>
                    <span class="badge bg-primary rounded-pill">KSh 22,400</span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}" alt="Product" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                        <div>
                            <h6 class="mb-1">Hair Clipper Set</h6>
                            <small class="text-muted">22 sales</small>
                        </div>
                    </div>
                    <span class="badge bg-primary rounded-pill">KSh 26,400</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Analytics -->
<div class="row mb-4">
    <!-- Customer Demographics -->
    <div class="col-md-6">
        <div class="vendor-card">
            <h5 class="mb-3">Customer Demographics</h5>
            <div style="height: 250px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <div class="text-center">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5>{{ $analytics['total_orders'] }} Customers</h5>
                    <p class="text-muted">Served in selected period</p>
                    <small class="text-muted">Demographics data can be added later</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales by Category -->
    <div class="col-md-6">
        <div class="vendor-card">
            <h5 class="mb-3">Sales by Category</h5>
            <div class="p-3">
                <div class="text-center mb-3">
                    <i class="fas fa-chart-pie fa-2x text-muted mb-2"></i>
                    <h6>Category Sales</h6>
                </div>
                @forelse($categoryData->take(5) as $category)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>{{ $category->name }}</span>
                    <span class="badge bg-secondary">{{ $category->total_sold }} sold</span>
                </div>
                @empty
                <p class="text-muted text-center">No category data available</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Performance Metrics -->
<div class="row">
    <div class="col-md-4">
        <div class="vendor-card">
            <h5 class="mb-3">Conversion Rate</h5>
            <div class="text-center">
                <div class="display-4 text-primary mb-2">{{ number_format($analytics['conversion_rate'], 1) }}%</div>
                <p class="text-muted mb-2">Product views to orders</p>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ min(100, $analytics['conversion_rate'] * 10) }}%; background: var(--base_color);"></div>
                </div>
                @php
                    $conversionChange = $previousAnalytics['conversion_rate'] > 0
                        ? $analytics['conversion_rate'] - $previousAnalytics['conversion_rate']
                        : 0;
                @endphp
                <small class="{{ $conversionChange >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $conversionChange >= 0 ? '+' : '' }}{{ number_format($conversionChange, 1) }}% vs last period
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="vendor-card">
            <h5 class="mb-3">Average Order Value</h5>
            <div class="text-center">
                <div class="display-4 text-primary mb-2">KES {{ number_format($analytics['average_order_value'], 0) }}</div>
                <p class="text-muted mb-2">Per order average</p>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ min(100, ($analytics['average_order_value'] / 5000) * 100) }}%; background: var(--success_color);"></div>
                </div>
                @php
                    $aovChange = $previousAnalytics['average_order_value'] > 0
                        ? $analytics['average_order_value'] - $previousAnalytics['average_order_value']
                        : 0;
                @endphp
                <small class="{{ $aovChange >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $aovChange >= 0 ? '+' : '' }}KES {{ number_format($aovChange, 0) }} vs last period
                </small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="vendor-card">
            <h5 class="mb-3">Customer Retention</h5>
            <div class="text-center">
                <div class="display-4 text-primary mb-2">68%</div>
                <p class="text-muted mb-2">Repeat customers</p>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar" style="width: 68%; background: var(--warning_color);"></div>
                </div>
                <small class="text-success">+5% vs last period</small>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row mt-4">
    <div class="col-12">
        <div class="vendor-card">
            <h5 class="mb-3">Recent Activity</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>Details</th>
                            <th>Impact</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentActivity as $activity)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($activity['type'] == 'order')
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-shopping-cart text-white"></i>
                                    </div>
                                    @elseif($activity['type'] == 'view')
                                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-eye text-white"></i>
                                    </div>
                                    @else
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-star text-white"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <strong>{{ $activity['title'] }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $activity['type'] == 'order' ? 'Paid Order' : ucfirst($activity['type']) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $activity['description'] }}</td>
                            <td>
                                @if($activity['type'] == 'order')
                                <span class="text-success">{{ $activity['impact'] }}</span>
                                @else
                                <span class="text-info">{{ $activity['impact'] }}</span>
                                @endif
                            </td>
                            <td>{{ $activity['time'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-chart-line fa-3x mb-3"></i>
                                    <h5>No Recent Activity</h5>
                                    <p>Activity will appear here as customers interact with your products and place orders.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
