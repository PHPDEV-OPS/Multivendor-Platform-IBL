@extends('vendor.layouts.app')

@section('page-title', 'Reports & Analytics')
@section('page-subtitle', 'Generate detailed reports and insights')

@section('content')
<div class="container-fluid">
    <!-- Report Filters -->
    <div class="vendor-card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Report Filters</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('vendor.reports') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Report Type</label>
                            <select class="form-select" name="report_type" onchange="this.form.submit()">
                                <option value="sales" {{ $reportType == 'sales' ? 'selected' : '' }}>Sales Report</option>
                                <option value="products" {{ $reportType == 'products' ? 'selected' : '' }}>Product Performance</option>
                                <option value="customers" {{ $reportType == 'customers' ? 'selected' : '' }}>Customer Analysis</option>
                                <option value="inventory" {{ $reportType == 'inventory' ? 'selected' : '' }}>Inventory Report</option>
                                <option value="revenue" {{ $reportType == 'revenue' ? 'selected' : '' }}>Revenue Report</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Date Range</label>
                            <select class="form-select" name="date_range" onchange="this.form.submit()">
                                <option value="today" {{ $dateRange == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="yesterday" {{ $dateRange == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                <option value="last7days" {{ $dateRange == 'last7days' ? 'selected' : '' }}>Last 7 Days</option>
                                <option value="last30days" {{ $dateRange == 'last30days' ? 'selected' : '' }}>Last 30 Days</option>
                                <option value="last90days" {{ $dateRange == 'last90days' ? 'selected' : '' }}>Last 90 Days</option>
                                <option value="custom" {{ $dateRange == 'custom' ? 'selected' : '' }}>Custom Range</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-end h-100">
                            <button type="submit" class="vendor-btn vendor-btn-primary me-2">
                                <i class="fas fa-chart-bar me-2"></i>Generate Report
                            </button>
                            <a href="{{ route('vendor.reports.export', request()->query()) }}" class="vendor-btn vendor-btn-outline me-2">
                                <i class="fas fa-download me-2"></i>Export
                            </a>
                            <button type="button" class="vendor-btn vendor-btn-secondary" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>Print
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Summary -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="vendor-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stats-content">
                        <h4>KES {{ number_format($reportData['summary']['total_revenue'] ?? 0, 0) }}</h4>
                        <p>Total Revenue</p>
                        <small class="text-muted">From paid orders</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="vendor-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stats-content">
                        <h4>{{ number_format($reportData['summary']['total_orders'] ?? 0) }}</h4>
                        <p>Total Orders</p>
                        <small class="text-muted">Paid orders only</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="vendor-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stats-content">
                        <h4>{{ number_format($reportData['summary']['total_items'] ?? $reportData['summary']['products_sold'] ?? 0) }}</h4>
                        <p>Items Sold</p>
                        <small class="text-muted">Total quantity</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="vendor-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-content">
                        <h4>KES {{ number_format($reportData['summary']['average_order_value'] ?? 0, 0) }}</h4>
                        <p>Avg Order Value</p>
                        <small class="text-muted">Per order average</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="vendor-card">
                <div class="card-header">
                    <h6 class="mb-0">Sales Trend</h6>
                </div>
                <div class="card-body">
                    @if($reportType == 'revenue' && isset($reportData['daily_revenue']))
                    <!-- Daily Revenue Data -->
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Revenue</th>
                                    <th>Orders</th>
                                    <th>Avg Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reportData['daily_revenue']->take(10) as $day)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($day->date)->format('M d, Y') }}</td>
                                    <td>KES {{ number_format($day->revenue, 0) }}</td>
                                    <td>{{ $day->orders }}</td>
                                    <td>KES {{ $day->orders > 0 ? number_format($day->revenue / $day->orders, 0) : 0 }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No revenue data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @else
                    <!-- Sales Summary -->
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border-end">
                                <h4 class="text-primary">KES {{ number_format($reportData['summary']['total_revenue'] ?? 0, 0) }}</h4>
                                <small class="text-muted">Total Revenue</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-end">
                                <h4 class="text-success">{{ number_format($reportData['summary']['total_orders'] ?? 0) }}</h4>
                                <small class="text-muted">Total Orders</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-end">
                                <h4 class="text-info">{{ number_format($reportData['summary']['total_items'] ?? $reportData['summary']['products_sold'] ?? 0) }}</h4>
                                <small class="text-muted">Items Sold</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-warning">KES {{ number_format($reportData['summary']['average_order_value'] ?? 0, 0) }}</h4>
                            <small class="text-muted">Avg Order</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <p class="text-muted mb-0">Real-time sales data for selected period</p>
                        <small class="text-muted">Chart visualization can be added later</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="vendor-card">
                <div class="card-header">
                    <h6 class="mb-0">Top Products</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @if($reportType == 'products' && isset($reportData['top_products']))
                            @forelse($reportData['top_products']->take(5) as $product)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $product->name }}</h6>
                                    <small class="text-muted">{{ $product->total_sold }} sold</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">KES {{ number_format($product->total_revenue, 0) }}</span>
                            </div>
                            @empty
                            <div class="list-group-item text-center">
                                <small class="text-muted">No product sales data available</small>
                            </div>
                            @endforelse
                        @elseif($reportType == 'customers' && isset($reportData['top_customers']))
                            @forelse($reportData['top_customers']->take(5) as $customer)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $customer->user ? $customer->user->name : 'Customer' }}</h6>
                                    <small class="text-muted">{{ $customer->order_count }} orders</small>
                                </div>
                                <span class="badge bg-success rounded-pill">KES {{ number_format($customer->total_spent, 0) }}</span>
                            </div>
                            @empty
                            <div class="list-group-item text-center">
                                <small class="text-muted">No customer data available</small>
                            </div>
                            @endforelse
                        @else
                            <!-- Default: Recent Orders -->
                            @if(isset($reportData['orders']))
                                @forelse($reportData['orders']->take(5) as $order)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $order->order_number }}</h6>
                                        <small class="text-muted">{{ $order->user ? $order->user->name : 'Customer' }}</small>
                                    </div>
                                    <span class="badge bg-success rounded-pill">KES {{ number_format($order->vendor_amount, 0) }}</span>
                                </div>
                                @empty
                                <div class="list-group-item text-center">
                                    <small class="text-muted">No orders available</small>
                                </div>
                                @endforelse
                            @else
                                <div class="list-group-item text-center">
                                    <small class="text-muted">No data available for this report type</small>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Report Table -->
    <div class="vendor-card">
        <div class="card-header">
            <h6 class="mb-0">Detailed Report</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if($reportType == 'sales' && isset($reportData['orders']))
                <table class="vendor-table" id="reportTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Vendor Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportData['orders'] as $order)
                        <tr>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                            <td>{{ $order->items->sum('quantity') }} items</td>
                            <td>KES {{ number_format($order->total_amount, 0) }}</td>
                            <td>KES {{ number_format($order->vendor_amount, 0) }}</td>
                            <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No orders found for this period</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @elseif($reportType == 'products' && isset($reportData['top_products']))
                <table class="vendor-table" id="reportTable">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Units Sold</th>
                            <th>Total Revenue</th>
                            <th>Performance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportData['top_products'] as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>KES {{ number_format($product->price, 0) }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>{{ $product->total_sold }}</td>
                            <td>KES {{ number_format($product->total_revenue, 0) }}</td>
                            <td>
                                @if($product->total_sold > 10)
                                <span class="badge bg-success">High</span>
                                @elseif($product->total_sold > 5)
                                <span class="badge bg-warning">Medium</span>
                                @else
                                <span class="badge bg-secondary">Low</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No product sales data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @elseif($reportType == 'customers' && isset($reportData['top_customers']))
                <table class="vendor-table" id="reportTable">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Orders</th>
                            <th>Total Spent</th>
                            <th>Customer Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportData['top_customers'] as $customer)
                        <tr>
                            <td>{{ $customer->user ? $customer->user->name : 'N/A' }}</td>
                            <td>{{ $customer->user ? $customer->user->email : 'N/A' }}</td>
                            <td>{{ $customer->order_count }}</td>
                            <td>KES {{ number_format($customer->total_spent, 0) }}</td>
                            <td>
                                @if($customer->order_count > 5)
                                <span class="badge bg-success">VIP</span>
                                @elseif($customer->order_count > 2)
                                <span class="badge bg-warning">Regular</span>
                                @else
                                <span class="badge bg-secondary">New</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No customer data available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @elseif($reportType == 'inventory' && isset($reportData['products']))
                <table class="vendor-table" id="reportTable">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Current Stock</th>
                            <th>Min Alert</th>
                            <th>Price</th>
                            <th>Stock Value</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reportData['products'] as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku ?: 'N/A' }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>{{ $product->min_stock_alert ?: 'N/A' }}</td>
                            <td>KES {{ number_format($product->price, 0) }}</td>
                            <td>KES {{ number_format($product->stock_quantity * $product->price, 0) }}</td>
                            <td>
                                @if($product->stock_quantity == 0)
                                <span class="badge bg-danger">Out of Stock</span>
                                @elseif($product->stock_quantity <= $product->min_stock_alert)
                                <span class="badge bg-warning">Low Stock</span>
                                @else
                                <span class="badge bg-success">In Stock</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No products found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                    <h5>Report Data</h5>
                    <p class="text-muted">Select a report type and date range to view detailed data</p>
                </div>
                @endif

            </div>

            <!-- Pagination -->
            <nav class="mt-3">
                <ul class="pagination justify-content-center">
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
</div>

<!-- Export Options Modal -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="form-label">Export Format</label>
                    <select class="form-select" id="exportFormat">
                        <option value="pdf">PDF</option>
                        <option value="excel">Excel (.xlsx)</option>
                        <option value="csv">CSV</option>
                        <option value="json">JSON</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Include Charts</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeCharts" checked>
                        <label class="form-check-label" for="includeCharts">
                            Include charts and graphs
                        </label>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Email Report</label>
                    <input type="email" class="form-control" placeholder="Enter email address (optional)">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="vendor-btn vendor-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="vendor-btn vendor-btn-primary" onclick="confirmExport()">Export Report</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let salesChart;

document.addEventListener('DOMContentLoaded', function() {
    initializeChart();
    setupEventListeners();
});

function initializeChart() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan 1', 'Jan 5', 'Jan 10', 'Jan 15', 'Jan 20', 'Jan 25', 'Jan 30'],
            datasets: [{
                label: 'Revenue',
                data: [1200, 1900, 1500, 2100, 1800, 2400, 2200],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }, {
                label: 'Orders',
                data: [12, 19, 15, 21, 18, 24, 22],
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.1,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Revenue ($)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Orders'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });
}

function setupEventListeners() {
    // Date range change handler
    document.getElementById('dateRange').addEventListener('change', function() {
        const dateRange = this.value;
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');

        const today = new Date();
        let start = new Date();

        switch(dateRange) {
            case 'today':
                start = today;
                break;
            case 'yesterday':
                start.setDate(today.getDate() - 1);
                break;
            case 'last7days':
                start.setDate(today.getDate() - 7);
                break;
            case 'last30days':
                start.setDate(today.getDate() - 30);
                break;
            case 'last90days':
                start.setDate(today.getDate() - 90);
                break;
        }

        if (dateRange !== 'custom') {
            startDate.value = start.toISOString().split('T')[0];
            endDate.value = today.toISOString().split('T')[0];
        }
    });
}

function generateReport() {
    const reportType = document.getElementById('reportType').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    // Show loading state
    const generateBtn = document.querySelector('.vendor-btn-primary');
    const originalText = generateBtn.innerHTML;
    generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating...';
    generateBtn.disabled = true;

    // Simulate API call
    setTimeout(() => {
        // Update chart data based on report type
        updateChartData(reportType);

        // Update table data
        updateTableData(reportType);

        // Reset button
        generateBtn.innerHTML = originalText;
        generateBtn.disabled = false;

        // Show success message
        showAlert('Report generated successfully!', 'success');
    }, 2000);
}

function updateChartData(reportType) {
    // This would typically fetch data from the server
    const newData = {
        sales: {
            labels: ['Jan 1', 'Jan 5', 'Jan 10', 'Jan 15', 'Jan 20', 'Jan 25', 'Jan 30'],
            revenue: [1200, 1900, 1500, 2100, 1800, 2400, 2200],
            orders: [12, 19, 15, 21, 18, 24, 22]
        },
        products: {
            labels: ['Headphones', 'Phone Case', 'Smart Watch', 'Speaker', 'Charger'],
            revenue: [2450, 1890, 1650, 1320, 980],
            sales: [25, 45, 12, 18, 30]
        }
    };

    if (salesChart && newData[reportType]) {
        salesChart.data.labels = newData[reportType].labels;
        salesChart.data.datasets[0].data = newData[reportType].revenue || newData[reportType].sales;
        salesChart.update();
    }
}

function updateTableData(reportType) {
    // This would typically update the table with new data
    console.log('Updating table for report type:', reportType);
}

function exportReport() {
    const exportModal = new bootstrap.Modal(document.getElementById('exportModal'));
    exportModal.show();
}

function confirmExport() {
    const format = document.getElementById('exportFormat').value;
    const includeCharts = document.getElementById('includeCharts').checked;

    // Show loading state
    const exportBtn = document.querySelector('#exportModal .vendor-btn-primary');
    const originalText = exportBtn.innerHTML;
    exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Exporting...';
    exportBtn.disabled = true;

    // Simulate export process
    setTimeout(() => {
        exportBtn.innerHTML = originalText;
        exportBtn.disabled = false;

        // Close modal
        bootstrap.Modal.getInstance(document.getElementById('exportModal')).hide();

        // Show success message
        showAlert(`Report exported successfully as ${format.toUpperCase()}!`, 'success');
    }, 2000);
}

function printReport() {
    window.print();
}

function showAlert(message, type) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}
</script>
@endpush
