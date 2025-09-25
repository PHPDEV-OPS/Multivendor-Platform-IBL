@extends('layouts.main')

@section('content')

<!-- Dashboard Header -->
<div class="dashboard_header_area vendor">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard_header_content">
                    <div class="breadcrumb_area">
                        <h1 class="page_title">Vendor Dashboard</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Vendor Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Content -->
<div class="dashboard_content_area">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4">
                <div class="dashboard_sidebar">
                    <div class="user_profile_card">
                        <div class="user_avatar">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="avatar_img">
                            @else
                                <div class="avatar_placeholder vendor">{{ $user->initials }}</div>
                            @endif
                        </div>
                        <div class="user_info">
                            <h4 class="user_name">{{ $user->name }}</h4>
                            <p class="user_email">{{ $user->email }}</p>
                            <span class="user_role_badge vendor">Vendor</span>
                        </div>
                    </div>
                    
                    <div class="dashboard_menu">
                        <ul class="menu_list">
                            <li class="menu_item active">
                                <a href="{{ route('dashboard') }}" class="menu_link">
                                    <i class="ti-dashboard"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-package"></i>
                                    <span>My Products</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-shopping-cart"></i>
                                    <span>Orders</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-bar-chart"></i>
                                    <span>Sales Analytics</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-wallet"></i>
                                    <span>Earnings</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-user"></i>
                                    <span>Profile Settings</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <form method="POST" action="{{ route('logout') }}" class="logout_form">
                                    @csrf
                                    <button type="submit" class="menu_link logout_btn">
                                        <i class="ti-power-off"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9 col-md-8">
                <div class="dashboard_main_content">
                    <!-- Welcome Section -->
                    <div class="welcome_section">
                        <div class="welcome_card vendor">
                            <div class="welcome_content">
                                <h2 class="welcome_title">Welcome back, {{ explode(' ', $user->name)[0] }}!</h2>
                                <p class="welcome_text">Manage your products, track sales, and grow your business.</p>
                            </div>
                            <div class="welcome_actions">
                                <a href="#" class="btn btn_primary">Add New Product</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="stats_section">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="stats_card">
                                    <div class="stats_icon products">
                                        <i class="ti-package"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">{{ $stats['total_products'] }}</h3>
                                        <p class="stats_label">Total Products</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="stats_card">
                                    <div class="stats_icon sales">
                                        <i class="ti-money"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">KSh {{ number_format($stats['total_sales']) }}</h3>
                                        <p class="stats_label">Total Sales</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="stats_card">
                                    <div class="stats_icon pending">
                                        <i class="ti-clock"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">{{ $stats['pending_orders'] }}</h3>
                                        <p class="stats_label">Pending Orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="stats_card">
                                    <div class="stats_icon completed">
                                        <i class="ti-check"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">{{ $stats['completed_orders'] }}</h3>
                                        <p class="stats_label">Completed Orders</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Secondary Stats -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="stats_card secondary">
                                    <div class="stats_icon views">
                                        <i class="ti-eye"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">{{ number_format($stats['product_views']) }}</h3>
                                        <p class="stats_label">Product Views</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="stats_card secondary">
                                    <div class="stats_icon revenue">
                                        <i class="ti-trending-up"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">KSh {{ number_format($stats['monthly_revenue']) }}</h3>
                                        <p class="stats_label">This Month Revenue</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Activities -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="recent_orders_section">
                                <div class="section_header">
                                    <h3 class="section_title">Recent Orders</h3>
                                    <a href="#" class="view_all_link">View All Orders</a>
                                </div>
                                <div class="orders_table_wrapper">
                                    @if(count($recentOrders) > 0)
                                        <div class="table-responsive">
                                            <table class="table orders_table">
                                                <thead>
                                                    <tr>
                                                        <th>Order ID</th>
                                                        <th>Customer</th>
                                                        <th>Product</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Amount</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($recentOrders as $order)
                                                    <tr>
                                                        <td>#{{ $order->id }}</td>
                                                        <td>{{ $order->customer_name }}</td>
                                                        <td>{{ $order->product_name }}</td>
                                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                        <td><span class="status_badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                                        <td>KSh {{ number_format($order->amount, 2) }}</td>
                                                        <td>
                                                            <a href="#" class="btn btn_sm btn_outline">View</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="empty_state">
                                            <div class="empty_icon">
                                                <i class="ti-shopping-cart"></i>
                                            </div>
                                            <h4 class="empty_title">No Recent Orders</h4>
                                            <p class="empty_text">You haven't received any orders yet. Start promoting your products to get more sales.</p>
                                            <a href="#" class="btn btn_primary">Add Products</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="top_products_section">
                                <div class="section_header">
                                    <h3 class="section_title">Top Products</h3>
                                    <a href="#" class="view_all_link">View All</a>
                                </div>
                                <div class="products_list">
                                    @if(count($topProducts) > 0)
                                        @foreach($topProducts as $product)
                                        <div class="product_item">
                                            <div class="product_image">
                                                <img src="{{ $product->image }}" alt="{{ $product->name }}">
                                            </div>
                                            <div class="product_details">
                                                <h5 class="product_name">{{ $product->name }}</h5>
                                                <p class="product_price">KSh {{ number_format($product->price, 2) }}</p>
                                                <span class="product_sales">{{ $product->sales_count }} sales</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="empty_state_sm">
                                            <div class="empty_icon_sm">
                                                <i class="ti-package"></i>
                                            </div>
                                            <p>No products added yet</p>
                                            <a href="#" class="btn btn_sm btn_primary">Add Product</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="quick_actions_section">
                        <div class="section_header">
                            <h3 class="section_title">Quick Actions</h3>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="action_card">
                                    <div class="action_icon">
                                        <i class="ti-plus"></i>
                                    </div>
                                    <div class="action_content">
                                        <h4 class="action_title">Add Product</h4>
                                        <p class="action_text">Add new products to your inventory</p>
                                        <a href="#" class="action_link">Add Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="action_card">
                                    <div class="action_icon">
                                        <i class="ti-package"></i>
                                    </div>
                                    <div class="action_content">
                                        <h4 class="action_title">Manage Inventory</h4>
                                        <p class="action_text">Update stock and product details</p>
                                        <a href="#" class="action_link">Manage</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="action_card">
                                    <div class="action_icon">
                                        <i class="ti-bar-chart"></i>
                                    </div>
                                    <div class="action_content">
                                        <h4 class="action_title">View Analytics</h4>
                                        <p class="action_text">Check your sales performance</p>
                                        <a href="#" class="action_link">View Reports</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="action_card">
                                    <div class="action_icon">
                                        <i class="ti-wallet"></i>
                                    </div>
                                    <div class="action_content">
                                        <h4 class="action_title">Earnings</h4>
                                        <p class="action_text">View your earnings and payouts</p>
                                        <a href="#" class="action_link">View Earnings</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Vendor Dashboard Specific Styles */
    .dashboard_header_area.vendor {
        background: linear-gradient(135deg, #4caf50 0%, #2e7d32 100%);
    }
    
    .welcome_card.vendor {
        background: linear-gradient(135deg, #e8f5e8 0%, #f1f8e9 100%);
    }
    
    .avatar_placeholder.vendor {
        background: #4caf50;
    }
    
    .user_role_badge.vendor {
        background: #4caf50;
        color: white;
    }
    
    /* Stats Icons */
    .stats_icon.products {
        background: #4caf50;
    }
    
    .stats_icon.sales {
        background: #ff9800;
    }
    
    .stats_icon.completed {
        background: var(--success_color);
    }
    
    .stats_icon.views {
        background: #2196f3;
    }
    
    .stats_icon.revenue {
        background: #9c27b0;
    }
    
    /* Top Products Section */
    .top_products_section {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 25px;
        height: fit-content;
    }
    
    .products_list {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .product_item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid var(--border_color);
    }
    
    .product_item:last-child {
        border-bottom: none;
    }
    
    .product_image {
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .product_image img {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
    }
    
    .product_name {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 4px;
        color: var(--text_color);
        line-height: 1.3;
    }
    
    .product_price {
        font-size: 13px;
        color: var(--base_color);
        font-weight: 600;
        margin-bottom: 2px;
    }
    
    .product_sales {
        font-size: 11px;
        color: #666;
    }
    
    .empty_state_sm {
        text-align: center;
        padding: 40px 10px;
    }
    
    .empty_icon_sm {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--feature_color);
        color: #999;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 24px;
    }
    
    .empty_state_sm p {
        color: #666;
        margin-bottom: 15px;
    }
    
    /* Enhanced Orders Table for Vendor */
    .orders_table th:nth-child(3),
    .orders_table td:nth-child(3) {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    /* Vendor specific button styles */
    .btn_primary {
        background: #4caf50;
        border-color: #4caf50;
    }
    
    .btn_primary:hover {
        background: #45a049;
        border-color: #45a049;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .top_products_section {
            margin-top: 30px;
        }
        
        .product_item {
            padding: 10px 0;
        }
        
        .product_image img {
            width: 40px;
            height: 40px;
        }
        
        .product_name {
            font-size: 13px;
        }
        
        .orders_table th:nth-child(3),
        .orders_table td:nth-child(3) {
            max-width: 100px;
        }
    }
</style>
@endpush
