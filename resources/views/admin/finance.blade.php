@extends('admin.layouts.app')

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
        <button class="admin-btn">
            <i class="fas fa-download"></i> Export Report
        </button>
        <button class="admin-btn">
            <i class="fas fa-print"></i> Print
        </button>
    </div>
</div>

<!-- Date Range Filter -->
<div class="admin-card mb-4">
    <form method="GET" action="{{ route('admin.finance') }}">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">Financial Report</h5>
                <p class="text-muted mb-0">Select date range to view detailed reports</p>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-2 justify-content-end">
                    <input type="date" class="form-control" name="start_date" value="{{ $startDate }}" style="width: auto;">
                    <span class="align-self-center">to</span>
                    <input type="date" class="form-control" name="end_date" value="{{ $endDate }}" style="width: auto;">
                    <button type="submit" class="admin-btn">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Financial Overview -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>KSh {{ number_format($stats['total_revenue']) }}</h3>
                    <p>Total Revenue</p>
                    <small class="text-success">All time</small>
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
                    <h3>KSh {{ number_format($stats['monthly_revenue']) }}</h3>
                    <p>Monthly Revenue</p>
                    <small class="text-success">This month</small>
                </div>
                <div>
                    <i class="fas fa-chart-line fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['paid_orders']) }}</h3>
                    <p>Paid Orders</p>
                    <small class="text-success">{{ $stats['total_orders'] > 0 ? round(($stats['paid_orders'] / $stats['total_orders']) * 100) : 0 }}% of total</small>
                </div>
                <div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['pending_payments']) }}</h3>
                    <p>Pending Payments</p>
                    <small class="text-warning">Awaiting payment</small>
                </div>
                <div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Date Range Filter -->
<div class="admin-card mb-4">
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
                <button class="admin-btn">
                    <i class="fas fa-calendar"></i> Apply
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Chart -->
<div class="row mb-4">
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

    <!-- Payout Schedule -->
    <div class="col-md-4">
        <div class="admin-card">
            <h5 class="mb-3">Payout Schedule</h5>
            <div class="list-group list-group-flush">
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div>
                        <h6 class="mb-1">Next Payout</h6>
                        <small class="text-muted">January 25, 2025</small>
                    </div>
                    <span class="badge bg-primary rounded-pill">KSh 12,450</span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div>
                        <h6 class="mb-1">Last Payout</h6>
                        <small class="text-muted">December 25, 2024</small>
                    </div>
                    <span class="badge bg-success rounded-pill">KSh 15,230</span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div>
                        <h6 class="mb-1">Payout Method</h6>
                        <small class="text-muted">M-Pesa: +254 700 123 456</small>
                    </div>
                    <span class="badge bg-info rounded-pill">Active</span>
                </div>
            </div>
        </div>

        <!-- Commission Breakdown -->
        <div class="admin-card">
            <h5 class="mb-3">Commission Breakdown</h5>
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <span>Platform Fee (15%)</span>
                    <span class="fw-bold">KSh 6,785</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: 15%; background: var(--danger_color);"></div>
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <span>Transaction Fee (2%)</span>
                    <span class="fw-bold">KSh 905</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: 2%; background: var(--warning_color);"></div>
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <span>Net Earnings (83%)</span>
                    <span class="fw-bold">KSh 37,540</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" style="width: 83%; background: var(--success_color);"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div class="admin-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Recent Transactions</h5>
        <a href="#" class="admin-btn">View All</a>
    </div>
    
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Commission</th>
                    <th>Net Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>#TXN-001</strong>
                        <br>
                        <small class="text-muted">M-Pesa</small>
                    </td>
                    <td>
                        <a href="#" class="text-decoration-none">#ORD-001</a>
                        <br>
                        <small class="text-muted">Nova Hair Shaving Machine</small>
                    </td>
                    <td>John Doe</td>
                    <td>KSh 1,000</td>
                    <td>KSh 150</td>
                    <td><strong>KSh 850</strong></td>
                    <td><span class="status-badge status-active">Completed</span></td>
                    <td>2025-01-15</td>
                </tr>
                <tr>
                    <td>
                        <strong>#TXN-002</strong>
                        <br>
                        <small class="text-muted">Card</small>
                    </td>
                    <td>
                        <a href="#" class="text-decoration-none">#ORD-002</a>
                        <br>
                        <small class="text-muted">Ceriotti Hair Dryer</small>
                    </td>
                    <td>Jane Smith</td>
                    <td>KSh 2,500</td>
                    <td>KSh 375</td>
                    <td><strong>KSh 2,125</strong></td>
                    <td><span class="status-badge status-active">Completed</span></td>
                    <td>2025-01-14</td>
                </tr>
                <tr>
                    <td>
                        <strong>#TXN-003</strong>
                        <br>
                        <small class="text-muted">M-Pesa</small>
                    </td>
                    <td>
                        <a href="#" class="text-decoration-none">#ORD-003</a>
                        <br>
                        <small class="text-muted">Beard Trimmer (x2)</small>
                    </td>
                    <td>Mike Johnson</td>
                    <td>KSh 1,600</td>
                    <td>KSh 240</td>
                    <td><strong>KSh 1,360</strong></td>
                    <td><span class="status-badge status-active">Completed</span></td>
                    <td>2025-01-13</td>
                </tr>
                <tr>
                    <td>
                        <strong>#TXN-004</strong>
                        <br>
                        <small class="text-muted">M-Pesa</small>
                    </td>
                    <td>
                        <a href="#" class="text-decoration-none">#ORD-004</a>
                        <br>
                        <small class="text-muted">Hair Clipper Set</small>
                    </td>
                    <td>Sarah Wilson</td>
                    <td>KSh 1,200</td>
                    <td>KSh 180</td>
                    <td><strong>KSh 1,020</strong></td>
                    <td><span class="status-badge status-pending">Pending</span></td>
                    <td>2025-01-12</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <p class="text-muted mb-0">Showing 1 to 4 of 127 transactions</p>
        </div>
        <nav aria-label="Transactions pagination">
            <ul class="pagination mb-0">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Financial Summary -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="admin-card">
            <h5 class="mb-3">Monthly Summary</h5>
            <div class="text-center">
                <div class="display-6 text-primary mb-2">KSh 45,230</div>
                <p class="text-muted mb-2">Total Revenue (January 2025)</p>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar" style="width: 75%; background: var(--base_color);"></div>
                </div>
                <small class="text-success">+12.5% vs December 2024</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card">
            <h5 class="mb-3">Average Order Value</h5>
            <div class="text-center">
                <div class="display-6 text-primary mb-2">KSh 1,250</div>
                <p class="text-muted mb-2">Per order average</p>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar" style="width: 65%; background: var(--success_color);"></div>
                </div>
                <small class="text-success">+8.3% vs last month</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card">
            <h5 class="mb-3">Conversion Rate</h5>
            <div class="text-center">
                <div class="display-6 text-primary mb-2">3.2%</div>
                <p class="text-muted mb-2">Visitors to customers</p>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar" style="width: 32%; background: var(--warning_color);"></div>
                </div>
                <small class="text-success">+0.5% vs last month</small>
            </div>
        </div>
    </div>
</div>
@endsection
