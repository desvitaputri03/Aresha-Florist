@extends('layouts.store')

@section('title', 'Kategori Karangan Bunga')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content">
                    <h1 class="display-4 mb-4 fw-bold text-white">
                        <i class="fas fa-tags me-3"></i>Kategori Karangan Bunga
                    </h1>
                    <p class="lead mb-4 text-white" style="max-width: 600px; margin: 0 auto;">
                        Jelajahi kategori untuk menemukan karangan bunga yang tepat
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="#categories" class="btn-accent">
                            <i class="fas fa-eye me-2"></i>Lihat Kategori
                        </a>
                        <a href="{{ route('products.index') }}" class="btn-accent-outline">
                            <i class="fas fa-shopping-bag me-2"></i>Lihat Semua Karangan Bunga
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

<!-- Toolbar sederhana -->
<section class="filter-nav">
    <div class="container">
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Cari Kategori</label>
                <div class="input-group">
                    <input type="text" id="searchCategory" class="form-control" placeholder="Ketik nama kategori...">
                    <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-list me-2"></i>Lihat Semua Karangan Bunga
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Categories Grid -->
<section id="categories" class="py-5">
    <div class="container">
        <div class="row g-4" id="categoryGrid">
            @forelse($categories as $category)
            <div class="col-lg-3 col-md-6 category-card" data-name="{{ strtolower($category->name) }}">
                <div class="product-card fade-in-up">
                    <div class="position-relative">
                        <img src="https://via.placeholder.com/900x600?text=Kategori+Karangan+Bunga+Aresha" alt="{{ $category->name }}" class="img-fluid">
                        <div class="product-badge">Kategori</div>
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-2">{{ $category->name }}</h5>
                        <p class="text-muted mb-3">{{ Str::limit($category->deskripsi ?? $category->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('products.index', ['category' => $category->id]) }}" class="btn-accent btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Karangan Bunga
                            </a>
                            @if(!empty($category->slug))
                                <small class="text-muted">/{{ $category->slug }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-tags text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="text-muted mb-3">Belum Ada Kategori</h3>
                    <p class="text-muted mb-4">Kategori akan segera ditambahkan. Silakan kembali lagi nanti.</p>
                    <a href="{{ url('/') }}" class="btn-accent">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<script>
// Filter kategori sisi-klien (sederhana)
document.getElementById('searchCategory')?.addEventListener('input', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.category-card').forEach(card => {
        const match = card.getAttribute('data-name')?.includes(term);
        card.style.display = match ? 'block' : 'none';
    });
});

// Animasi masuk
const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);
document.querySelectorAll('.fade-in-up').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});
</script>
@endsection
