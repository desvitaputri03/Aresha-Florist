<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Karangan Bunga Padang')</title> {{-- Hapus "Aresha Florist" dari default title --}}
    <meta name="description" content="Aresha Florist - Menyediakan sewa karangan bunga, Papan Rustic, akrilik dan box. Gratis Ongkir sekota Padang!">

    @include('layouts.partials.styles')

    <style>
        :root {
            --primary-color: #E96D8F; /* Professional rose pink */
            --primary-light: #F6A3B9;
            --primary-dark: #C24D6D;
            --secondary-color: #FFF7F5; /* ivory blush */
            --accent-color: #1B3022; /* Forest green as accent now */
            --accent-gold: #D4A373; /* Elegant muted gold */
            --text-dark: #1A1A1A;
            --text-light: #4A4A4A;
            --text-muted: #7A7A7A;
            --bg-light: #FFF7F5;
            --bg-white: #ffffff;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow: 0 4px 12px rgba(233, 109, 143, 0.1);
            --shadow-lg: 0 10px 25px rgba(233, 109, 143, 0.15);
            --border-radius: 8px;
            --border-radius-lg: 16px;
            --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        /* Utility overrides for consistent contrast */
        .text-primary { color: var(--accent-color) !important; }
        .bg-primary { background-color: var(--accent-color) !important; }
        .border-primary { border-color: var(--accent-color) !important; }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: var(--bg-light);
            overflow-x: hidden;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.2;
        }

        .brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.75rem;
            letter-spacing: 0.5px;
            color: var(--accent-color);
        }

        /* Navigation */
        .navbar-store {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(27, 48, 34, 0.1);
            padding: 0.75rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        .navbar-store.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow);
        }

        .navbar-store .nav-link {
            color: var(--text-light);
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .navbar-store .nav-link:hover,
        .navbar-store .nav-link.active {
            color: var(--primary-color);
            background: var(--secondary-color);
        }

        .navbar-brand img {
            transition: var(--transition);
        }

        .navbar-brand:hover img {
            transform: scale(1.05);
        }

        /* Buttons */
        .btn-accent {
            background: var(--accent-color);
            border: none;
            color: #ffffff;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-accent:hover {
            background: var(--accent-secondary);
            color: #ffffff;
            text-decoration: none;
        }

        .btn-accent-outline {
            background: transparent;
            color: var(--accent-color);
            border: 1px solid var(--accent-color);
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-accent-outline:hover {
            background: var(--accent-color);
            color: var(--primary-color);
            text-decoration: none;
        }

        /* Cards */
        .card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--secondary-color), #ffffff);
            padding: 3rem 0;
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(233, 109, 143, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(137, 168, 143, 0.10) 0%, transparent 50%),
                radial-gradient(circle at 40% 60%, rgba(46, 61, 58, 0.04) 0%, transparent 50%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        /* Filter Navigation */
        .filter-nav {
            background: var(--bg-white);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(233, 109, 143, 0.25);
        }

        .filter-nav a {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
            margin: 0 0.25rem;
        }

        .filter-nav a:hover,
        .filter-nav a.active {
            color: var(--primary-color);
            background: linear-gradient(135deg, var(--secondary-color), rgba(0, 0, 0, 0.06));
        }

        /* Product Cards */
        .product-card {
            background: var(--bg-white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
            position: relative;
            border: 1px solid #f1f3f4;
        }

        .product-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .product-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: all 0.2s ease;
        }

        .product-card:hover img {
            transform: scale(1.02);
        }

        .product-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, var(--accent-color), var(--leaf-color));
            color: #ffffff;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 2;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .brand {
                font-size: 1.5rem;
            }

            .hero-section {
                padding: 2rem 0;
            }

            .navbar-store {
                padding: 0.75rem 0;
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

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Links */
        a {
            text-decoration: none;
            color: inherit;
        }

        a:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-store shadow-sm border-bottom py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/aresha.jpg') }}" style="height: 50px; width: 50px; object-fit: cover; border-radius: 50%; margin-right: 12px; border: 2px solid var(--primary-color);">
                <span class="fw-bold" style="font-family: 'Playfair Display', serif; color: var(--primary-color); letter-spacing: 0.5px; font-size: 1.4rem;">Aresha Florist</span>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fas fa-shopping-bag me-1"></i>Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <div class="position-relative d-inline-block">
                                <i class="fas fa-shopping-cart me-1"></i>Keranjang
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count" style="font-size: 0.6rem; display: none;">0</span>
                            </div>
                        </a>
                    </li>
                    @guest
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-primary px-4 rounded-pill shadow-sm" style="background: var(--primary-color); border: none;" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle fs-5 me-2" style="color: var(--primary-color);"></i>
                                <span class="fw-medium">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-2" style="border-radius: var(--border-radius-lg); min-width: 200px;">
                                @if(auth()->user()->is_admin)
                                    <li><a class="dropdown-item rounded-pill py-2" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2 text-muted"></i>Admin Dashboard</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @else
                                    <li><a class="dropdown-item rounded-pill py-2" href="{{ route('customer.dashboard') }}"><i class="fas fa-user-circle me-2 text-muted"></i>Dashboard Saya</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="dropdown-item rounded-pill py-2 text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-dark py-5 mt-5 text-white">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 mb-4">
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset('images/aresha.jpg') }}" alt="Logo" style="height: 50px; width: 50px; object-fit: cover; border-radius: 50%; margin-right: 15px; border: 2px solid white;">
                        <h5 class="mb-0 text-white" style="font-family: 'Playfair Display', serif;">
                            Aresha Florist
                        </h5>
                    </div>
                    <p class="text-white-50 small mb-4">Toko Papan Karangan Bunga online terpercaya di Padang. Kami menyediakan Papan Rustic, Akrilik, dan Box untuk setiap momen spesial Anda. Gratis ongkir sekota Padang!</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white-50 hover-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/areshaflorist/" class="text-white-50 hover-white" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://wa.me/6281374428198" class="text-white-50 hover-white" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-4">Produk</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none hover-white">Papan Bunga</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none hover-white">Papan Rustic</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none hover-white">Akrilik</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none hover-white">Box Bunga</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-4">Bantuan</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ url('/') }}#how-to-order" class="text-white-50 text-decoration-none hover-white">Cara Pesan</a></li>
                        <li class="mb-2"><a href="{{ url('/') }}#shipping" class="text-white-50 text-decoration-none hover-white">Pengiriman</a></li>
                        <li class="mb-2"><a href="{{ url('/') }}#about" class="text-white-50 text-decoration-none hover-white">Tentang Kami</a></li>
                        <li class="mb-2"><a href="#contact-info" class="text-white-50 text-decoration-none hover-white">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h6 class="text-white mb-4">Kontak Kami</h6>
                    <div class="d-flex mb-3">
                        <i class="fas fa-map-marker-alt mt-1 me-3 text-white-50"></i>
                        <span class="text-white-50 small" id="contact-info">Komplek Kencana Blok B 11, Kel. Gurun Laweh, Kec. Nanggalo, Kota Padang, Sumatera Barat 25165</span>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="fas fa-phone me-3 text-white-50"></i>
                        <span class="text-white-50 small">0813 7442 8198</span>
                    </div>
                    <div class="d-flex mb-3">
                        <i class="fab fa-instagram me-3 text-white-50"></i>
                        <a href="https://www.instagram.com/areshaflorist/" target="_blank" class="text-white-50 small text-decoration-none hover-white">@areshaflorist</a>
                    </div>
                </div>
            </div>
            <hr class="my-5 border-secondary">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-white-50 small mb-0">&copy; {{ date('Y') }} Aresha Florist Padang. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="text-white-50 small mb-0">Premium Florist Experience</p>
                </div>
            </div>
        </div>
    </footer>

    <style>
        .hover-white:hover { color: white !important; }
        .footer-dark { background-color: #121212; }
    </style>

    @include('layouts.partials.scripts')
    
    <script>
    // Update cart count
    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const countBadge = document.getElementById('cart-count');
                countBadge.textContent = data.count;
                if (data.count > 0) {
                    countBadge.style.display = 'inline-block';
                } else {
                    countBadge.style.display = 'none';
                }
            })
            .catch(error => console.log('Error updating cart count:', error));
    }
    
    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();
    });
    </script>
</body>
</html>





