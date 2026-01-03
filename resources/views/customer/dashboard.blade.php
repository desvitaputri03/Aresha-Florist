@extends('layouts.store')

@section('title', 'Dashboard Customer - Aresha Florist')

@section('content')
<style>
    .dashboard-wrapper {
        background: linear-gradient(135deg, #FFF7F5 0%, #ffffff 100%);
        min-height: calc(100vh - 200px);
        padding: 3rem 0;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .welcome-banner {
        background: linear-gradient(135deg, #E96D8F 0%, #C24D6D 100%);
        color: white;
        border-radius: 20px;
        padding: 3rem;
        margin-bottom: 3rem;
        box-shadow: 0 10px 30px rgba(233, 109, 143, 0.3);
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
    }

    .welcome-banner h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        font-family: 'Playfair Display', serif;
    }

    .welcome-banner p {
        font-size: 1.2rem;
        opacity: 0.95;
        margin: 0;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid #f5f5f5;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #E96D8F, #F6A3B9);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .stat-card:hover::before {
        transform: scaleY(1);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(233, 109, 143, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #FFF7F5, #FFE4E1);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        color: #E96D8F;
        font-size: 1.75rem;
    }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: #7A7A7A;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 2rem;
        font-family: 'Playfair Display', serif;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2rem;
    }

    .menu-card {
        background: white;
        border-radius: 18px;
        padding: 2.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid #f5f5f5;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .menu-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #E96D8F, #F6A3B9);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .menu-card:hover::before {
        transform: scaleX(1);
    }

    .menu-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 16px 40px rgba(233, 109, 143, 0.2);
        border-color: #E96D8F;
    }

    .menu-icon-wrapper {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #E96D8F, #F6A3B9);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.75rem;
        color: white;
        font-size: 2.5rem;
        box-shadow: 0 8px 20px rgba(233, 109, 143, 0.3);
        transition: all 0.3s ease;
    }

    .menu-card:hover .menu-icon-wrapper {
        transform: rotateY(360deg);
        box-shadow: 0 12px 28px rgba(233, 109, 143, 0.4);
    }

    .menu-card h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 1.75rem;
        font-family: 'Playfair Display', serif;
    }

    .btn-menu {
        background: linear-gradient(135deg, #E96D8F, #C24D6D);
        color: white;
        border: none;
        padding: 1rem 2.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 6px 16px rgba(233, 109, 143, 0.3);
    }

    .btn-menu:hover {
        background: linear-gradient(135deg, #C24D6D, #E96D8F);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(233, 109, 143, 0.4);
    }

    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 2rem 0;
        }

        .welcome-banner {
            padding: 2rem 1.5rem;
        }

        .welcome-banner h1 {
            font-size: 1.75rem;
        }

        .welcome-banner p {
            font-size: 1rem;
        }

        .stats-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .menu-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .section-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-container">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="welcome-content">
                <h1>Halo, {{ auth()->user()->name }}! 👋</h1>
                <p>Selamat datang kembali di dashboard Anda</p>
            </div>
        </div>

        <!-- Main Menu -->
        <h2 class="section-title">Menu Utama</h2>
        <div class="menu-grid mb-5">
            <div class="menu-card">
                <div class="menu-icon-wrapper">
                    <i class="fas fa-user-edit"></i>
                </div>
                <h3>Profil Saya</h3>
                <a href="{{ route('customer.profile.edit') }}" class="btn-menu">Kelola Profil</a>
            </div>

            <div class="menu-card">
                <div class="menu-icon-wrapper">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3>Pesanan Saya</h3>
                <a href="{{ route('customer.orders') }}" class="btn-menu">Lihat Pesanan</a>
            </div>

            <div class="menu-card">
                <div class="menu-icon-wrapper">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3>Keranjang</h3>
                <a href="{{ route('cart.index') }}" class="btn-menu">Buka Keranjang</a>
            </div>
        </div>

        <!-- Quick Stats at the bottom -->
        <div class="stats-row" style="grid-template-columns: 1fr; margin-bottom: 1rem;">
            <div class="stat-card text-center py-3" style="padding: 1rem !important;">
                <div class="stat-value" style="font-size: 1.5rem;">{{ auth()->user()->orders()->count() }}</div>
                <div class="stat-label" style="font-size: 0.85rem;">Total Karangan Bunga yang Pernah Anda Pesan</div>
            </div>
        </div>
    </div>
</div>
@endsection
