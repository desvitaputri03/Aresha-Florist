<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aresha Florist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #E96D8F;
            --primary-light: #F6A3B9;
            --primary-dark: #C24D6D;
            --secondary-color: #FFF7F5;
            --accent-color: #1B3022;
            --text-dark: #1A1A1A;
            --text-light: #4A4A4A;
            --text-muted: #7A7A7A;
            --bg-gradient: linear-gradient(135deg, #FFF7F5 0%, #ffffff 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Animated Background Elements */
        .bg-circle {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.4;
        }

        .circle-1 {
            width: 400px;
            height: 400px;
            background: var(--primary-light);
            top: -100px;
            right: -100px;
        }

        .circle-2 {
            width: 300px;
            height: 300px;
            background: #FFE4E1;
            bottom: -50px;
            left: -50px;
        }

        .login-container {
            width: 100%;
            max-width: 500px;
            padding: 2rem;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2.5rem 2.5rem;
            box-shadow: 0 20px 50px rgba(233, 109, 143, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .brand-header img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(233, 109, 143, 0.2);
            margin-bottom: 1.25rem;
        }

        .brand-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .brand-header p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        .form-floating-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-floating-custom input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #eee;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-floating-custom input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(233, 109, 143, 0.05);
        }

        .form-floating-custom label {
            position: absolute;
            left: 3rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: all 0.3s ease;
            pointer-events: none;
            font-size: 0.95rem;
        }

        .form-floating-custom input:focus + label,
        .form-floating-custom input:not(:placeholder-shown) + label {
            top: -0.5rem;
            left: 2.5rem;
            font-size: 0.75rem;
            color: var(--primary-color);
            background: white;
            padding: 0 0.5rem;
        }

        .form-floating-custom .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .form-floating-custom input:focus ~ .input-icon {
            color: var(--primary-color);
        }

        .btn-login {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            margin-top: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(233, 109, 143, 0.2);
            cursor: pointer;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(233, 109, 143, 0.3);
        }

        .alert-custom {
            padding: 0.85rem 1rem;
            border-radius: 10px;
            background: #FFF5F5;
            color: #E53E3E;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            border: 1px solid #FED7D7;
        }

        .footer-links {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.95rem;
        }

        .footer-links a {
            color: var(--text-light);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .register-link {
            color: #2563EB !important;
            font-weight: 600;
        }
        
        .register-link:hover {
            color: #1D4ED8 !important;
            text-decoration: underline !important;
        }

        .back-home {
            display: inline-block;
            margin-top: 1rem;
            color: #DB2777 !important;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .back-home:hover {
            color: #BE185D !important;
            text-decoration: underline !important;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            z-index: 5;
            font-size: 1rem;
        }

        @media (max-width: 640px) {
            .login-card {
                padding: 2.5rem 2rem;
            }
            
            .brand-header h1 {
                font-size: 2rem;
            }
            
            .brand-header img {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="bg-circle circle-1"></div>
    <div class="bg-circle circle-2"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="brand-header">
                <img src="{{ asset('images/aresha.jpg') }}" alt="Aresha Florist">
                <h1>Aresha Florist</h1>
                <p>Silakan masuk ke akun Anda</p>
            </div>

            @if($errors->any())
                <div class="alert-custom">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" id="loginForm">
                @csrf
                <div class="form-floating-custom">
                    <input type="email" name="email" id="email" placeholder=" " required value="{{ old('email') }}">
                    <label for="email">Email</label>
                    <i class="fas fa-envelope input-icon"></i>
                </div>

                <div class="form-floating-custom">
                    <input type="password" name="password" id="password" placeholder=" " required>
                    <label for="password">Password</label>
                    <i class="fas fa-lock input-icon"></i>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">Masuk Sekarang</button>
            </form>

            <div class="footer-links">
                <p>Belum punya akun? <a href="{{ route('register') }}" class="register-link">Daftar</a></p>
                <a href="{{ url('/') }}" class="back-home"><i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passInput = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';
        });
    </script>
</body>
</html>
