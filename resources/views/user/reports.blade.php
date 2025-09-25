@extends('layouts.unified')

@section('page-title', 'Reports & Analytics')
@section('page-subtitle', 'Generate detailed reports and insights')

@section('content')
<div class="container-fluid">
    <!-- Report Filters -->
    <div class="user-card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Report Filters</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label">Report Type</label>
                        <select class="form-select" id="reportType">
                            <option value="sales">Sales Report</option>
                            <option value="products">Product Performance</option>
                            <option value="customers">Customer Analysis</option>
                            <option value="inventory">Inventory Report</option>
                            <option value="revenue">Revenue Report</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label">Date Range</label>
                        <select class="form-select" id="dateRange">
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last7days">Last 7 Days</option>
                            <option value="last30days" selected>Last 30 Days</option>
                            <option value="last90days">Last 90 Days</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate" value="2024-01-01">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" id="endDate" value="2024-01-31">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select">
                            <option value="">All Categories</option>
                            <option value="electronics">Electronics</option>
                            <option value="clothing">Clothing</option>
                            <option value="home">Home & Garden</option>
                            <option value="sports">Sports</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select">
                            <option value="">All Status</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-end h-100">
                        <button class="user-btn user-btn-primary me-2" onclick="generateReport()">
                            <i class="fas fa-chart-bar me-2"></i>Generate Report
                        </button>
                        <button class="user-btn user-btn-outline me-2" onclick="exportReport()">
                            <i class="fas fa-download me-2"></i>Export
                        </button>
                        <button class="user-btn user-btn-secondary" onclick="printReport()">
                            <i class="fas fa-print me-2"></i>Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Summary -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="user-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stats-content">
                        <h4>$12,450</h4>
                        <p>Total Revenue</p>
                        <small class="text-success">+15.3% vs last period</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="user-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stats-content">
                        <h4>156</h4>
                        <p>Total Orders</p>
                        <small class="text-success">+8.7% vs last period</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="user-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stats-content">
                        <h4>89</h4>
                        <p>Products Sold</p>
                        <small class="text-success">+12.1% vs last period</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="user-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-content">
                        <h4>67</h4>
                        <p>New Customers</p>
                        <small class="text-success">+22.4% vs last period</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="user-card">
                <div class="card-header">
                    <h6 class="mb-0">Sales Trend</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="user-card">
                <div class="card-header">
                    <h6 class="mb-0">Top Products</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Wireless Headphones</h6>
                                <small class="text-muted">Electronics</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">$2,450</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Phone Case Premium</h6>
                                <small class="text-muted">Accessories</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">$1,890</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Smart Watch</h6>
                                <small class="text-muted">Electronics</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">$1,650</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Bluetooth Speaker</h6>
                                <small class="text-muted">Electronics</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">$1,320</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Report Table -->
    <div class="user-card">
        <div class="card-header">
            <h6 class="mb-0">Detailed Report</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="user-table" id="reportTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Products</th>
                            <th>Revenue</th>
                            <th>Commission</th>
                            <th>Net Earnings</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Jan 15, 2024</td>
                            <td>#ORD-001</td>
                            <td>John Doe</td>
                            <td>Wireless Headphones</td>
                            <td>$89.99</td>
                            <td>$8.99</td>
                            <td>$81.00</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td>Jan 14, 2024</td>
                            <td>#ORD-002</td>
                            <td>Jane Smith</td>
                            <td>Phone Case, Smart Watch</td>
                            <td>$124.98</td>
                            <td>$12.50</td>
                            <td>$112.48</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td>Jan 13, 2024</td>
                            <td>#ORD-003</td>
                            <td>Mike Johnson</td>
                            <td>Bluetooth Speaker</td>
                            <td>$79.99</td>
                            <td>$8.00</td>
                            <td>$71.99</td>
                            <td><span class="status-badge status-pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>Jan 12, 2024</td>
                            <td>#ORD-004</td>
                            <td>Sarah Wilson</td>
                            <td>Wireless Headphones</td>
                            <td>$89.99</td>
                            <td>$9.00</td>
                            <td>$80.99</td>
                            <td><span class="status-badge status-completed">Completed</span></td>
                        </tr>
                        <tr>
                            <td>Jan 11, 2024</td>
                            <td>#ORD-005</td>
                            <td>David Brown</td>
                            <td>Phone Case</td>
                            <td>$24.99</td>
                            <td>$2.50</td>
                            <td>$22.49</td>
                            <td><span class="status-badge status-cancelled">Cancelled</span></td>
                        </tr>
                    </tbody>
                </table>
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
                <button type="button" class="user-btn user-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="user-btn user-btn-primary" onclick="confirmExport()">Export Report</button>
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
    const generateBtn = document.querySelector('.user-btn-primary');
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
    const exportBtn = document.querySelector('#exportModal .user-btn-primary');
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
