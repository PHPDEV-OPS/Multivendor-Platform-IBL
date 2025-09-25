@extends('admin.layouts.app')

@section('page-title', 'Analytics')
@section('page-subtitle', 'Track your store performance and insights')

@section('content')
<!-- Date Range Filter -->
<div class="admin-card mb-4">
    <form method="GET" action="{{ route('admin.analytics') }}">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">Analytics Overview</h5>
                <p class="text-muted mb-0">Track your store performance and customer insights</p>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-2 justify-content-end">
                    <input type="date" class="form-control" name="start_date" value="{{ $startDate }}" style="width: auto;">
                    <span class="align-self-center">to</span>
                    <input type="date" class="form-control" name="end_date" value="{{ $endDate }}" style="width: auto;">
                    <button type="submit" class="admin-btn">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <button type="button" class="admin-btn">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Key Metrics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>KSh {{ number_format($revenueData['total']) }}</h3>
                    <p>Total Revenue</p>
                    <small class="text-success">Period: {{ $startDate }} to {{ $endDate }}</small>
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
                    <h3>{{ number_format($orderData['total']) }}</h3>
                    <p>Total Orders</p>
                    <small class="text-success">Avg: {{ number_format($orderData['average'], 1) }} per day</small>
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
                    <h3>{{ number_format($customerData['new']) }}</h3>
                    <p>New Customers</p>
                    <small class="text-success">Total: {{ number_format($customerData['total']) }}</small>
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
                    <h3>{{ number_format($customerData['active']) }}</h3>
                    <p>Active Customers</p>
                    <small class="text-success">{{ $customerData['total'] > 0 ? round(($customerData['active'] / $customerData['total']) * 100) : 0 }}% of total</small>
                </div>
                <div>
                    <i class="fas fa-user-check fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <!-- Revenue Chart -->
    <div class="col-md-8">
        <div class="admin-card">
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
                    <p class="text-muted">Revenue chart will be displayed here</p>
                    <small class="text-muted">Chart showing daily/weekly/monthly revenue trends</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-md-4">
        <div class="admin-card">
            <h5 class="mb-3">Top Selling Products</h5>
            <div class="list-group list-group-flush">
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('frontend/amazy/img/67b5a3c9e4224.png') }}" alt="Product" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                        <div>
                            <h6 class="mb-1">Nova Hair Shaving Machine</h6>
                            <small class="text-muted">45 sales</small>
                        </div>
                    </div>
                    <span class="badge bg-primary rounded-pill">KSh 45,000</span>
                </div>
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
        <div class="admin-card">
            <h5 class="mb-3">Customer Demographics</h5>
            <div style="height: 250px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <div class="text-center">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Customer demographics chart</p>
                    <small class="text-muted">Age groups, locations, gender distribution</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales by Category -->
    <div class="col-md-6">
        <div class="admin-card">
            <h5 class="mb-3">Sales by Category</h5>
            <div style="height: 250px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <div class="text-center">
                    <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Category sales distribution</p>
                    <small class="text-muted">Pie chart showing sales by product category</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Performance Metrics -->
<div class="row">
    <div class="col-md-4">
        <div class="admin-card">
            <h5 class="mb-3">Conversion Rate</h5>
            <div class="text-center">
                <div class="display-4 text-primary mb-2">3.2%</div>
                <p class="text-muted mb-2">Website visitors to customers</p>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar" style="width: 32%; background: var(--base_color);"></div>
                </div>
                <small class="text-success">+0.5% vs last period</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card">
            <h5 class="mb-3">Average Order Value</h5>
            <div class="text-center">
                <div class="display-4 text-primary mb-2">KSh 1,250</div>
                <p class="text-muted mb-2">Per order average</p>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar" style="width: 75%; background: var(--success_color);"></div>
                </div>
                <small class="text-success">+KSh 150 vs last period</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card">
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
        <div class="admin-card">
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
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-shopping-cart text-white"></i>
                                    </div>
                                    <div>
                                        <strong>New Order</strong>
                                        <br>
                                        <small class="text-muted">Order #ORD-005</small>
                                    </div>
                                </div>
                            </td>
                            <td>Mary Johnson ordered Nova Hair Shaving Machine</td>
                            <td><span class="text-success">+KSh 1,000</span></td>
                            <td>2 hours ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-star text-white"></i>
                                    </div>
                                    <div>
                                        <strong>New Review</strong>
                                        <br>
                                        <small class="text-muted">5-star rating</small>
                                    </div>
                                </div>
                            </td>
                            <td>Customer left 5-star review for Ceriotti Hair Dryer</td>
                            <td><span class="text-success">+0.1 rating</span></td>
                            <td>4 hours ago</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-box text-white"></i>
                                    </div>
                                    <div>
                                        <strong>Low Stock Alert</strong>
                                        <br>
                                        <small class="text-muted">Beard Trimmer</small>
                                    </div>
                                </div>
                            </td>
                            <td>Beard Trimmer stock is running low (5 items left)</td>
                            <td><span class="text-warning">Stock alert</span></td>
                            <td>6 hours ago</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
