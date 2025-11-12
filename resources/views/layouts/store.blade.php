<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aresha Florist')</title>
    <meta name="description" content="Aresha Florist - Toko bunga online terpercaya dengan rangkaian bunga terindah untuk setiap momen spesial. Free ongkir Jakarta, tanpa minimum pembelian.">

    @include('layouts.partials.styles')

    <style>
        :root {
            --primary-color: #2E3D3A; /* deep sage green */
            --primary-light: #3E4F4B; /* lighter sage */
            --primary-dark: #22302D; /* darkest sage */
            --secondary-color: #FFF7F5; /* ivory blush */
            --accent-color: #E96D8F; /* rose pink */
            --accent-secondary: #F6A3B9; /* soft rose for hovers */
            --leaf-color: #89A88F; /* soft sage */
            --text-dark: #2F2F30;
            --text-light: #5E6664;
            --text-muted: #8C9391;
            --bg-light: #FFF7F5;
            --bg-white: #ffffff;
            --shadow-sm: 0 1px 3px 0 rgba(46, 61, 58, 0.07);
            --shadow: 0 4px 6px -1px rgba(46, 61, 58, 0.12);
            --shadow-lg: 0 10px 15px -3px rgba(46, 61, 58, 0.16);
            --shadow-xl: 0 20px 25px -5px rgba(46, 61, 58, 0.2);
            --border-radius: 12px;
            --border-radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            background: var(--bg-white);
            border-bottom: 2px solid rgba(233, 109, 143, 0.25); /* rose tint */
            padding: 1rem 0;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: var(--transition);
        }

        .navbar-store.scrolled {
            box-shadow: var(--shadow-lg);
        }

        .navbar-store .nav-link {
            color: var(--text-light);
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
            position: relative;
        }

        .navbar-store .nav-link:hover,
        .navbar-store .nav-link.active {
            color: var(--primary-color);
            background: linear-gradient(135deg, var(--secondary-color), rgba(233, 109, 143, 0.12));
            border: 1px solid rgba(233, 109, 143, 0.35);
        }

        .navbar-store .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1rem;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 50%;
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
    <nav class="navbar navbar-expand-lg navbar-light navbar-store" id="storeNavbar">
        <div class="container">
            <a class="navbar-brand brand" href="{{ url('/') }}">
                <img src="{{ asset('images/aresha.jpg') }}" alt="Aresha Florist Logo" style="height: 80px;">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
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
                            <i class="fas fa-shopping-cart me-1"></i>Keranjang
                            <span class="badge bg-primary ms-1" id="cart-count">0</span>
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-gauge-high me-1"></i>Admin
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="far fa-user me-1"></i>{{ auth()->user()->name ?? 'Akun' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                @if(auth()->user()->is_admin)
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge-high me-2"></i>Dashboard Admin</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="px-3 py-1">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 text-danger"><i class="fas fa-right-from-bracket me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item d-flex align-items-center gap-2">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-right-to-bracket me-1"></i>Login
                            </a>
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer-dark py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3" style="color: var(--accent-color);">
                        <img src="{{ asset('images/aresha.jpg') }}" alt="Aresha Florist Logo" style="height: 60px; margin-right: 10px;">Aresha Florist
                    </h5>
                    <p class="text-muted">Toko bunga online terpercaya dengan rangkaian bunga terindah untuk setiap momen spesial. Kami berkomitmen memberikan kualitas terbaik dengan pelayanan yang memuaskan.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light fs-5"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/areshaflorist/" class="text-light fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="https://wa.link/sylqcm" class="text-light fs-5"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="text-light fs-5"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="mb-3">Produk</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted text-decoration-none">Mawar</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Lily</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Tulip</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Matahari</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="mb-3">Layanan</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted text-decoration-none">Pengiriman</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Custom Order</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Konsultasi</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Garansi</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h6 class="mb-3">Kontak Kami</h6>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <span class="text-muted">Komplek kencana blok B 11 kel . gurun laweh kec .nanggalo Padang, Koto Padang, Sumatera Barat, Indonesia 25165</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <span class="text-muted">081374428198</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        <span class="text-muted">info@areshaflorist.com</span>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">&copy; 2024 Aresha Florist. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">Made with <i class="fas fa-heart text-danger"></i> in Indonesia</p>
                </div>
            </div>
        </div>
    </footer>

    @include('layouts.partials.scripts')
    
    <script>
    // Update cart count
    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('cart-count').textContent = data.count;
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





