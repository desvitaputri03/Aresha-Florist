@extends('layouts.store')

@section('title', 'Katalog Produk')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content">
                    <h1 class="display-4 mb-4 fw-bold" style="color: var(--primary-color);">
                        <i class="fas fa-shopping-bag me-3"></i>Katalog Produk
                    </h1>
                    <p class="lead mb-4" style="max-width: 600px; margin: 0 auto; color: var(--text-dark);">
                        Temukan rangkaian bunga terindah untuk setiap momen spesial
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="#products" class="btn-accent">
                            <i class="fas fa-eye me-2"></i>Lihat Produk
                        </a>
                        <a href="tel:+622000000000" class="btn-accent-outline">
                            <i class="fas fa-phone me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter Navigation (Toolbar like reference) -->
<section class="filter-nav">
    <div class="container">
        <form method="GET" action="{{ route('products.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Cari</label>
                <div class="input-group">
                    <input type="text" name="q" value="{{ $filters['q'] }}" class="form-control" placeholder="Cari produk...">
                    <button class="btn-accent" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kategori</label>
                <select class="form-select" name="category">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $filters['category']==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Harga (Rp)</label>
                <div class="d-flex gap-2">
                    <input type="number" name="price_from" class="form-control" placeholder="Dari" value="{{ $filters['price_from'] }}" min="0">
                    <input type="number" name="price_to" class="form-control" placeholder="Sampai" value="{{ $filters['price_to'] }}" min="0">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label">Urutkan</label>
                <select class="form-select" name="sort" onchange="this.form.submit()">
                    <option value="featured" {{ $filters['sort']=='featured' ? 'selected' : '' }}>Terbaru</option>
                    <option value="newest" {{ $filters['sort']=='newest' ? 'selected' : '' }}>Tanggal: baru ke lama</option>
                    <option value="oldest" {{ $filters['sort']=='oldest' ? 'selected' : '' }}>Tanggal: lama ke baru</option>
                    <option value="name_asc" {{ $filters['sort']=='name_asc' ? 'selected' : '' }}>Nama: A-Z</option>
                    <option value="name_desc" {{ $filters['sort']=='name_desc' ? 'selected' : '' }}>Nama: Z-A</option>
                    <option value="price_low_high" {{ $filters['sort']=='price_low_high' ? 'selected' : '' }}>Harga: rendah ke tinggi</option>
                    <option value="price_high_low" {{ $filters['sort']=='price_high_low' ? 'selected' : '' }}>Harga: tinggi ke rendah</option>
                </select>
            </div>
        </form>
    </div>
</section>

<!-- Products Grid -->
<section id="products" class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-6">
                <div class="product-card fade-in-up">
                    <div class="position-relative">
                        @if($product->gambar)
                            <img src="{{ asset('storage/'.$product->gambar) }}"
                                 alt="{{ $product->name }}"
                                 class="img-fluid">
                        @else
                            <img src="https://images.unsplash.com/photo-1518895949257-7621c3c786d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                                 alt="{{ $product->name }}"
                                 class="img-fluid">
                        @endif
                        @if($product->harga_diskon)
                            <div class="product-badge">
                                -{{ round((($product->harga - $product->harga_diskon) / $product->harga) * 100) }}%
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-2">{{ $product->name }}</h5>
                        <p class="text-muted mb-3">{{ Str::limit($product->deskripsi, 60) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($product->harga_diskon)
                                    <span class="h5 text-primary mb-0">Rp{{ number_format($product->harga_diskon,0,',','.') }}</span>
                                    <small class="text-muted text-decoration-line-through ms-2">Rp{{ number_format($product->harga,0,',','.') }}</small>
                                @else
                                    <span class="h5 text-primary mb-0">Rp{{ number_format($product->harga,0,',','.') }}</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $product->id) }}" class="btn-accent btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat
                            </a>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-box me-1"></i>Stok: {{ $product->stok }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>

        @if($products->isEmpty())
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-bag text-muted" style="font-size: 4rem;"></i>
            </div>
            <h3 class="text-muted mb-3">Belum Ada Produk</h3>
            <p class="text-muted mb-4">Produk akan segera ditambahkan. Silakan kembali lagi nanti.</p>
            <a href="{{ url('/') }}" class="btn-accent">
                <i class="fas fa-home me-2"></i>Kembali ke Beranda
            </a>
        </div>
        @endif
    </div>
</section>

<script>
// Add smooth scrolling animation to elements
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all fade-in-up elements
document.querySelectorAll('.fade-in-up').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});

// no inline search; using server-side filters
</script>
@endsection
