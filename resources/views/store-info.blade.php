@extends('layouts.store')

@section('title', 'Informasi Toko | Aresha Florist')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="display-4 fw-bold mb-4">Informasi Toko Kami</h1>
                <p class="lead text-muted mb-5">
                    Temukan detail lengkap tentang Aresha Florist, lokasi kami, cara menghubungi, dan jam operasional.
                </p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3"><i class="fas fa-map-marker-alt text-primary me-2"></i>Alamat Kami</h5>
                        <p class="card-text text-muted">
                            {{ $storeSettings->address ?? 'Alamat belum diatur.' }}
                        </p>
                        @if($storeSettings->google_maps_link)
                            <a href="{{ $storeSettings->google_maps_link }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                Lihat di Google Maps <i class="fas fa-external-link-alt ms-1"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3"><i class="fas fa-phone-alt text-primary me-2"></i>Kontak Kami</h5>
                        <p class="card-text text-muted mb-2">
                            Telepon: {{ $storeSettings->phone_number ?? 'Nomor telepon belum diatur.' }}
                        </p>
                        <p class="card-text text-muted">
                            Email: {{ $storeSettings->email ?? 'Email belum diatur.' }}
                        </p>
                        @if($storeSettings->whatsapp_number)
                            <a href="https://wa.me/{{ $storeSettings->whatsapp_number }}" target="_blank" class="btn btn-sm btn-success mt-2">
                                Hubungi via WhatsApp <i class="fab fa-whatsapp ms-1"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3"><i class="fas fa-clock text-primary me-2"></i>Jam Operasional</h5>
                        <p class="card-text text-muted">
                            {{ $storeSettings->operating_hours ?? 'Jam operasional belum diatur.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3"><i class="fas fa-info-circle text-primary me-2"></i>Tentang Kami</h5>
                        <p class="card-text text-muted">
                            {{ $storeSettings->about_us_description ?? 'Aresha Florist adalah toko papan karangan bunga terpercaya di Padang. Kami menyediakan Papan Rustic, Akrilik, dan Box untuk berbagai acara spesial Anda. Gratis ongkir sekota Padang!' }}
                        </p>
                        <div class="mt-3">
                            <h6 class="fw-bold mb-2">Kategori Produk:</h6>
                            <ul class="list-unstyled mb-0">
                                <li><i class="fas fa-check text-primary me-2"></i>Papan Rustic</li>
                                <li><i class="fas fa-check text-primary me-2"></i>Akrilik</li>
                                <li><i class="fas fa-check text-primary me-2"></i>Box</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @if($storeSettings->history)
            <div class="col-md-12">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3"><i class="fas fa-history text-primary me-2"></i>Sejarah Toko</h5>
                        <p class="card-text text-muted">
                            {{ $storeSettings->history }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            @if($storeSettings->vision || $storeSettings->mission)
            <div class="col-md-12">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3"><i class="fas fa-bullseye text-primary me-2"></i>Visi & Misi</h5>
                        @if($storeSettings->vision)
                            <h6>Visi:</h6>
                            <p class="card-text text-muted">{{ $storeSettings->vision }}</p>
                        @endif
                        @if($storeSettings->mission)
                            <h6 class="mt-3">Misi:</h6>
                            <p class="card-text text-muted">{{ $storeSettings->mission }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Store Gallery Section -->
@if($storeImages->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Galeri Toko Kami</h2>
            <p class="lead text-muted">Lihat suasana dan kreasi terbaik dari Aresha Florist.</p>
        </div>

        <div id="storeImageCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner rounded shadow-lg">
                @foreach($storeImages as $index => $image)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('storage/'.$image->image_path) }}"
                             class="d-block w-100 img-fluid" 
                             alt="Galeri Toko {{ $index + 1 }}"
                             style="max-height: 550px; object-fit: cover;">
                    </div>
                @endforeach
            </div>
            @if($storeImages->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#storeImageCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#storeImageCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>
        @if($storeImages->count() > 1)
            <div class="store-thumbnails mt-3 d-flex flex-wrap gap-2 justify-content-center">
                @foreach($storeImages as $index => $image)
                    <img src="{{ asset('storage/'.$image->image_path) }}"
                         class="img-thumbnail {{ $loop->first ? 'active' : '' }}"
                         alt="Galeri Toko Thumbnail {{ $index + 1 }}"
                         data-bs-target="#storeImageCarousel"
                         data-bs-slide-to="{{ $index }}"
                         style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                @endforeach
            </div>
        @endif
    </div>
</section>
@endif

@endsection
