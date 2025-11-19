@extends('layouts.store')

@section('title', 'Karangan Bunga Padang | Aresha Florist')

<style>
/* Hero Section Styles */
.hero-section {
    position: relative;
    height: 70vh;
    min-height: 500px;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('{{ asset('images/are.jpg') }}'); /* Changed hero background image to are.jpg */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    filter: blur(2px);
    transform: scale(1.1);
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(233, 30, 99, 0.7) 0%, rgba(194, 24, 91, 0.8) 100%);
    backdrop-filter: blur(1px);
}

.hero-content {
    position: relative;
    z-index: 2;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    font-family: 'Playfair Display', serif;
}

.hero-description {
    font-size: 1.25rem;
    margin-bottom: 2.5rem;
    opacity: 0.95;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

.hero-buttons {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.hero-buttons .btn {
    padding: 0.875rem 2rem;
    font-weight: 600;
    border-radius: 50px;
    text-transform: none;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.hero-buttons .btn-primary {
    background: linear-gradient(135deg, #E91E63, #C2185B);
    border: none;
    color: white;
}

.hero-buttons .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(233, 30, 99, 0.4);
    background: linear-gradient(135deg, #C2185B, #8E24AA);
}

.hero-buttons .btn-outline-light {
    border: 2px solid rgba(255, 255, 255, 0.8);
    color: white;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.hero-buttons .btn-outline-light:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-section {
        height: 60vh;
        min-height: 400px;
    }

    .hero-title {
        font-size: 2.5rem;
    }

    .hero-description {
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }

    .hero-buttons {
        flex-direction: column;
        align-items: center;
    }

    .hero-buttons .btn {
        width: 200px;
        margin-bottom: 0.5rem;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }

    .hero-description {
        font-size: 1rem;
    }
}
</style>

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-background">
        <div class="hero-overlay"></div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="hero-content">
                    <h1 class="hero-title">Karangan Bunga Padang | Aresha Florist</h1>
                    <p class="hero-description">
                        Menyediakan sewa karangan bunga, Papan Rustic, akrilik dan box.
                        Gratis Ongkir sekota Padang!
                    </p>
                    <div class="hero-buttons">
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg me-3">
                            Lihat Koleksi
                        </a>
                        <a href="https://wa.link/sylqcm" class="btn btn-outline-light btn-lg">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section id="featured" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Koleksi Unggulan</h2>
            <p class="lead text-muted">Temukan karangan bunga terindah dan terpopuler dari kami</p>
        </div>

        <div class="row g-4">
            @forelse($featuredProducts as $product)
            <div class="col-lg-4 col-md-6">
                <div class="product-card fade-in-up">
                    <div class="position-relative">
                        @if($product->gambar)
                            <img src="{{ asset('storage/'.$product->gambar) }}"
                                 alt="{{ $product->name }}"
                                 class="img-fluid">
                        @else
                            <img src="https://via.placeholder.com/500x500?text=Karangan+Bunga+Aresha"
                                 alt="{{ $product->name }}"
                                 class="img-fluid">
                        @endif
                        @if($product->harga_diskon && $product->harga > 0)
                            <div class="product-badge">
                                -{{ round((($product->harga - $product->harga_diskon) / $product->harga) * 100) }}%
                            </div>
                        @elseif ($product->harga_diskon && $product->harga == 0)
                            <div class="product-badge">Diskon</div> {{-- Tampilkan badge 'Diskon' generik jika diskon ada tapi harga nol --}}
                        @else
                            <div class="product-badge">New</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-2">{{ $product->name }}</h5>
                        <p class="text-muted mb-3">{{ Str::limit($product->deskripsi, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            @if($product->harga_diskon)
                                <div>
                                    <span class="h5 text-primary mb-0">Rp {{ number_format($product->harga_diskon, 0, ',', '.') }}</span>
                                    <small class="text-muted text-decoration-line-through d-block">Rp {{ number_format($product->harga, 0, ',', '.') }}</small>
                                </div>
                            @else
                                <span class="h5 text-primary mb-0">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            @endif
                            <a href="{{ route('products.show', $product->id) }}" class="btn-accent btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="py-5">
                    <i class="fas fa-seedling fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada produk tersedia</h4>
                    <p class="text-muted">Produk akan segera ditambahkan oleh admin.</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn-accent">
                <i class="fas fa-eye me-2"></i>Lihat Semua Produk
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="p-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-truck fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Gratis Ongkir</h5>
                    <p class="text-muted">Gratis ongkir untuk area Padang tanpa minimum pembelian</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 text-center">
                <div class="p-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-leaf fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Papan Berkualitas</h5>
                    <p class="text-muted">Produk berkualitas tinggi dengan desain terbaik</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 text-center">
                <div class="p-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-heart fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Papan Rustic, Akrilik & Box</h5>
                    <p class="text-muted">Menyediakan berbagai pilihan Papan Rustic, akrilik dan box sesuai keinginan Anda</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 text-center">
                <div class="p-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-handshake fs-3"></i> <!-- Ubah ikon jika perlu -->
                    </div>
                    <h5 class="fw-bold mb-2">Pelayanan Terbaik</h5>
                    <p class="text-muted">Komitmen kami untuk memberikan pelayanan terbaik bagi pelanggan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
    <div class="container text-center text-white">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-4">Siap Mengucapkan Selamat?</h2>
                <p class="lead mb-4">
                    Kami membantu Anda mengekspresikan perasaan dengan karangan bunga yang sempurna.
                    Dari momen romantis hingga perayaan, kami siap melayani Anda.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Pesan Sekarang
                    </a>
                    <a href="https://wa.link/sylqcm" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Apa Kata Pelanggan Kami</h2>
            <p class="lead text-muted">Ulasan nyata dari pelanggan yang puas</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-quote-left text-primary fs-1"></i>
                        </div>
                        <p class="mb-4">"Karangan bunga yang sangat indah dan berkualitas! Pelayanan cepat dan ramah. Sangat direkomendasikan!"</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?q=80&w=100&auto=format&fit=crop"
                                 alt="Customer"
                                 class="rounded-circle me-3"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0">Sarah Johnson</h6>
                                <small class="text-muted">Padang</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-quote-left text-primary fs-1"></i>
                        </div>
                        <p class="mb-4">"Pengiriman tepat waktu dan karangan bunga berkualitas. Sangat puas dengan pelayanannya!"</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=100&auto=format&fit=crop"
                                 alt="Customer"
                                 class="rounded-circle me-3"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0">Michael Chen</h6>
                                <small class="text-muted">Padang</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-quote-left text-primary fs-1"></i>
                        </div>
                        <p class="mb-4">"Pesan karangan bunga untuk acara duka, hasilnya sangat sesuai harapan dan cepat sampai!"</p>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=100&auto=format&fit=crop"
                                 alt="Customer"
                                 class="rounded-circle me-3"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0">Lisa Wang</h6>
                                <small class="text-muted">Padang</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
</script>
@endsection

