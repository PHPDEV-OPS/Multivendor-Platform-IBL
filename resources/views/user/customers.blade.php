@extends('layouts.unified')

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
        <button class="user-btn">
            <i class="fas fa-download"></i> Export
        </button>
        <button class="user-btn">
            <i class="fas fa-envelope"></i> Send Email
        </button>
    </div>
</div>

<!-- Customer Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="user-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>1,247</h3>
                    <p>Total Customers</p>
                    <small class="text-success">+15% this month</small>
                </div>
                <div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="user-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>847</h3>
                    <p>Active Customers</p>
                    <small class="text-success">+8% this month</small>
                </div>
                <div>
                    <i class="fas fa-user-check fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="user-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>KSh 1,250</h3>
                    <p>Avg. Order Value</p>
                    <small class="text-success">+12% this month</small>
                </div>
                <div>
                    <i class="fas fa-dollar-sign fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="user-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>68%</h3>
                    <p>Retention Rate</p>
                    <small class="text-success">+5% this month</small>
                </div>
                <div>
                    <i class="fas fa-heart fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="user-card mb-4">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="customer_search" class="form-label">Search Customers</label>
                <input type="text" class="form-control" id="customer_search" placeholder="Name, email, phone...">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="customer_status" class="form-label">Status</label>
                <select class="form-select" id="customer_status">
                    <option value="">All Customers</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="new">New</option>
                    <option value="vip">VIP</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="customer_location" class="form-label">Location</label>
                <select class="form-select" id="customer_location">
                    <option value="">All Locations</option>
                    <option value="nairobi">Nairobi</option>
                    <option value="mombasa">Mombasa</option>
                    <option value="kisumu">Kisumu</option>
                    <option value="nakuru">Nakuru</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="customer_sort" class="form-label">Sort By</label>
                <select class="form-select" id="customer_sort">
                    <option value="recent">Most Recent</option>
                    <option value="orders">Most Orders</option>
                    <option value="spent">Most Spent</option>
                    <option value="name">Name A-Z</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label class="form-label">&nbsp;</label>
                <button class="user-btn w-100">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Customers Table -->
<div class="user-card">
    <div class="table-responsive">
        <table class="table user-table">
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
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <span class="text-white fw-bold">JD</span>
                            </div>
                            <div>
                                <h6 class="mb-1">John Doe</h6>
                                <small class="text-muted">Customer since Jan 2024</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <div>john.doe@example.com</div>
                            <small class="text-muted">+254 700 123 456</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>15 orders</strong>
                            <br>
                            <small class="text-muted">Last 30 days: 3</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>KSh 18,500</strong>
                            <br>
                            <small class="text-muted">Avg: KSh 1,233</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>2025-01-15</strong>
                            <br>
                            <small class="text-muted">2 days ago</small>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge status-active">VIP</span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-envelope"></i> Send Email</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-shopping-cart"></i> View Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-star"></i> Mark as VIP</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <span class="text-white fw-bold">JS</span>
                            </div>
                            <div>
                                <h6 class="mb-1">Jane Smith</h6>
                                <small class="text-muted">Customer since Dec 2023</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <div>jane.smith@example.com</div>
                            <small class="text-muted">+254 700 789 012</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>8 orders</strong>
                            <br>
                            <small class="text-muted">Last 30 days: 1</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>KSh 12,800</strong>
                            <br>
                            <small class="text-muted">Avg: KSh 1,600</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>2025-01-14</strong>
                            <br>
                            <small class="text-muted">3 days ago</small>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge status-active">Active</span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-envelope"></i> Send Email</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-shopping-cart"></i> View Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-star"></i> Mark as VIP</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <span class="text-white fw-bold">MJ</span>
                            </div>
                            <div>
                                <h6 class="mb-1">Mike Johnson</h6>
                                <small class="text-muted">Customer since Nov 2023</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <div>mike.johnson@example.com</div>
                            <small class="text-muted">+254 700 345 678</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>22 orders</strong>
                            <br>
                            <small class="text-muted">Last 30 days: 5</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>KSh 28,400</strong>
                            <br>
                            <small class="text-muted">Avg: KSh 1,291</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>2025-01-13</strong>
                            <br>
                            <small class="text-muted">4 days ago</small>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge status-active">VIP</span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-envelope"></i> Send Email</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-shopping-cart"></i> View Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-star"></i> Mark as VIP</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <span class="text-white fw-bold">SW</span>
                            </div>
                            <div>
                                <h6 class="mb-1">Sarah Wilson</h6>
                                <small class="text-muted">Customer since Jan 2025</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <div>sarah.wilson@example.com</div>
                            <small class="text-muted">+254 700 901 234</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>2 orders</strong>
                            <br>
                            <small class="text-muted">Last 30 days: 2</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>KSh 2,400</strong>
                            <br>
                            <small class="text-muted">Avg: KSh 1,200</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>2025-01-12</strong>
                            <br>
                            <small class="text-muted">5 days ago</small>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge status-pending">New</span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-envelope"></i> Send Email</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-shopping-cart"></i> View Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-star"></i> Mark as VIP</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <p class="text-muted mb-0">Showing 1 to 4 of 1,247 customers</p>
        </div>
        <nav aria-label="Customers pagination">
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

<!-- Customer Insights -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="user-card">
            <h5 class="mb-3">Top Customers</h5>
            <div class="list-group list-group-flush">
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <span class="text-white fw-bold">MJ</span>
                        </div>
                        <div>
                            <h6 class="mb-1">Mike Johnson</h6>
                            <small class="text-muted">22 orders</small>
                        </div>
                    </div>
                    <span class="badge bg-primary rounded-pill">KSh 28,400</span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <span class="text-white fw-bold">JD</span>
                        </div>
                        <div>
                            <h6 class="mb-1">John Doe</h6>
                            <small class="text-muted">15 orders</small>
                        </div>
                    </div>
                    <span class="badge bg-primary rounded-pill">KSh 18,500</span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <span class="text-white fw-bold">JS</span>
                        </div>
                        <div>
                            <h6 class="mb-1">Jane Smith</h6>
                            <small class="text-muted">8 orders</small>
                        </div>
                    </div>
                    <span class="badge bg-primary rounded-pill">KSh 12,800</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="user-card">
            <h5 class="mb-3">Customer Demographics</h5>
            <div style="height: 200px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <div class="text-center">
                    <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Customer demographics chart</p>
                    <small class="text-muted">Age, location, gender distribution</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
