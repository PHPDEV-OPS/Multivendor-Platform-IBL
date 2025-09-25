@extends('vendor.layouts.app')

@section('page-title', 'Finance')
@section('page-subtitle', 'Track your earnings and financial performance')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Finance</h4>
        <p class="text-muted mb-0">Track your earnings and financial performance</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('vendor.finance.export') }}" class="vendor-btn">
            <i class="fas fa-download"></i> Export Report
        </a>
        <button class="vendor-btn" onclick="window.print()">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
</div>

<!-- Financial Overview -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>KES {{ number_format($financialOverview['total_revenue'], 0) }}</h3>
                    <p>Total Revenue</p>
                    @php
                        $revenueChange = $previousMonthData['total_revenue'] > 0
                            ? (($financialOverview['total_revenue'] - $previousMonthData['total_revenue']) / $previousMonthData['total_revenue']) * 100
                            : 0;
                    @endphp
                    <small class="{{ $revenueChange >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $revenueChange >= 0 ? '+' : '' }}{{ number_format($revenueChange, 1) }}% vs last month
                    </small>
                </div>
                <div>
                    <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>KES {{ number_format($financialOverview['net_earnings'], 0) }}</h3>
                    <p>Net Earnings</p>
                    @php
                        $earningsChange = $previousMonthData['net_earnings'] > 0
                            ? (($financialOverview['net_earnings'] - $previousMonthData['net_earnings']) / $previousMonthData['net_earnings']) * 100
                            : 0;
                    @endphp
                    <small class="{{ $earningsChange >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $earningsChange >= 0 ? '+' : '' }}{{ number_format($earningsChange, 1) }}% vs last month
                    </small>
                </div>
                <div>
                    <i class="fas fa-chart-line fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>KES {{ number_format($financialOverview['platform_fees'], 0) }}</h3>
                    <p>Platform Fees</p>
                    @php
                        $commissionRate = $financialOverview['total_revenue'] > 0
                            ? ($financialOverview['platform_fees'] / $financialOverview['total_revenue']) * 100
                            : 0;
                    @endphp
                    <small class="text-muted">{{ number_format($commissionRate, 1) }}% commission</small>
                </div>
                <div>
                    <i class="fas fa-percentage fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="vendor-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($financialOverview['total_orders']) }}</h3>
                    <p>Total Orders</p>
                    <small class="text-muted">Paid orders this month</small>
                </div>
                <div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Date Range Filter -->
<div class="vendor-card mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h5 class="mb-0">Financial Report</h5>
            <p class="text-muted mb-0">Select date range to view detailed reports</p>
        </div>
        <div class="col-md-6">
            <div class="d-flex gap-2 justify-content-end">
                <select class="form-select" style="width: auto;">
                    <option>Last 7 days</option>
                    <option selected>Last 30 days</option>
                    <option>Last 3 months</option>
                    <option>Last 6 months</option>
                    <option>Last year</option>
                    <option>Custom range</option>
                </select>
                <button class="vendor-btn">
                    <i class="fas fa-calendar"></i> Apply
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Chart -->
<div class="row mb-4">
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
                    <p class="text-muted">Revenue chart will be displayed here</p>
                    <small class="text-muted">Chart showing daily/weekly/monthly revenue trends</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings Summary -->
    <div class="col-md-4">
        <div class="vendor-card">
            <h5 class="mb-3">Earnings Summary</h5>
            <div class="list-group list-group-flush">
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div>
                        <h6 class="mb-1">Current Month</h6>
                        <small class="text-muted">{{ now()->format('F Y') }}</small>
                    </div>
                    <span class="badge bg-primary rounded-pill">KES {{ number_format($financialOverview['net_earnings'], 0) }}</span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div>
                        <h6 class="mb-1">Previous Month</h6>
                        <small class="text-muted">{{ now()->subMonth()->format('F Y') }}</small>
                    </div>
                    <span class="badge bg-success rounded-pill">KES {{ number_format($previousMonthData['net_earnings'], 0) }}</span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div>
                        <h6 class="mb-1">Average Order Value</h6>
                        <small class="text-muted">This month</small>
                    </div>
                    <span class="badge bg-info rounded-pill">KES {{ number_format($financialOverview['average_order_value'], 0) }}</span>
                </div>
            </div>
        </div>

        <!-- Commission Breakdown -->
        <div class="vendor-card">
            <h5 class="mb-3">Commission Breakdown</h5>
            @if($financialOverview['total_revenue'] > 0)
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-2">
                    @php
                        $platformFeePercentage = ($financialOverview['platform_fees'] / $financialOverview['total_revenue']) * 100;
                    @endphp
                    <span>Platform Fee ({{ number_format($platformFeePercentage, 1) }}%)</span>
                    <span class="fw-bold">KES {{ number_format($financialOverview['platform_fees'], 0) }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ $platformFeePercentage }}%; background: var(--danger_color);"></div>
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-2">
                    @php
                        $netEarningsPercentage = ($financialOverview['net_earnings'] / $financialOverview['total_revenue']) * 100;
                    @endphp
                    <span>Net Earnings ({{ number_format($netEarningsPercentage, 1) }}%)</span>
                    <span class="fw-bold">KES {{ number_format($financialOverview['net_earnings'], 0) }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: {{ $netEarningsPercentage }}%; background: var(--success_color);"></div>
                </div>
            </div>
            @else
            <div class="text-center text-muted py-3">
                <i class="fas fa-chart-pie fa-2x mb-2"></i>
                <p>No revenue data available for commission breakdown</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Financial Summary -->
<div class="vendor-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Financial Summary</h5>
        <a href="{{ route('vendor.reports', ['report_type' => 'revenue']) }}" class="vendor-btn">View Reports</a>
    </div>

    <div class="row text-center">
        <div class="col-md-3">
            <div class="border-end">
                <h4 class="text-primary">KES {{ number_format($financialOverview['total_revenue'], 0) }}</h4>
                <small class="text-muted">Total Revenue</small>
                <p class="text-muted mb-0">This Month</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="border-end">
                <h4 class="text-success">KES {{ number_format($financialOverview['net_earnings'], 0) }}</h4>
                <small class="text-muted">Net Earnings</small>
                <p class="text-muted mb-0">After Commission</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="border-end">
                <h4 class="text-info">{{ number_format($financialOverview['total_orders']) }}</h4>
                <small class="text-muted">Total Orders</small>
                <p class="text-muted mb-0">Paid Orders</p>
            </div>
        </div>
        <div class="col-md-3">
            <h4 class="text-warning">KES {{ number_format($financialOverview['average_order_value'], 0) }}</h4>
            <small class="text-muted">Avg Order Value</small>
            <p class="text-muted mb-0">Per Order</p>
        </div>
    </div>

    <hr>

    <div class="text-center">
        <p class="text-muted mb-2">For detailed transaction history, visit the Orders or Reports section</p>
        <div class="d-flex justify-content-center gap-2">
            <a href="{{ route('vendor.orders') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-shopping-cart me-1"></i>View Orders
            </a>
            <a href="{{ route('vendor.reports') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-chart-bar me-1"></i>View Reports
            </a>
        </div>
    </div>
</div>
@endsection
