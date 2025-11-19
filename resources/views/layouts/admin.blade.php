<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Aresha Florist')</title>
    <meta name="description" content="Admin Panel Aresha Florist - Kelola produk dan kategori bunga">

    @include('layouts.partials.styles')

    <style>
        :root {
            --primary-color: #C2185B; /* magenta/rose gelap untuk elemen desain */
            --primary-light: #E91E63; /* pink gelap untuk aksen */
            --primary-dark: #8E24AA; /* magenta lebih gelap */
            --secondary-color: #FCE4EC; /* pink pucat untuk latar belakang */
            --accent-color: #000000; /* hitam untuk kontras */
            --accent-secondary: #F8BBD9; /* pink muda untuk hover */
            --leaf-color: #C2185B; /* magenta untuk ikon */
            --text-dark: #2C2C2C; /* abu-abu gelap untuk teks */
            --text-light: #666666; /* abu-abu */
            --text-muted: #999999; /* abu-abu muda */
            --bg-light: linear-gradient(135deg, #FCE4EC 0%, #F8BBD9 100%); /* pink pucat gradient */
            --bg-white: #FCE4EC; /* pink pucat */
            --bg-pale: #FFF0F5; /* pink sangat pucat */
            --bg-black: #000000;
            --shadow-sm: 0 1px 3px 0 rgba(194, 24, 91, 0.1);
            --shadow: 0 4px 6px -1px rgba(194, 24, 91, 0.15);
            --shadow-lg: 0 10px 15px -3px rgba(194, 24, 91, 0.2);
            --shadow-xl: 0 20px 25px -5px rgba(194, 24, 91, 0.25);
            --border-radius: 12px;
            --border-radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: var(--bg-pale);
            overflow-x: hidden;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.2;
        }

        /* Admin Header */
        .admin-header {
            background: var(--bg-white);
            color: var(--text-dark);
            padding: 1rem 0;
            box-shadow: var(--shadow-lg);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(194, 24, 91, 0.1);
        }

        .admin-header .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
        }

        .admin-header .navbar-brand i {
            margin-right: 0.5rem;
            font-size: 1.25rem;
            color: var(--primary-color);
        }

        .admin-header .nav-link {
            color: var(--primary-color) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .admin-header .nav-link:hover {
            background: var(--accent-secondary);
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--bg-pale) 100%);
            min-height: calc(100vh - 80px);
            box-shadow: var(--shadow);
            padding: 0;
            border-radius: 0 var(--border-radius-lg) var(--border-radius-lg) 0;
            overflow: hidden;
        }

        .sidebar .nav-link {
            color: var(--text-dark);
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(194, 24, 91, 0.1);
            transition: var(--transition);
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            background: var(--accent-secondary);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: var(--accent-secondary);
            color: var(--primary-color);
            position: relative;
        }

        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--primary-color);
        }

        .sidebar .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
            color: var(--primary-color);
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
            background: var(--bg-pale);
            min-height: calc(100vh - 80px);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            transition: var(--transition);
            overflow: hidden;
            background: var(--bg-white);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 50%, var(--primary-color) 100%);
            color: var(--bg-white);
            border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0 !important;
            font-weight: 600;
            padding: 1.25rem;
            border: none;
        }

        .card-body {
            padding: 1.5rem;
            background: var(--bg-white);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            color: var(--bg-white);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: var(--primary-dark);
            color: var(--bg-white);
        }

        .btn-success,
        .btn-warning,
        .btn-danger {
            background: var(--primary-color);
            border: 1px solid var(--primary-light);
            color: var(--bg-white);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .btn-success:hover,
        .btn-warning:hover,
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: var(--primary-dark);
            color: var(--bg-white);
        }

        /* Stats Cards */
        .stats-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 50%, var(--primary-color) 100%);
            color: var(--bg-white);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: rotate(45deg);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
        }

        .stats-card .stats-icon {
            font-size: 2.5rem;
            opacity: 0.8;
            position: relative;
            z-index: 2;
        }

        .stats-card .stats-number {
            font-size: 2rem;
            font-weight: 700;
            position: relative;
            z-index: 2;
        }

        .stats-card .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        /* Tables */
        .table {
            background: var(--bg-white);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 50%, var(--primary-color) 100%);
            color: var(--bg-white);
            border: none;
            font-weight: 600;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            border-bottom: 1px solid rgba(194, 24, 91, 0.1);
            vertical-align: middle;
            background: var(--bg-white);
        }

        .table tbody tr:hover {
            background-color: var(--accent-secondary);
        }

        /* Badges */
        .badge {
            font-size: 0.8rem;
            padding: 0.5rem 0.8rem;
            border-radius: var(--border-radius);
            font-weight: 600;
        }

        /* Forms */
        .form-control, .form-select {
            border: 2px solid rgba(194, 24, 91, 0.2);
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            transition: var(--transition);
            font-size: 0.95rem;
            background: var(--bg-white);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(194, 24, 91, 0.25);
            background: var(--bg-white);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        /* Alerts */
        .alert {
            border-radius: var(--border-radius-lg);
            border: none;
            padding: 1rem 1.25rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #E8F5E8, #F0F8F0);
            color: var(--primary-dark);
            border-left: 4px solid var(--primary-color);
        }

        .alert-danger {
            background: linear-gradient(135deg, #fff0f0, #ffe2e2);
            color: var(--primary-dark);
            border-left: 4px solid var(--primary-dark);
        }

        /* Admin hero */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 50%, var(--primary-color) 100%);
            padding: 3rem 0;
            position: relative;
        }

        .hero-section .hero-content .btn-accent {
            background: var(--accent-color);
            color: var(--bg-white);
            border: none;
            border-radius: 6px;
            padding: 0.6rem 1.2rem;
        }

        .hero-section .hero-content .btn-accent-outline {
            background: transparent;
            color: var(--bg-white);
            border: 1px solid var(--bg-white);
            border-radius: 6px;
            padding: 0.6rem 1.2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                border-radius: 0;
            }

            .main-content {
                padding: 1rem;
            }

            .stats-card {
                margin-bottom: 1rem;
            }

            .admin-header .navbar-brand {
                font-size: 1.25rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-pale);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-cog me-2"></i>Admin Panel - Aresha Florist
                </a>

                <div class="navbar-nav ms-auto d-flex align-items-center">
                    <a class="nav-link" href="{{ route('admin.settings.store.index') }}">
                        <i class="fas fa-cog me-1"></i>Pengaturan Toko
                    </a>
                    <a class="nav-link" href="{{ url('/') }}" target="_blank">
                        <i class="fas fa-external-link-alt me-1"></i>Lihat Website
                    </a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        <i class="fas fa-shopping-bag me-2"></i>Produk
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-tags me-2"></i>Kategori
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-cart me-2"></i>Pesanan
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users me-2"></i>Pelanggan
                    </a>
                    <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                        <i class="fas fa-chart-bar me-2"></i>Laporan
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    @include('layouts.partials.scripts')
</body>
</html>

