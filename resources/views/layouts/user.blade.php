<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aresha Florist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="{{ route('store.index') }}">🌸 Aresha Florist</a>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center p-3 mt-5">
        <p>&copy; {{ date('Y') }} Aresha Florist. Semua Hak Dilindungi.</p>
    </footer>
</body>
</html>
