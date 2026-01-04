<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Aresha Florist')</title>
    @include('layouts.partials.styles')
    <style>
        :root {
            --primary-color: #C2185B; /* Pink Tua / Magenta */
            --primary-light: #E91E63;
            --secondary-color: #FCE4EC; /* Pink Lembut */
            --accent-secondary: #F8BBD9;
            --bg-body: #FFF0F5; /* Background Dasar Pink Sangat Pucat */
        }

        body { background-color: var(--bg-body); font-family: 'Inter', sans-serif; }

        /* PENGATURAN HERO (DAERAH ATAS): PINK TUA + TULISAN PUTIH MURNI */
        .hero-section, .card-header-magenta {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%) !important;
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 8px 15px rgba(194, 24, 91, 0.2);
        }

        /* INI SOLUSI TULISAN PUTIH: Paksa jadi Putih Tebal di atas Pink Tua */
        .hero-section h1, .hero-section h2, .hero-section p, 
        .hero-section i, .hero-section .lead {
            color: #ffffff !important; 
            font-weight: 800 !important;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* SIDEBAR: TETAP PINK LEMBUT */
        .sidebar { background-color: var(--secondary-color) !important; min-height: 100vh; border-right: 1px solid var(--accent-secondary); }
        .sidebar .nav-link { color: var(--primary-color); font-weight: 700; padding: 15px 20px; }
        .sidebar .nav-link.active { background-color: var(--primary-color) !important; color: white !important; }

        /* KOTAK-KOTAK (CARD): TETAP PINK LEMBUT */
        .card, .filter-box, .bg-light {
            background-color: var(--secondary-color) !important;
            border: 1px solid var(--accent-secondary) !important;
            border-radius: 15px;
        }

        /* Judul yang tidak pakai background pink tua, tetap warna Magenta */
        h2, h5:not(.text-white) { color: var(--primary-color) !important; font-weight: 800; }

        /* HEADER NAV ATAS (KEMBALIKAN PINK) */
        .admin-header { background: var(--secondary-color); border-bottom: 2px solid var(--accent-secondary); padding: 10px; }
        .navbar-brand { color: var(--primary-color) !important; font-weight: 800; }
        .nav-link-top { color: var(--primary-color) !important; font-weight: 600; margin-left: 10px; text-decoration: none; }

        /* Perbaikan Tombol Garis Putih di Hero */
        .btn-accent-outline { border: 2px solid #ffffff !important; color: #ffffff !important; font-weight: 700; }
    </style>
</head>
<body>
    <header class="admin-header shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Aresha Admin</a>
            <div class="d-flex align-items-center">
                <a class="nav-link-top" href="{{ url('/') }}" target="_blank">Lihat Toko</a>
                <a class="nav-link-top" href="{{ route('admin.settings.store.index') }}">Pengaturan</a>
                @auth <form action="{{ route('logout') }}" method="POST" class="ms-3"> @csrf <button class="btn btn-sm btn-outline-danger">Logout</button></form> @endauth
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar px-0">
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fas fa-home me-2"></i>Dashboard</a>
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="fas fa-box me-2"></i>Produk</a>
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="fas fa-tags me-2"></i>Kategori</a>
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart me-2"></i>Pesanan</a>
                    <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}"><i class="fas fa-chart-bar me-2"></i>Laporan</a>
                </nav>
            </div>
            <div class="col-md-9 col-lg-10 p-4">
                @yield('content')
            </div>
        </div>
    </div>
    @include('layouts.partials.scripts')
</body>
</html>