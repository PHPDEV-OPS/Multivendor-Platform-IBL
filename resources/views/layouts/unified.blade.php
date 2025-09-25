<!doctype html>
<html class="no-js" lang="zxx">

@include('visitors.includes.header')

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

    <!-- Main Content Area -->
    <div class="main-content-wrapper">
        @auth
            <!-- Mobile Sidebar Toggle -->
            <button class="sidebar-toggle d-md-none">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Sidebar Overlay for Mobile -->
            <div class="sidebar-overlay"></div>

            <!-- Logged in user layout with sidebar -->
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-md-3 col-lg-2 px-0 dashboard-sidebar">
                        <div class="sidebar-content">
                            <div class="text-center mb-4">
                                <img src="{{ asset('uploads/settings/67b5a3c7831f0.png') }}" alt="TUNUNUE" height="50">
                                <h5 class="mt-2 mb-0">
                                    @if(auth()->user()->hasRole('admin'))
                                        Admin Dashboard
                                    @elseif(auth()->user()->hasRole('vendor'))
                                        Vendor Dashboard
                                    @else
                                        User Dashboard
                                    @endif
                                </h5>
                            </div>

                            <nav class="nav flex-column">
                                @if(auth()->user()->hasRole('admin'))
                                    <!-- Admin Navigation -->
                                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                                        <i class="fas fa-box"></i> Products
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                        <i class="fas fa-shopping-cart"></i> Orders
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}" href="{{ route('admin.customers') }}">
                                        <i class="fas fa-users"></i> Customers
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.content*') ? 'active' : '' }}" href="{{ route('admin.content.index') }}">
                                        <i class="fas fa-file-alt"></i> Content
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}" href="{{ route('admin.analytics') }}">
                                        <i class="fas fa-chart-line"></i> Analytics
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.finance') ? 'active' : '' }}" href="{{ route('admin.finance') }}">
                                        <i class="fas fa-dollar-sign"></i> Finance
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}">
                                        <i class="fas fa-cog"></i> Settings
                                    </a>
                                @elseif(auth()->user()->hasRole('vendor'))
                                    <!-- Vendor Navigation -->
                                    <a class="nav-link {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}" href="{{ route('vendor.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('vendor.products*') ? 'active' : '' }}" href="{{ route('vendor.products') }}">
                                        <i class="fas fa-box"></i> Products
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('vendor.orders*') ? 'active' : '' }}" href="{{ route('vendor.orders') }}">
                                        <i class="fas fa-shopping-cart"></i> Orders
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('vendor.analytics') ? 'active' : '' }}" href="{{ route('vendor.analytics') }}">
                                        <i class="fas fa-chart-line"></i> Analytics
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('vendor.finance') ? 'active' : '' }}" href="{{ route('vendor.finance') }}">
                                        <i class="fas fa-dollar-sign"></i> Finance
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('vendor.profile') ? 'active' : '' }}" href="{{ route('vendor.profile') }}">
                                        <i class="fas fa-user"></i> Profile
                                    </a>
                                @else
                                    <!-- Regular User Navigation -->
                                    <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('user.orders*') ? 'active' : '' }}" href="{{ route('user.orders') }}">
                                        <i class="fas fa-shopping-cart"></i> My Orders
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                                        <i class="fas fa-user"></i> Profile
                                    </a>
                                @endif

                                <!-- Common Navigation -->
                                <hr class="my-3">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="fas fa-home"></i> Back to Store
                                </a>
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </nav>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-md-9 col-lg-10 dashboard-main-content">
                        <!-- Dashboard Header -->
                        <div class="dashboard-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                                    <p class="text-muted mb-0">@yield('page-subtitle', 'Welcome to your dashboard')</p>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                            <li><a class="dropdown-item" href="{{ route('home') }}">Back to Store</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    Logout
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Page Content -->
                        <div class="dashboard-content">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Guest user - full width content -->
            @yield('content')
        @endauth
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

    <style>
        /* Unified Layout Styles */
        .main-content-wrapper {
            min-height: calc(100vh - 200px); /* Adjust based on header/footer height */
        }

        .dashboard-sidebar {
            background: var(--navbar_color);
            min-height: calc(100vh - 200px);
            border-right: 1px solid var(--border_color);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-content {
            padding: 20px;
        }

        .dashboard-sidebar .nav-link {
            color: var(--text_color);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 10px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .dashboard-sidebar .nav-link:hover,
        .dashboard-sidebar .nav-link.active {
            background: var(--base_color);
            color: white;
        }

        .dashboard-sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        .dashboard-main-content {
            background: var(--background_color);
            min-height: calc(100vh - 200px);
        }

        .dashboard-header {
            background: white;
            border-bottom: 1px solid var(--border_color);
            padding: 20px 30px;
            margin-bottom: 20px;
        }

        .dashboard-content {
            padding: 0 30px 30px;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 25px;
        }

        .dashboard-stats-card {
            background: linear-gradient(135deg, var(--base_color), #ff8f40);
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .dashboard-stats-card h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .dashboard-stats-card p {
            opacity: 0.9;
            margin: 0;
        }

        .dashboard-btn {
            background: var(--base_color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .dashboard-btn:hover {
            background: #e55a1a;
            color: white;
            text-decoration: none;
        }

        .dashboard-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .dashboard-table th {
            background: var(--feature_color);
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .dashboard-table td {
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .dashboard-sidebar {
                position: fixed;
                left: -100%;
                z-index: 1000;
                transition: left 0.3s ease;
                width: 280px;
            }

            .dashboard-sidebar.show {
                left: 0;
            }

            .dashboard-main-content {
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
    </style>

    <script>
        // Mobile sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.dashboard-sidebar');
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
            const sidebarLinks = document.querySelectorAll('.dashboard-sidebar .nav-link');
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
