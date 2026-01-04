<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aresha Florist')</title>
    <meta name="description" content="Aresha Florist - Toko karangan bunga online terpercaya dengan rangkaian bunga terindah untuk setiap momen spesial. Free ongkir Padang, tanpa minimum pembelian.">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2E3D3A; /* deep sage */
            --primary-light: #3E4F4B;
            --primary-dark: #22302D;
            --secondary-color: #FFF7F5; /* ivory blush */
            --accent-color: #E96D8F; /* rose pink */
            --accent-light: #F6A3B9;
            --accent-secondary: #C95B7C; /* deeper rose */
            --text-dark: #2F2F30;
            --text-light: #5E6664;
            --text-muted: #8C9391;
            --bg-light: #FFF7F5;
            --bg-white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgba(46, 61, 58, 0.06);
            --shadow: 0 4px 6px -1px rgba(46, 61, 58, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(46, 61, 58, 0.12);
            --shadow-xl: 0 20px 25px -5px rgba(46, 61, 58, 0.15);
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
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            line-height: 1.2;
        }

        .display-1, .display-2, .display-3, .display-4, .display-5, .display-6 {
            font-family: 'Playfair Display', serif;
        }

        /* Top Banner */
        .top-banner {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            color: white;
            padding: 0.5rem 0;
            font-size: 0.875rem;
        }

        .top-banner .btn-call {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            transition: var(--transition);
        }

        .top-banner .btn-call:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        /* Navigation */
        .navbar-main {
            background: var(--bg-white);
            box-shadow: var(--shadow-sm);
            padding: 1rem 0;
            border-bottom: 2px solid rgba(233, 109, 143, 0.25);
            transition: var(--transition);
        }

        .navbar-main.scrolled {
            box-shadow: var(--shadow);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--accent-color);
        }

        .navbar-nav .nav-link {
            color: var(--text-dark);
            font-weight: 500;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color);
            background-color: var(--secondary-color);
            border: 1px solid rgba(233, 109, 143, 0.35);
        }

        .navbar-nav .nav-link.active {
            color: var(--primary-color);
            background-color: var(--secondary-color);
        }

        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-lg);
            border-radius: var(--border-radius);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }

        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-secondary));
            border: none;
            color: #ffffff;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: linear-gradient(135deg, var(--accent-light), var(--accent-color));
            color: #ffffff;
        }

        .btn-outline-primary-custom {
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
            background: transparent;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .btn-outline-primary-custom:hover {
            background: var(--accent-color);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: #ffffff;
            border: none;
            padding: 1.25rem;
            font-weight: 600;
        }

        /* Forms */
        .form-control, .form-select {
            border: 2px solid #e5e7eb;
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(17, 20, 57, 0.15);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem 1.25rem;
            box-shadow: var(--shadow-sm);
        }

        .alert-success {
            background: linear-gradient(135deg, #FFE6EE, #FFF7F5);
            color: var(--primary-dark);
            border-left: 4px solid var(--accent-color);
        }

        .alert-danger {
            background: linear-gradient(135deg, #fff0f0, #ffe2e2);
            color: var(--primary-dark);
            border-left: 4px solid var(--primary-dark);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #ffffff 50%, var(--secondary-color) 100%);
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="%23ffffff" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="%23ffffff" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }

            .hero-section {
                padding: 2rem 0;
            }

            .card {
                margin-bottom: 1rem;
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
            background: var(--bg-light);
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
    <!-- Top Banner -->
    <div class="top-banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-seedling me-2"></i>
                        <span>Welcome to Our Flower Shop</span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="tel:+622000000000" class="btn-call">
                        <i class="fas fa-phone me-1"></i>Call Us
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-main" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-seedling me-2"></i>Aresha Florist
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-bag me-1"></i>Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                            <i class="fas fa-tags me-1"></i>Kategori
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(auth()->user()->is_admin)
                            <li class="nav-item me-2">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                    <i class="fas fa-cog me-1"></i>Admin
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i>{{ auth()->user()->name ?? 'Akun' }}
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
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('login') }}" class="nav-link">
                                <i class="fas fa-right-to-bracket me-1"></i>Login
                            </a>
                            <a href="{{ route('register') }}" class="nav-link">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container mt-4">
                <div class="alert alert-success alert-dismissible fade show fade-in-up" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container mt-4">
                <div class="alert alert-danger alert-dismissible fade show fade-in-up" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-5 mt-5" style="background: var(--primary-color); color: #ffffff;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3" style="color: var(--accent-color);">
                        <i class="fas fa-seedling me-2"></i>Aresha Florist
                    </h5>
                    <p class="text-muted">Toko karangan bunga online terpercaya dengan rangkaian bunga terindah untuk setiap momen spesial. Kami berkomitmen memberikan kualitas terbaik dengan pelayanan yang memuaskan.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-whatsapp"></i></a>
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
                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                        <span class="text-muted">Jakarta, Indonesia</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-phone me-2 text-primary"></i>
                        <span class="text-muted">(+62) 200-0000-000</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-envelope me-2 text-primary"></i>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading state to forms
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                this.classList.add('loading');
            });
        });
    </script>
</body>
</html>
