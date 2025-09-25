<!doctype html>
<html class="no-js" lang="zxx">

@include('visitors.includes.header')
<meta name="csrf-token" content="{{ csrf_token() }}">

<body>
    @include('visitors.includes.preloader')

    <!-- promotion_bar_wrapper::start  -->
    @include('visitors.includes.promotionbar')
    <!-- promotion_bar_wrapper::end  -->

    <!-- HEADER::START -->
    <input type="hidden" id="url" value="{{ url('/') }}">
    <input type="hidden" id="just_url" value="">
    @include('visitors.includes.top-nav')
    <!--/ HEADER::END -->

    <style>
        :root {
            --background_color: #fafdff;
            --base_color: #ff6f20;
            --text_color: #121111;
            --feature_color: #f4f7f9;
            --footer_background_color: #121111;
            --footer_text_color: #f8f2f2;
            --navbar_color: #f4f7f9;
            --menu_color: #f4f7f9;
            --border_color: #e4e7e9;
            --success_color: #4bcf90;
            --warning_color: #e09079;
            --danger_color: #ff6d68;
            --base_color_10: #ff6f201a;
            --base_color_20: #ff6f2033;
            --base_color_30: #ff6f204d;
            --base_color_60: #ff6f2099;
        }

        /* Main Content Wrapper */
        .main-content-wrapper {
            min-height: calc(100vh - 200px); /* Adjust based on header/footer height */
        }

        .admin-sidebar {
            background: var(--navbar_color);
            min-height: calc(100vh - 200px);
            border-right: 1px solid var(--border_color);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .admin-sidebar .nav-link {
            color: var(--text_color);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 10px;
            transition: all 0.3s ease;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            background: var(--base_color);
            color: white;
        }

        .admin-sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        .admin-main-content {
            background: var(--background_color);
            min-height: calc(100vh - 200px);
        }

        .admin-header {
            background: white;
            border-bottom: 1px solid var(--border_color);
            padding: 15px 30px;
        }

        .admin-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 25px;
        }

        .admin-stats-card {
            background: linear-gradient(135deg, var(--base_color), #ff8f40);
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .admin-stats-card h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .admin-stats-card p {
            opacity: 0.9;
            margin: 0;
        }

        .admin-btn {
            background: var(--base_color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .admin-btn:hover {
            background: #e55a1a;
            color: white;
            text-decoration: none;
        }

        .admin-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .admin-table th {
            background: var(--feature_color);
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .admin-table td {
            padding: 15px;
            border-top: 1px solid var(--border_color);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-active {
            background: var(--success_color);
            color: white;
        }

        .status-pending {
            background: var(--warning_color);
            color: white;
        }

        .status-inactive {
            background: var(--danger_color);
            color: white;
        }

        .btn-success {
            background: var(--success_color);
            border-color: var(--success_color);
        }

        .btn-success:hover {
            background: #3db87a;
            border-color: #3db87a;
        }

        .btn-warning {
            background: var(--warning_color);
            border-color: var(--warning_color);
            color: white;
        }

        .btn-warning:hover {
            background: #d17a5a;
            border-color: #d17a5a;
            color: white;
        }

        .btn-danger {
            background: var(--danger_color);
            border-color: var(--danger_color);
        }

        .btn-danger:hover {
            background: #ff5a5a;
            border-color: #ff5a5a;
        }

        .nav-section-header {
            padding: 0 20px;
            margin-top: 15px;
            margin-bottom: 8px;
        }

        .nav-section-header small {
            font-size: 10px;
            letter-spacing: 1px;
            opacity: 0.7;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .admin-sidebar {
                position: fixed;
                left: -100%;
                z-index: 1000;
                transition: left 0.3s ease;
                width: 280px;
            }

            .admin-sidebar.show {
                left: 0;
            }

            .admin-main-content {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .sidebar-toggle {
                display: none;
            }
        }

        /* Sidebar toggle button for mobile */
        .sidebar-toggle {
            position: fixed;
            top: 100px;
            left: 20px;
            z-index: 1001;
            background: var(--base_color);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* Admin Pagination Styles */
        .pagination {
            margin: 0;
        }

        .pagination .page-link {
            color: var(--base_color);
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
            margin: 0 2px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            color: #fff;
            background-color: var(--base_color);
            border-color: var(--base_color);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--base_color);
            border-color: var(--base_color);
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }

        .pagination-sm .page-link {
            padding: 0.375rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <!-- Main Content Area -->
    <div class="main-content-wrapper">
        <!-- Mobile Sidebar Toggle -->
        <button class="sidebar-toggle d-md-none">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay"></div>

        <div class="container-fluid">
            <div class="row">
                <!-- Admin Sidebar -->
                <div class="col-md-3 col-lg-2 px-0 admin-sidebar">
                <div class="p-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('uploads/settings/67b5a3c7831f0.png') }}" alt="TUNUNUE" height="50">
                        <h5 class="mt-2 mb-0">Admin Dashboard</h5>
                    </div>

                    <nav class="nav flex-column">
                        <!-- Main Dashboard -->
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>

                        <!-- E-commerce Management -->
                        <div class="nav-section-header mt-3 mb-2">
                            <small class="text-muted fw-bold text-uppercase">E-commerce</small>
                        </div>
                        <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                            <i class="fas fa-box"></i> Products
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                            <i class="fas fa-shopping-cart"></i> Orders
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}" href="{{ route('admin.customers') }}">
                            <i class="fas fa-users"></i> Customers
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.merchant-applications*') ? 'active' : '' }}" href="{{ route('admin.merchant-applications.index') }}">
                            <i class="fas fa-store-alt"></i> Merchant Applications
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.promotions*') ? 'active' : '' }}" href="{{ route('admin.promotions.index') }}">
                            <i class="fas fa-gift"></i> Promotions
                        </a>

                        <a class="nav-link {{ request()->routeIs('admin.shipping') ? 'active' : '' }}" href="{{ route('admin.shipping') }}">
                            <i class="fas fa-shipping-fast"></i> Shipping
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.store') ? 'active' : '' }}" href="{{ route('admin.store') }}">
                            <i class="fas fa-store"></i> Store
                        </a>

                        <!-- Content & Analytics -->
                        <div class="nav-section-header mt-3 mb-2">
                            <small class="text-muted fw-bold text-uppercase">Content & Analytics</small>
                        </div>
                        <a class="nav-link {{ request()->routeIs('admin.content*') ? 'active' : '' }}" href="{{ route('admin.content.index') }}">
                            <i class="fas fa-file-alt"></i> Content Management
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}" href="{{ route('admin.analytics') }}">
                            <i class="fas fa-chart-line"></i> Analytics
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>

                        <!-- Finance -->
                        <div class="nav-section-header mt-3 mb-2">
                            <small class="text-muted fw-bold text-uppercase">Finance</small>
                        </div>
                        <a class="nav-link {{ request()->routeIs('admin.finance') ? 'active' : '' }}" href="{{ route('admin.finance') }}">
                            <i class="fas fa-dollar-sign"></i> Finance
                        </a>

                        <!-- System -->
                        <div class="nav-section-header mt-3 mb-2">
                            <small class="text-muted fw-bold text-uppercase">System</small>
                        </div>
                        <a class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}" href="{{ route('admin.profile') }}">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.support') ? 'active' : '' }}" href="{{ route('admin.support') }}">
                            <i class="fas fa-headset"></i> Support
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 admin-main-content">
                <!-- Header -->
                <div class="admin-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                        <p class="text-muted mb-0">@yield('page-subtitle', 'Welcome to your admin dashboard')</p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('home') }}" class="admin-btn">
                            <i class="fas fa-external-link-alt"></i> View Store
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> Admin
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.settings') }}">Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('home') }}">Back to Store</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <div class="p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    </div>

    @include('visitors.includes.footer')

    <!-- checkout_login_form:start -->
    @include('visitors.includes.checkoutloginform')
    <!-- checkout_login_form:end  -->

    <!-- Cart and other modals -->
    <div id="cart_data_show_div">
        <div class="shoping_wrapper d-none">
            <div class="shoping_cart">
                <div class="shoping_cart_inner">
                    <div class="cart_header d-flex justify-content-between">
                        <div class="cart_header_text">
                            <h4>Shopping Cart</h4>
                            <p>0 Item's selected</p>
                        </div>
                        <div class="chart_close">
                            <i class="ti-close"></i>
                        </div>
                    </div>
                </div>
                <div class="shoping_cart_subtotal d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Subtotal</h4>
                    <span>KSh 0.00</span>
                </div>
                <div class="view_checkout_btn d-flex justify-content-end mb_30 flex-column gap_10">
                    <a href="{{ route('cart') }}" class="amaz_primary_btn style2 text-uppercase">View Shopping Cart</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to top button -->
    <div id="back-top" style="display: none;">
        <a title="Go to Top" href="#"><i class="fas fa-chevron-up"></i></a>
    </div>

    <!--ALL JS SCRIPTS -->
    @include('visitors.includes.scripts')

    @stack('scripts')

    <script>
        // Mobile sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.admin-sidebar');
            const overlay = document.querySelector('.sidebar-overlay');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    if (overlay) {
                        overlay.classList.toggle('show');
                    }
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }

            // Close sidebar when clicking on a link (mobile)
            const sidebarLinks = document.querySelectorAll('.admin-sidebar .nav-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('show');
                        if (overlay) {
                            overlay.classList.remove('show');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
