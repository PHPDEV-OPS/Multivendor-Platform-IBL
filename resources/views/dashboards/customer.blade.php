@extends('layouts.main')

@section('content')

<!-- Dashboard Header -->
<div class="dashboard_header_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="dashboard_header_content">
                    <div class="breadcrumb_area">
                        <h1 class="page_title">My Dashboard</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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
                                <div class="avatar_placeholder">{{ $user->initials }}</div>
                            @endif
                        </div>
                        <div class="user_info">
                            <h4 class="user_name">{{ $user->name }}</h4>
                            <p class="user_email">{{ $user->email }}</p>
                            <span class="user_role_badge customer">Customer</span>
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
                                    <i class="ti-shopping-cart"></i>
                                    <span>My Orders</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-heart"></i>
                                    <span>Wishlist</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-location-pin"></i>
                                    <span>Addresses</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-user"></i>
                                    <span>Profile Settings</span>
                                </a>
                            </li>
                            <li class="menu_item">
                                <a href="#" class="menu_link">
                                    <i class="ti-lock"></i>
                                    <span>Change Password</span>
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
                        <div class="welcome_card">
                            <div class="welcome_content">
                                <h2 class="welcome_title">Welcome back, {{ explode(' ', $user->name)[0] }}!</h2>
                                <p class="welcome_text">Here's what's happening with your account today.</p>
                            </div>
                            <div class="welcome_actions">
                                <a href="{{ url('/') }}" class="btn btn_primary">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Stats Cards -->
                    <div class="stats_section">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="stats_card">
                                    <div class="stats_icon">
                                        <i class="ti-shopping-cart"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">{{ $stats['total_orders'] }}</h3>
                                        <p class="stats_label">Total Orders</p>
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
                                    <div class="stats_icon success">
                                        <i class="ti-check"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">{{ $stats['completed_orders'] }}</h3>
                                        <p class="stats_label">Completed Orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="stats_card">
                                    <div class="stats_icon wishlist">
                                        <i class="ti-heart"></i>
                                    </div>
                                    <div class="stats_content">
                                        <h3 class="stats_number">{{ $stats['wishlist_items'] }}</h3>
                                        <p class="stats_label">Wishlist Items</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Orders -->
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
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td><span class="status_badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                                <td>KSh {{ number_format($order->total, 2) }}</td>
                                                <td>
                                                    <a href="#" class="btn btn_sm btn_outline">View Details</a>
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
                                    <h4 class="empty_title">No Orders Yet</h4>
                                    <p class="empty_text">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                                    <a href="{{ url('/') }}" class="btn btn_primary">Start Shopping</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="quick_actions_section">
                        <div class="section_header">
                            <h3 class="section_title">Quick Actions</h3>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="action_card">
                                    <div class="action_icon">
                                        <i class="ti-user"></i>
                                    </div>
                                    <div class="action_content">
                                        <h4 class="action_title">Update Profile</h4>
                                        <p class="action_text">Keep your personal information up to date</p>
                                        <a href="#" class="action_link">Update Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="action_card">
                                    <div class="action_icon">
                                        <i class="ti-location-pin"></i>
                                    </div>
                                    <div class="action_content">
                                        <h4 class="action_title">Manage Addresses</h4>
                                        <p class="action_text">Add or edit your delivery addresses</p>
                                        <a href="#" class="action_link">Manage</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="action_card">
                                    <div class="action_icon">
                                        <i class="ti-heart"></i>
                                    </div>
                                    <div class="action_content">
                                        <h4 class="action_title">View Wishlist</h4>
                                        <p class="action_text">Check out your saved favorite items</p>
                                        <a href="#" class="action_link">View Wishlist</a>
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
    /* Dashboard Styles */
    .dashboard_header_area {
        background: linear-gradient(135deg, var(--base_color) 0%, #e55a1a 100%);
        color: white;
        padding: 40px 0;
        margin-bottom: 30px;
    }
    
    .dashboard_header_area .page_title {
        color: white;
        margin-bottom: 10px;
        font-size: 2rem;
        font-weight: 600;
    }
    
    .dashboard_header_area .breadcrumb {
        background: transparent;
        margin-bottom: 0;
        padding: 0;
    }
    
    .dashboard_header_area .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }
    
    .dashboard_header_area .breadcrumb-item.active {
        color: white;
    }
    
    .dashboard_content_area {
        padding-bottom: 60px;
    }
    
    /* Sidebar Styles */
    .dashboard_sidebar {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 0;
        margin-bottom: 30px;
    }
    
    .user_profile_card {
        padding: 30px 20px;
        text-align: center;
        border-bottom: 1px solid var(--border_color);
    }
    
    .user_avatar {
        margin-bottom: 15px;
    }
    
    .avatar_img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--base_color);
    }
    
    .avatar_placeholder {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--base_color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 600;
        margin: 0 auto;
    }
    
    .user_name {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
        color: var(--text_color);
    }
    
    .user_email {
        color: #666;
        margin-bottom: 10px;
        font-size: 14px;
    }
    
    .user_role_badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .user_role_badge.customer {
        background: var(--success_color);
        color: white;
    }
    
    /* Menu Styles */
    .dashboard_menu {
        padding: 0;
    }
    
    .menu_list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .menu_item {
        border-bottom: 1px solid var(--border_color);
    }
    
    .menu_item:last-child {
        border-bottom: none;
    }
    
    .menu_link {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        color: var(--text_color);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .menu_link:hover,
    .menu_item.active .menu_link {
        background: var(--feature_color);
        color: var(--base_color);
    }
    
    .menu_link i {
        margin-right: 12px;
        font-size: 16px;
        width: 20px;
    }
    
    .logout_form {
        margin: 0;
    }
    
    .logout_btn {
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }
    
    /* Main Content Styles */
    .dashboard_main_content {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 30px;
    }
    
    /* Welcome Section */
    .welcome_section {
        margin-bottom: 30px;
    }
    
    .welcome_card {
        background: linear-gradient(135deg, var(--feature_color) 0%, #f0f3f5 100%);
        border-radius: 10px;
        padding: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .welcome_title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text_color);
    }
    
    .welcome_text {
        color: #666;
        margin-bottom: 0;
    }
    
    .btn_primary {
        background: var(--base_color);
        color: white;
        padding: 12px 24px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn_primary:hover {
        background: #e55a1a;
        transform: translateY(-2px);
    }
    
    /* Stats Section */
    .stats_section {
        margin-bottom: 40px;
    }
    
    .stats_card {
        background: white;
        border: 1px solid var(--border_color);
        border-radius: 10px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .stats_card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .stats_icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--base_color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 24px;
    }
    
    .stats_icon.pending {
        background: var(--warning_color);
    }
    
    .stats_icon.success {
        background: var(--success_color);
    }
    
    .stats_icon.wishlist {
        background: #e91e63;
    }
    
    .stats_number {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--text_color);
    }
    
    .stats_label {
        color: #666;
        font-size: 14px;
        margin-bottom: 0;
    }
    
    /* Section Headers */
    .section_header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border_color);
    }
    
    .section_title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 0;
        color: var(--text_color);
    }
    
    .view_all_link {
        color: var(--base_color);
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
    }
    
    .view_all_link:hover {
        text-decoration: underline;
    }
    
    /* Empty State */
    .empty_state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty_icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--feature_color);
        color: #999;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 32px;
    }
    
    .empty_title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text_color);
    }
    
    .empty_text {
        color: #666;
        margin-bottom: 25px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }
    
    /* Quick Actions */
    .quick_actions_section {
        margin-top: 40px;
    }
    
    .action_card {
        background: white;
        border: 1px solid var(--border_color);
        border-radius: 10px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
        margin-bottom: 20px;
        height: 100%;
    }
    
    .action_card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .action_icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--feature_color);
        color: var(--base_color);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 20px;
    }
    
    .action_title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text_color);
    }
    
    .action_text {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
    }
    
    .action_link {
        color: var(--base_color);
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
    }
    
    .action_link:hover {
        text-decoration: underline;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard_header_area .page_title {
            font-size: 1.5rem;
        }
        
        .welcome_card {
            flex-direction: column;
            text-align: center;
        }
        
        .welcome_actions {
            margin-top: 20px;
        }
        
        .dashboard_main_content {
            padding: 20px;
        }
        
        .stats_card {
            margin-bottom: 15px;
        }
    }
</style>
@endpush
