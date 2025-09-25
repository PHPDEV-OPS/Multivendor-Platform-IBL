<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>User Dashboard - TUNUNUE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/settings/67b5a3c7831f0.png') }}">
    <link rel="icon" href="{{ asset('uploads/settings/67b5a3c7831f0.png') }}" type="image/png">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('frontend/amazy/compile_css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/amazy/css/page_css/marchant.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

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

        .user-sidebar {
            background: var(--navbar_color);
            min-height: 100vh;
            border-right: 1px solid var(--border_color);
        }

        .user-sidebar .nav-link {
            color: var(--text_color);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 10px;
            transition: all 0.3s ease;
        }

        .user-sidebar .nav-link:hover,
        .user-sidebar .nav-link.active {
            background: var(--base_color);
            color: white;
        }

        .user-sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }

        .user-main-content {
            background: var(--background_color);
            min-height: 100vh;
        }

        .user-header {
            background: white;
            border-bottom: 1px solid var(--border_color);
            padding: 15px 30px;
        }

        .user-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 25px;
        }

        .user-stats-card {
            background: linear-gradient(135deg, var(--base_color), #ff8f40);
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .user-stats-card h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .user-stats-card p {
            opacity: 0.9;
            margin: 0;
        }

        .user-btn {
            background: var(--base_color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .user-btn:hover {
            background: #e55a1a;
            color: white;
            text-decoration: none;
        }

        .user-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .user-table th {
            background: var(--feature_color);
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .user-table td {
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
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 user-sidebar">
                <div class="p-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('uploads/settings/67b5a3c7831f0.png') }}" alt="TUNUNUE" height="50">
                        <h5 class="mt-2 mb-0">User Dashboard</h5>
                    </div>

                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('user.products*') ? 'active' : '' }}" href="{{ route('user.products') }}">
                            <i class="fas fa-box"></i> Products
                        </a>
                        <a class="nav-link {{ request()->routeIs('user.orders*') ? 'active' : '' }}" href="{{ route('user.orders') }}">
                            <i class="fas fa-shopping-cart"></i> Orders
                        </a>
                        <a class="nav-link {{ request()->routeIs('user.analytics') ? 'active' : '' }}" href="{{ route('user.analytics') }}">
                            <i class="fas fa-chart-line"></i> Analytics
                        </a>
                        <a class="nav-link {{ request()->routeIs('user.reports') ? 'active' : '' }}" href="{{ route('user.reports') }}">
                            <i class="fas fa-file-alt"></i> Reports
                        </a>
                        <a class="nav-link {{ request()->routeIs('user.customers') ? 'active' : '' }}" href="{{ route('user.customers') }}">
                            <i class="fas fa-users"></i> Customers
                        </a>
                        <a class="nav-link {{ request()->routeIs('user.promotions') ? 'active' : '' }}" href="{{ route('user.promotions') }}">
                            <i class="fas fa-gift"></i> Promotions
                        </a>
                        <a class="nav-link {{ request()->routeIs('user.shipping') ? 'active' : '' }}" href="{{ route('user.shipping') }}">
                            <i class="fas fa-shipping-fast"></i> Shipping
                        </a>
                        <a class="nav-link {{ request()->routeIs('user.finance') ? 'active' : '' }}" href="{{ route('user.finance') }}">
                            <i class="fas fa-dollar-sign"></i> Finance
                        </a>
                        <a class="nav-link {{ request()->routeIs('user.store') ? 'active' : '' }}" href="{{ route('user.store') }}">
                            <i class="fas fa-store"></i> Store
                        </a>
                        <a class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <a class="nav-link {{ request()->routeIs('user.support') ? 'active' : '' }}" href="{{ route('user.support') }}">
                            <i class="fas fa-headset"></i> Support
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 user-main-content">
                <!-- Header -->
                <div class="user-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                        <p class="text-muted mb-0">@yield('page-subtitle', 'Welcome to your user dashboard')</p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('home') }}" class="user-btn">
                            <i class="fas fa-external-link-alt"></i> View Store
                        </a>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> User
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a></li>
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

    <!-- JavaScript Files -->
    <script src="{{ asset('frontend/amazy/compile_js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    @stack('scripts')
</body>
</html>
