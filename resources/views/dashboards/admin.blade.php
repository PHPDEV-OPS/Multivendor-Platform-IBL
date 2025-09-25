@extends('layouts.main')

@section('content')

<!-- Dashboard Header -->
<div class="dashboard_header_area admin">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard_header_content">
                    <div class="breadcrumb_area">
                        <h1 class="page_title">Admin Dashboard</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Admin Dashboard</li>
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
                                <div class="avatar_placeholder admin">{{ $user->initials }}</div>
                            @endif
                        </div>
                        <div class="user_info">
                            <h4 class="user_name">{{ $user->name }}</h4>
                            <p class="user_email">{{ $user->email }}</p>
                            <span class="user_role_badge admin">Administrator</span>
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
                                    <i class="ti-user"></i>
                                    <span>User Management</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-package"></i>
                                    <span>Product Management</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-shopping-cart"></i>
                                    <span>Order Management</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-bar-chart"></i>
                                    <span>Analytics</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-settings"></i>
                                    <span>System Settings</span>
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
                        <div class="welcome_card admin">
                            <div class="welcome_content">
                                <h2 class="welcome_title">Welcome back, {{ explode(' ', $user->name)[0] }}!</h2>
                                <p class="welcome_text">Here's your system overview and recent activities.</p>
                            </div>
                            <div class="welcome_actions">
                                <a href="#" class="btn btn_primary">System Settings</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="stats_section">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="stats_card">
                                    <div class="stats_icon users">
                                        <i class="ti-user"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">{{ number_format($stats['total_users']) }}</h3>
                                        <p class="stats_label">Total Users</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="stats_card">
                                    <div class="stats_icon orders">
                                        <i class="ti-shopping-cart"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">{{ number_format($stats['total_orders']) }}</h3>
                                        <p class="stats_label">Total Orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="stats_card">
                                    <div class="stats_icon products">
                                        <i class="ti-package"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">{{ number_format($stats['total_products']) }}</h3>
                                        <p class="stats_label">Total Products</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="stats_card">
                                    <div class="stats_icon revenue">
                                        <i class="ti-money"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">KSh {{ number_format($stats['total_revenue']) }}</h3>
                                        <p class="stats_label">Total Revenue</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Secondary Stats -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="stats_card secondary">
                                    <div class="stats_icon pending">
                                        <i class="ti-clock"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">{{ $stats['pending_orders'] }}</h3>
                                        <p class="stats_label">Pending Orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="stats_card secondary">
                                    <div class="stats_icon vendors">
                                        <i class="ti-briefcase"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">{{ $stats['active_vendors'] }}</h3>
                                        <p class="stats_label">Active Vendors</p>
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
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($recentOrders as $order)
                                                    <tr>
                                                        <td>#{{ $order->id }}</td>
                                                        <td>{{ $order->customer_name }}</td>
                                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                        <td><span class="status_badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                                        <td>KSh {{ number_format($order->total, 2) }}</td>
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
                                            <p class="empty_text">No orders have been placed recently.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="recent_users_section">
                                <div class="section_header">
                                    <h3 class="section_title">Recent Users</h3>
                                    <a href="#" class="view_all_link">View All</a>
                                </div>
                                <div class="users_list">
                                    @if(count($recentUsers) > 0)
                                        @foreach($recentUsers as $recentUser)
                                        <div class="user_item">
                                            <div class="user_avatar_sm">
                                                @if($recentUser->avatar)
                                                    <img src="{{ asset('storage/' . $recentUser->avatar) }}" alt="{{ $recentUser->name }}">
                                                @else
                                                    <div class="avatar_placeholder_sm">{{ $recentUser->initials }}</div>
                                                @endif
                                            </div>
                                            <div class="user_details">
                                                <h5 class="user_name_sm">{{ $recentUser->name }}</h5>
                                                <p class="user_role_sm">{{ ucfirst($recentUser->role) }}</p>
                                                <span class="user_date">{{ $recentUser->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="empty_state_sm">
                                            <p>No recent user registrations</p>
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
                                        <p class="action_text">Add new products to the catalog</p>
                                        <a href="#" class="action_link">Add Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="action_card">
                                    <div class="action_icon">
                                        <i class="ti-user"></i>
                                    </div>
                                    <div class="action_content">
                                        <h4 class="action_title">Manage Users</h4>
                                        <p class="action_text">View and manage user accounts</p>
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
                                        <h4 class="action_title">View Reports</h4>
                                        <p class="action_text">Check sales and analytics reports</p>
                                        <a href="#" class="action_link">View Reports</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="action_card">
                                    <div class="action_icon">
                                        <i class="ti-settings"></i>
                                    </div>
                                    <div class="action_content">
                                        <h4 class="action_title">System Settings</h4>
                                        <p class="action_text">Configure system preferences</p>
                                        <a href="#" class="action_link">Configure</a>
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
    /* Admin Dashboard Specific Styles */
    .dashboard_header_area.admin {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .welcome_card.admin {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
    }
    
    .avatar_placeholder.admin {
        background: #667eea;
    }
    
    .user_role_badge.admin {
        background: #667eea;
        color: white;
    }
    
    /* Stats Icons */
    .stats_icon.users {
        background: #2196f3;
    }
    
    .stats_icon.orders {
        background: var(--base_color);
    }
    
    .stats_icon.products {
        background: #4caf50;
    }
    
    .stats_icon.revenue {
        background: #ff9800;
    }
    
    .stats_icon.vendors {
        background: #9c27b0;
    }
    
    .stats_card.secondary {
        border-left: 4px solid var(--base_color);
    }
    
    /* Recent Users Section */
    .recent_users_section {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 25px;
        height: fit-content;
    }
    
    .users_list {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .user_item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid var(--border_color);
    }
    
    .user_item:last-child {
        border-bottom: none;
    }
    
    .user_avatar_sm {
        margin-right: 15px;
    }
    
    .user_avatar_sm img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .avatar_placeholder_sm {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--base_color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
    }
    
    .user_name_sm {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 2px;
        color: var(--text_color);
    }
    
    .user_role_sm {
        font-size: 12px;
        color: #666;
        margin-bottom: 2px;
        text-transform: capitalize;
    }
    
    .user_date {
        font-size: 11px;
        color: #999;
    }
    
    .empty_state_sm {
        text-align: center;
        padding: 30px 10px;
        color: #666;
    }
    
    /* Orders Table */
    .orders_table {
        margin-bottom: 0;
    }
    
    .orders_table th {
        background: var(--feature_color);
        border: none;
        font-weight: 600;
        color: var(--text_color);
        padding: 15px 10px;
        font-size: 14px;
    }
    
    .orders_table td {
        padding: 15px 10px;
        border-top: 1px solid var(--border_color);
        font-size: 14px;
    }
    
    .status_badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .status_badge.pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .status_badge.processing {
        background: #cce5ff;
        color: #004085;
    }
    
    .status_badge.completed {
        background: #d4edda;
        color: #155724;
    }
    
    .status_badge.cancelled {
        background: #f8d7da;
        color: #721c24;
    }
    
    .btn_sm {
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 4px;
    }
    
    .btn_outline {
        background: transparent;
        border: 1px solid var(--base_color);
        color: var(--base_color);
        text-decoration: none;
    }
    
    .btn_outline:hover {
        background: var(--base_color);
        color: white;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .stats_card.secondary {
            margin-bottom: 15px;
        }
        
        .recent_users_section {
            margin-top: 30px;
        }
        
        .orders_table_wrapper {
            overflow-x: auto;
        }
        
        .orders_table {
            min-width: 600px;
        }
    }
</style>
@endpush
