@extends('layouts.store')

@section('title', 'Karangan Bunga Padang | Aresha Florist')

<style>
/* Hero Section Styles */
.hero-section {
    position: relative;
    min-height: 600px;
    display: flex;
    align-items: center;
    background: #f5f5f5;
    padding: 80px 0;
}

.hero-content {
    position: relative;
    z-index: 2;
    color: #333;
}

.hero-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    margin-bottom: 1rem;
    line-height: 1.2;
    color: #333;
}

.hero-title .highlight {
    color: var(--primary-color);
}

.hero-subtitle {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 1.5rem;
}

.hero-description {
    font-size: 1.1rem;
    margin-bottom: 1rem;
    color: #666;
    line-height: 1.7;
}

.hero-description-line {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    color: #666;
    line-height: 1.7;
}

.hero-button {
    background: var(--primary-color);
    color: white;
    padding: 1rem 2.5rem;
    font-weight: 700;
    border-radius: 8px;
    border: none;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.hero-button:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(233, 109, 143, 0.3);
    color: white;
}


.hero-image-wrapper {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0;
    overflow: visible;
    height: 100%;
}

.hero-image-container {
    position: relative;
    width: 100%;
    max-width: 100%;
    background: white;
    /* Arch shape at top, straight sides and bottom - smooth natural arch like window */
    border-radius: 220px 220px 0 0;
    padding: 0;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    display: block;
    min-height: 600px;
}

.hero-image {
    width: 100%;
    height: 100%;
    min-height: 600px;
    object-fit: cover;
    display: block;
    border-radius: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-section {
        padding: 60px 0;
        min-height: auto;
    }

    .hero-title {
        font-size: 2.5rem;
    }

    .hero-subtitle {
        font-size: 1.3rem;
    }

    .hero-description,
    .hero-description-line {
        font-size: 1rem;
    }

    .hero-image-wrapper {
        margin-top: 3rem;
    }
}

@media (max-width: 576px) {
    .hero-section {
        padding: 40px 0;
    }

    .hero-title {
        font-size: 2rem;
    }

    .hero-subtitle {
        font-size: 1.1rem;
    }

    .hero-description,
    .hero-description-line {
        font-size: 0.95rem;
    }

    .hero-button {
        padding: 0.875rem 2rem;
        font-size: 1rem;
        width: 100%;
        text-align: center;
    }
}
</style>

@section('content')

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title fade-in-up" style="animation-delay: 0.1s;">
                    Penjualan <span class="highlight">Karangan Bunga</span> Terbaik
                </h1>
                <p class="hero-subtitle fade-in-up" style="animation-delay: 0.2s;">Untuk Setiap Momen</p>
                <p class="hero-description fade-in-up" style="animation-delay: 0.3s;">
                    Spesialis Papan Karangan Bunga: Papan Rustic, Akrilik, dan Box. Gratis ongkir se-Kota Padang!
                </p>
                <a href="{{ route('products.index') }}" class="hero-button fade-in-up" style="animation-delay: 0.4s;">
                    Lihat Katalog
                </a>
            </div>
            <div class="col-lg-6 hero-image-wrapper fade-in-up" style="animation-delay: 0.3s;">
                <div class="hero-image-container">
                    <img src="{{ asset('images/areshaflorist.jpeg') }}" alt="Aresha Florist" class="hero-image">
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.trust-badge {
    padding: 1rem 0.5rem;
    border-radius: 12px;
}
</style>

<style>
    .min-vh-75 { min-height: 75vh; }
    .ls-wide { letter-spacing: 0.1em; }
    .border-radius-sm { border-radius: 4px; }
    .text-accent { color: var(--accent-color) !important; }
</style>

<!-- About Us Section -->
<section id="about" class="py-5" style="background-color: #fdfaf9;">
    <div class="container py-lg-5">
        <div class="row align-items-center g-5">
            <!-- Left Side: Text Info -->
            <div class="col-lg-6">
                <div class="pe-lg-4">
                    <h4 class="text-uppercase fw-black mb-3 d-inline-block px-4 py-2" style="letter-spacing: 4px; font-size: 1.5rem; color: var(--primary-color); font-weight: 900; background: transparent; padding-left: 0 !important;">TENTANG KAMI</h4>
                    <h2 class="fw-bold mb-4" style="font-family: 'Playfair Display', serif; line-height: 1.2; color: #1a1a1a; font-size: 2.25rem;">Spesialis Papan Karangan Bunga di Padang</h2>
                    <p class="text-dark mb-4" style="line-height: 1.8; font-size: 1.25rem; font-weight: 500;">
                        Aresha Florist adalah pilihan terpercaya untuk papan karangan bunga berkualitas di Kota Padang. Kami hadir untuk membantu Anda menyampaikan pesan dengan cara yang paling berkesan.
                    </p>
                    <div class="text-muted mb-4" style="line-height: 1.8; font-size: 1.1rem;">
                        <p class="mb-3">Kami menyediakan berbagai jenis papan karangan bunga seperti <strong>Papan Rustic</strong> yang estetik, <strong>Akrilik</strong> yang modern, hingga <strong>Box Bunga</strong> yang eksklusif untuk momen spesial Anda.</p>
                    </div>
                    <div class="mt-4">
                        <a href="https://www.instagram.com/areshaflorist/" target="_blank" class="text-decoration-none d-inline-flex align-items-center p-2 pe-4 rounded-pill shadow-sm bg-white border">
                            <div class="bg-gradient-instagram text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);">
                                <i class="fab fa-instagram"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark small">@areshaflorist</div>
                                <div class="text-muted" style="font-size: 0.7rem;">Ikuti kami di Instagram</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Side: Feature Cards -->
            <div class="col-lg-6">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="p-4 bg-white rounded-4 shadow-sm d-flex align-items-center border-start border-5 border-primary">
                            <div class="flex-shrink-0 bg-secondary rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 70px; height: 70px;">
                                <i class="fas fa-gem fs-3" style="color: var(--primary-color);"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Kualitas Premium</h5>
                                <p class="text-muted mb-0" style="font-size: 1rem;">Hanya menggunakan bahan baku pilihan dan material berkualitas tinggi untuk hasil papan karangan bunga yang kokoh, rapi, dan mewah.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-4 bg-white rounded-4 shadow-sm d-flex align-items-center border-start border-5" style="border-color: #2ecc71 !important;">
                            <div class="flex-shrink-0 rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 70px; height: 70px; background-color: #e8fdf0;">
                                <i class="fas fa-truck-loading fs-3" style="color: #2ecc71;"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Gratis Ongkir se-Padang</h5>
                                <p class="text-muted mb-0" style="font-size: 1rem;">Nikmati layanan pengiriman tanpa biaya tambahan ke seluruh titik di wilayah Kota Padang secara tepat waktu.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section id="featured" class="py-5 bg-white">
    <div class="container py-lg-5">
        <div class="text-center mb-5">
            <h6 class="text-uppercase fw-bold mb-2" style="letter-spacing: 2px; color: var(--primary-color);">Koleksi Kami</h6>
            <h2 class="display-5 fw-bold mb-3" style="font-family: 'Playfair Display', serif;">Koleksi Unggulan</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Keindahan yang dirangkai khusus untuk menyampaikan pesan Anda</p>
        </div>

        <div class="row g-4">
            @forelse($featuredProducts as $product)
            <div class="col-lg-4 col-md-6">
                <div class="product-card-premium h-100 fade-in-up">
                    <a href="{{ route('products.show', $product->id) }}" class="card-img-wrapper d-block position-relative overflow-hidden">
                        @if($product->images->count() > 0)
                            <img src="{{ asset('storage/'.$product->images->first()->image_path) }}" 
                                 alt="{{ $product->name }}"
                                 class="product-img">
                        @else
                            <img src="https://via.placeholder.com/600x600?text=Aresha+Florist"
                                 alt="{{ $product->name }}"
                                 class="product-img">
                        @endif

                        @if($product->harga_diskon && $product->harga > 0)
                            <div class="premium-badge discount">-{{ round((($product->harga - $product->harga_diskon) / $product->harga) * 100) }}%</div>
                        @endif
                    </a>
                    <div class="p-4 text-center">
                        <h5 class="product-title fw-bold mb-2">{{ $product->name }}</h5>
                        <div class="product-price mb-3">
                            @if($product->harga_diskon)
                                <span class="price-new">Rp {{ number_format($product->harga_diskon, 0, ',', '.') }}</span>
                                <span class="price-old">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            @else
                                <span class="price-new">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-show-product">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-seedling fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada produk tersedia</h5>
            </div>
            @endforelse
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
        font-size: 1.1rem;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }
    .price-new {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary-color);
        display: block;
    }
    .price-old {
        font-size: 0.9rem;
        color: var(--text-muted);
        text-decoration: line-through;
        margin-left: 0.5rem;
    }
    .btn-show-product {
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        font-size: 0.9rem;
    }
    .btn-show-product:hover {
        background: var(--primary-color);
        color: white;
        transform: scale(1.05);
    }
    .premium-badge {
        position: absolute;
        padding: 6px 14px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        border-radius: 0 0 12px 0;
        z-index: 10;
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


<!-- Call to Action -->
<section class="py-5 bg-white">
    <div class="container py-lg-5">
        <div class="p-5 text-center text-white border-radius-lg position-relative overflow-hidden" style="background: var(--primary-color);">
            <div class="position-relative z-index-2">
                <h2 class="display-5 fw-bold mb-4" style="font-family: 'Playfair Display', serif;">Abadikan Momen Anda</h2>
                <p class="lead mb-5 mx-auto" style="max-width: 700px; opacity: 0.8;">Beri kejutan manis bagi orang tersayang dengan pilihan karangan bunga papan terbaik dari Aresha Florist Padang.</p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('products.index') }}" class="btn btn-light px-5 py-3 fw-bold">Pesan Sekarang</a>
                    <a href="https://wa.me/6281374428198" class="btn btn-outline-light px-5 py-3 fw-bold">Chat WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5 mb-5">
    <div class="container py-lg-5 text-center">
        <h6 class="text-uppercase fw-bold mb-3 ls-wide" style="color: var(--primary-color); font-size: 0.8rem;">Testimoni</h6>
        <h2 class="display-5 fw-bold mb-5" style="font-family: 'Playfair Display', serif;">Apa Kata Mereka?</h2>
        
        <div class="row g-4 text-start">
            <div class="col-lg-4">
                <div class="p-4 border h-100">
                    <div class="mb-3">
                        @for($i=0; $i<5; $i++) <i class="fas fa-star text-warning small"></i> @endfor
                    </div>
                    <p class="fst-italic text-muted mb-4">"Papan karangan bunganya sangat cantik dan premium. Pengiriman di Padang benar-benar gratis dan tepat waktu. Sangat puas!"</p>
                    <div class="d-flex align-items-center">
                        <div class="fw-bold small text-uppercase ls-wide">Sarah Amanda</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 border h-100">
                    <div class="mb-3">
                        @for($i=0; $i<5; $i++) <i class="fas fa-star text-warning small"></i> @endfor
                    </div>
                    <p class="fst-italic text-muted mb-4">"Pesan papan rustic untuk grand opening teman, hasilnya sangat mewah. Admin ramah dan prosesnya cepat sekali."</p>
                    <div class="d-flex align-items-center">
                        <div class="fw-bold small text-uppercase ls-wide">Budi Pratama</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 border h-100">
                    <div class="mb-3">
                        @for($i=0; $i<5; $i++) <i class="fas fa-star text-warning small"></i> @endfor
                    </div>
                    <p class="fst-italic text-muted mb-4">"Terima kasih Aresha Florist! Box bunganya sangat rapi dan kualitasnya premium. Kado yang sempurna untuk acara spesial."</p>
                    <div class="d-flex align-items-center">
                        <div class="fw-bold small text-uppercase ls-wide">Indah Permata</div>
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

