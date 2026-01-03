@extends('layouts.store')

@section('title', 'Katalog Karangan Bunga')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="background: var(--bg-light); padding: 4rem 0;">
    <div class="container text-center">
        <h6 class="text-primary text-uppercase fw-bold mb-3 ls-wide" style="letter-spacing: 2px;">Koleksi Lengkap</h6>
        <h1 class="display-4 fw-bold mb-3" style="font-family: 'Playfair Display', serif; color: var(--text-dark);">Katalog Karangan Bunga</h1>
        <p class="text-muted mx-auto" style="max-width: 600px;">Temukan rangkaian bunga terbaik yang dirancang khusus untuk mewakili perasaan Anda.</p>
    </div>
</section>

<!-- Filter Navigation -->
<section class="py-3 border-bottom bg-white sticky-top" style="top: 80px; z-index: 990;">
    <div class="container">
        <form method="GET" action="{{ route('products.index') }}" class="row g-3 align-items-center">
            <div class="col-lg-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="q" value="{{ $filters['q'] }}" class="form-control border-start-0 ps-0" placeholder="Cari nama produk...">
                </div>
            </div>
            <div class="col-lg-3">
                <select class="form-select form-select-sm" name="category" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $filters['category']==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <select class="form-select form-select-sm" name="sort" onchange="this.form.submit()">
                    <option value="featured" {{ $filters['sort']=='featured' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_low_high" {{ $filters['sort']=='price_low_high' ? 'selected' : '' }}>Harga: Terendah</option>
                    <option value="price_high_low" {{ $filters['sort']=='price_high_low' ? 'selected' : '' }}>Harga: Tertinggi</option>
                    <option value="name_asc" {{ $filters['sort']=='name_asc' ? 'selected' : '' }}>Nama: A-Z</option>
                </select>
            </div>
            <div class="col-lg-2 text-lg-end">
                <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill">Filter</button>
            </div>
        </form>
    </div>
</section>

<!-- Products Grid -->
<section id="products" class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-lg-3 col-md-6">
                <div class="product-card-premium bg-white h-100 fade-in-up shadow-sm">
                    <a href="{{ route('products.show', $product->id) }}" class="card-img-wrapper d-block position-relative overflow-hidden">
                        @php $firstImage = $product->images->first(); @endphp
                        @if($firstImage)
                            <img src="{{ asset('storage/'.$firstImage->image_path) }}"
                                 alt="{{ $product->name }}"
                                 class="product-img">
                        @else
                            <img src="https://via.placeholder.com/600x600?text=Produk+Aresha"
                                 alt="{{ $product->name }}"
                                 class="product-img">
                        @endif

                        @if($product->harga_diskon)
                            <div class="premium-badge discount">-{{ round((($product->harga - $product->harga_diskon) / $product->harga) * 100) }}%</div>
                        @endif
                    </a>
                    <div class="p-4 text-center">
                        <small class="text-uppercase ls-wide text-muted mb-2 d-block" style="font-size: 0.7rem; font-weight: 600;">{{ $product->category->name ?? 'Florist' }}</small>
                        <h5 class="product-title fw-bold mb-3">{{ $product->name }}</h5>
                        <div class="product-price mb-3">
                            @if($product->harga_diskon)
                                <span class="price-new">Rp {{ number_format($product->harga_diskon, 0, ',', '.') }}</span>
                                <span class="price-old">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            @else
                                <span class="price-new">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-show-product w-100">Detail Produk</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Produk tidak ditemukan</h5>
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
    </div>
</section>

<style>
    .product-card-premium {
        background: #fff;
        border: 1px solid rgba(0,0,0,0.05);
        transition: var(--transition);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }
    .product-card-premium:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-lg);
    }
    .card-img-wrapper {
        aspect-ratio: 1/1;
        position: relative;
    }
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }
    .product-card-premium:hover .product-img {
        transform: scale(1.1);
    }
    .product-title {
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        color: var(--text-dark);
        height: 2.4em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .price-new {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--primary-color);
        display: block;
    }
    .price-old {
        font-size: 0.85rem;
        color: var(--text-muted);
        text-decoration: line-through;
    }
    .btn-show-product {
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        padding: 0.4rem 1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        font-size: 0.85rem;
    }
    .btn-show-product:hover {
        background: var(--primary-color);
        color: white;
    }
    .premium-badge {
        position: absolute;
        padding: 5px 12px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        z-index: 10;
        border-radius: 0 0 12px 0;
    }
    .premium-badge.discount {
        top: 0; left: 0;
        background: var(--primary-dark);
        color: white;
    }
    .product-overlay {
        display: none;
    }
</style>

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
