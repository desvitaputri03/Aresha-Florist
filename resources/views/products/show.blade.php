@extends('layouts.store')

@section('title', $product->name . ' | Karangan Bunga Padang')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Karangan Bunga</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </div>
</nav>

<!-- Product Detail -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Product Image -->
            <div class="col-lg-6">
                <div class="product-image-container">
                    @if($product->gambar)
                        <img src="{{ asset('storage/'.$product->gambar) }}"
                             alt="{{ $product->name }}"
                             class="img-fluid rounded shadow-lg">
                    @else
                        <img src="https://via.placeholder.com/800x600?text=Karangan+Bunga+Aresha"
                             alt="{{ $product->name }}"
                             class="img-fluid rounded shadow-lg">
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <div class="mb-3">
                        <span class="badge bg-primary fs-6">{{ $product->category->name ?? 'Kategori' }}</span>
                    </div>

                    <h1 class="display-5 fw-bold mb-3">{{ $product->name }}</h1>

                    <div class="price-section mb-4">
                        @if($product->harga_diskon)
                            <div class="d-flex align-items-center gap-3">
                                <span class="h2 text-primary fw-bold mb-0">Rp{{ number_format($product->harga_diskon, 0, ',', '.') }}</span>
                                <span class="h5 text-muted text-decoration-line-through mb-0">Rp{{ number_format($product->harga, 0, ',', '.') }}</span>
                                <span class="badge bg-danger fs-6">
                                    -{{ round((($product->harga - $product->harga_diskon) / $product->harga) * 100) }}%
                                </span>
                            </div>
                        @else
                            <span class="h2 text-primary fw-bold">Rp{{ number_format($product->harga, 0, ',', '.') }}</span>
                        @endif
                    </div>

                    @if($product->deskripsi)
                        <div class="description mb-4">
                            <h5 class="fw-bold mb-3">Deskripsi Produk</h5>
                            <p class="text-muted lh-lg">{{ $product->deskripsi }}</p>
                        </div>
                    @endif

                    <div class="stock-info mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-box text-primary"></i>
                            <span class="fw-bold">Stok:</span>
                            @if($product->stok > 10)
                                <span class="badge bg-success fs-6">{{ $product->stok }} tersedia</span>
                            @elseif($product->stok > 0)
                                <span class="badge bg-warning fs-6">{{ $product->stok }} tersisa</span>
                            @else
                                <span class="badge bg-danger fs-6">Stok habis</span>
                            @endif
                        </div>
                    </div>

                    <div class="action-buttons">
                        @if($product->stok > 0)
                            <!-- Combinable Options Section -->
                            @if($product->is_combinable)
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-body bg-light rounded">
                                    <h5 class="card-title fw-bold mb-3"><i class="fas fa-puzzle-piece me-2 text-primary"></i>Opsi Papan Gabungan</h5>
                                    
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="is_combined_order_checkbox">
                                        <label class="form-check-label fw-bold" for="is_combined_order_checkbox">
                                            Pesan sebagai Papan Gabungan
                                        </label>
                                        <small class="form-text text-muted d-block">Centang ini jika Anda ingin memesan produk ini sebagai bagian dari papan gabungan.</small>
                                    </div>

                                    <div id="combinedOptionsDetails" style="display: none;">
                                        <div class="mb-3">
                                            <label for="combined_quantity_input_display" class="form-label">Jumlah Papan Gabungan (2 atau 3)</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   id="combined_quantity_input_display" 
                                                   min="2" 
                                                   max="3" 
                                                   value="2">
                                            <small class="form-text text-muted">Pilih berapa papan yang ingin Anda gabungkan.</small>
                                        </div>
                                        @if($product->combined_description)
                                        <div class="alert alert-info border-0 rounded-3 small">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <p class="mb-0">{{ $product->combined_description }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- End Combinable Options Section -->

                            <div class="d-flex gap-3 mb-3">
                                <div class="input-group" style="width: 120px;">
                                    <button class="btn btn-outline-primary" type="button" onclick="decreaseQuantity()">-</button>
                                    <input type="number" id="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->stok }}">
                                    <button class="btn btn-outline-primary" type="button" onclick="increaseQuantity()">+</button>
                                </div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-grow-1 d-flex gap-3">
                                    @csrf
                                    <input type="hidden" name="quantity" id="quantity-input" value="1">
                                    <input type="hidden" name="is_combined_order_input" id="is_combined_order_hidden" value="0">
                                    <input type="hidden" name="combined_quantity_input" id="combined_quantity_hidden" value="">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-shopping-cart me-2"></i>Tambahkan ke Keranjang
                                    </button>
                                    <input type="hidden" name="redirect" value="checkout" form="buy-now-form">
                                </form>
                                <form id="buy-now-form" action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" id="buy-now-quantity" value="1">
                                    <input type="hidden" name="is_combined_order_input" id="buy-now-is-combined-order-hidden" value="0">
                                    <input type="hidden" name="combined_quantity_input" id="buy-now-combined-quantity-hidden" value="">
                                    <input type="hidden" name="redirect" value="checkout">
                                    <button type="submit" class="btn btn-accent btn-lg">
                                        <i class="fas fa-bolt me-2"></i>Beli Sekarang
                                    </button>
                                </form>
                            </div>
                        @else
                            <button class="btn btn-secondary btn-lg w-100" disabled>
                                <i class="fas fa-times me-2"></i>Stok Habis
                            </button>
                        @endif

                        <div class="d-flex gap-2">
                            <a href="https://wa.link/sylqcm" class="btn btn-outline-primary">
                                <i class="fas fa-phone me-2"></i>Hubungi Kami
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Karangan Bunga
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Karangan Bunga Serupa</h2>
            <p class="lead text-muted">Karangan bunga lain dalam kategori yang sama</p>
        </div>

        <div class="row g-4">
            @foreach($relatedProducts as $relatedProduct)
            <div class="col-lg-3 col-md-6">
                <div class="product-card fade-in-up">
                    <div class="position-relative">
                        @if($relatedProduct->gambar)
                            <img src="{{ asset('storage/'.$relatedProduct->gambar) }}"
                                 alt="{{ $relatedProduct->name }}"
                                 class="img-fluid">
                        @else
                            <img src="https://via.placeholder.com/500x500?text=Karangan+Bunga+Aresha"
                                 alt="{{ $relatedProduct->name }}"
                                 class="img-fluid">
                        @endif
                        @if($relatedProduct->harga_diskon)
                            <div class="product-badge">
                                -{{ round((($relatedProduct->harga - $relatedProduct->harga_diskon) / $relatedProduct->harga) * 100) }}%
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-2">{{ $relatedProduct->name }}</h5>
                        <p class="text-muted mb-3">{{ Str::limit($relatedProduct->deskripsi, 60) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($relatedProduct->harga_diskon)
                                    <span class="h5 text-primary mb-0">Rp{{ number_format($relatedProduct->harga_diskon,0,',','.') }}</span>
                                    <small class="text-muted text-decoration-line-through ms-2">Rp{{ number_format($relatedProduct->harga,0,',','.') }}</small>
                                @else
                                    <span class="h5 text-primary mb-0">Rp{{ number_format($relatedProduct->harga,0,',','.') }}</span>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $relatedProduct->id) }}" class="btn-accent btn-sm">
                                <i class="fas fa-eye me-1"></i>Lihat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<script>
function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const max = parseInt(quantityInput.getAttribute('max'));
    const current = parseInt(quantityInput.value);
    if (current < max) {
        quantityInput.value = current + 1;
        updateQuantityInput();
    }
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const current = parseInt(quantityInput.value);
    if (current > 1) {
        quantityInput.value = current - 1;
        updateQuantityInput();
    }
}

// Update hidden input when quantity changes
function updateQuantityInput() {
    const quantity = document.getElementById('quantity').value;
    document.getElementById('quantity-input').value = quantity;
    const buyNowQty = document.getElementById('buy-now-quantity');
    if (buyNowQty) buyNowQty.value = quantity;

    // Update combined order hidden inputs
    const isCombinedOrderHidden = document.getElementById('is_combined_order_hidden');
    const combinedQuantityHidden = document.getElementById('combined_quantity_hidden');
    const buyNowIsCombinedOrderHidden = document.getElementById('buy-now-is-combined-order-hidden');
    const buyNowCombinedQuantityHidden = document.getElementById('buy-now-combined-quantity-hidden');

    const isCombinedOrderCheckbox = document.getElementById('is_combined_order_checkbox');
    const combinedQuantityDisplayInput = document.getElementById('combined_quantity_input_display');

    if (isCombinedOrderCheckbox && isCombinedOrderHidden && combinedQuantityHidden) {
        isCombinedOrderHidden.value = isCombinedOrderCheckbox.checked ? '1' : '0';
        if (isCombinedOrderCheckbox.checked && combinedQuantityDisplayInput) {
            combinedQuantityHidden.value = combinedQuantityDisplayInput.value;
        } else {
            combinedQuantityHidden.value = '';
        }
    }
    if (buyNowIsCombinedOrderHidden && buyNowCombinedQuantityHidden) {
        buyNowIsCombinedOrderHidden.value = isCombinedOrderCheckbox.checked ? '1' : '0';
        if (isCombinedOrderCheckbox.checked && combinedQuantityDisplayInput) {
            buyNowCombinedQuantityHidden.value = combinedQuantityDisplayInput.value;
        } else {
            buyNowCombinedQuantityHidden.value = '';
        }
    }
}

// Update quantity input on change
document.getElementById('quantity').addEventListener('change', updateQuantityInput);

// Toggle combinable fields visibility and update hidden inputs
document.addEventListener('DOMContentLoaded', function() {
    const isCombinableCheckbox = document.getElementById('is_combined_order_checkbox');
    const combinedOptionsDetails = document.getElementById('combinedOptionsDetails');
    const combinedQuantityDisplayInput = document.getElementById('combined_quantity_input_display');

    if (isCombinableCheckbox) {
        function toggleCombinedOptions() {
            if (isCombinableCheckbox.checked) {
                combinedOptionsDetails.style.display = 'block';
                // Set quantity to 1 for combined orders to ensure multiplier works correctly
                document.getElementById('quantity').value = 1;
                updateQuantityInput();
            } else {
                combinedOptionsDetails.style.display = 'none';
                // Reset quantity to 1 if user unchecks combined order
                document.getElementById('quantity').value = 1;
                updateQuantityInput();
            }
        }
        isCombinableCheckbox.addEventListener('change', toggleCombinedOptions);
        // Initial state update
        toggleCombinedOptions();
    }

    // Listen for changes on combined_quantity_input_display to update hidden input
    if (combinedQuantityDisplayInput) {
        combinedQuantityDisplayInput.addEventListener('change', updateQuantityInput);
    }
});

// Update cart count after add-to-cart submission
document.querySelectorAll('form[action*="cart.add"]').forEach(function(form) {
    form.addEventListener('submit', function() {
        setTimeout(function() {
            if (typeof updateCartCount === 'function') {
                updateCartCount();
            }
        }, 1000);
    });
});

// Animations
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
