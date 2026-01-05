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
            <!-- Product Image Gallery -->
            <div class="col-lg-6">
                <div id="productImageCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner rounded shadow-lg">
                        @forelse($product->images as $index => $image)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ asset('storage/'.$image->image_path) }}"
                                     class="d-block w-100 img-fluid" 
                                     alt="{{ $product->name }} - Image {{ $index + 1 }}"
                                     style="height: 500px; object-fit: cover;"> {{-- Mengubah menjadi cover dan height tetap 500px --}}
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <img src="https://via.placeholder.com/800x600?text=Karangan+Bunga+Aresha"
                                     class="d-block w-100 img-fluid" 
                                     alt="{{ $product->name }}"
                                     style="height: 500px; object-fit: cover;"> {{-- Mengubah menjadi cover dan height tetap 500px --}}
                            </div>
                        @endforelse
                    </div>
                    @if($product->images->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div>
                @if($product->images->count() > 1)
                    <div class="product-thumbnails mt-3 d-flex flex-wrap gap-2 justify-content-center">
                        @foreach($product->images as $index => $image)
                            <img src="{{ asset('storage/'.$image->image_path) }}"
                                 class="img-thumbnail {{ $loop->first ? 'active' : '' }}"
                                 alt="{{ $product->name }} Thumbnail {{ $index + 1 }}"
                                 data-bs-target="#productImageCarousel"
                                 data-bs-slide-to="{{ $index }}"
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
                        @endforeach
                    </div>
                @endif
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
                                    <h5 class="card-title fw-bold mb-3"><i class="fas fa-expand-arrows-alt me-2 text-primary"></i>Opsi Papan Gandeng (Double/Triple)</h5>
                                    
                                    <div class="alert alert-info border-0 rounded-3 mb-3 small">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Papan Gandeng</strong> adalah beberapa papan digabung menjadi satu kesatuan yang lebih lebar/panjang untuk tampilan yang lebih mewah dan menarik perhatian. Cocok untuk acara penting atau sebagai bentuk penghormatan khusus.
                                    </div>
                                    
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="is_combined_order_checkbox">
                                        <label class="form-check-label fw-bold" for="is_combined_order_checkbox">
                                            Pesan sebagai Papan Gandeng
                                        </label>
                                        <small class="form-text text-muted d-block">Centang untuk menggabungkan beberapa papan menjadi ukuran yang lebih besar (lebih lebar/panjang).</small>
                                    </div>

                                    <div id="combinedOptionsDetails" style="display: none;">
                                        <div class="mb-3">
                                            <label for="combined_quantity_input_display" class="form-label fw-bold">Jumlah Papan yang Digabung</label>
                                            <select class="form-select" id="combined_quantity_input_display">
                                                <option value="2" {{ old('combined_quantity_input', 2) == 2 ? 'selected' : '' }}>2 Papan (Double/Gandeng Dua) - Ukuran lebih lebar</option>
                                                <option value="3" {{ old('combined_quantity_input', 2) == 3 ? 'selected' : '' }}>3 Papan (Triple/Gandeng Tiga) - Ukuran ekstra lebar</option>
                                                <option value="custom">Custom (4+ papan atau ukuran khusus) - Hubungi kami</option>
                                            </select>
                                            <small class="form-text text-muted">Pilih jumlah papan yang ingin digabung. Untuk 4+ papan atau ukuran khusus, pilih "Custom" dan isi permintaan di bawah.</small>
                                        </div>
                                        
                                        <div id="customRequestSection" style="display: none;" class="mb-3">
                                            <label for="combined_custom_request_input" class="form-label fw-bold">Permintaan Khusus</label>
                                            <textarea class="form-control" 
                                                      id="combined_custom_request_input" 
                                                      rows="3" 
                                                      placeholder="Contoh: 4 papan digabung, atau ukuran 2m x 8m, atau permintaan khusus lainnya..."></textarea>
                                            <small class="form-text text-muted">Jelaskan ukuran atau jumlah papan yang Anda inginkan. Tim kami akan menghubungi Anda untuk konfirmasi harga.</small>
                                        </div>
                                        
                                        @if($product->combined_description)
                                        <div class="alert alert-warning border-0 rounded-3 small">
                                            <i class="fas fa-star me-2"></i>
                                            <p class="mb-0"><strong>Catatan:</strong> {{ $product->combined_description }}</p>
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
                                    <input type="number" id="quantity" class="form-control text-center" value="{{ old('quantity', 1) }}" min="1" max="{{ $product->stok }}">
                                    <button class="btn btn-outline-primary" type="button" onclick="increaseQuantity()">+</button>
                                </div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-grow-1 d-flex gap-3">
                                    @csrf
                                    <input type="hidden" name="quantity" id="quantity-input" value="1">
                                    <input type="hidden" name="is_combined_order_input" id="is_combined_order_hidden" value="0">
                                    <input type="hidden" name="combined_quantity_input" id="combined_quantity_hidden" value="">
                                    <input type="hidden" name="combined_custom_request_input" id="combined_custom_request_hidden" value="">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-shopping-cart me-2"></i>Tambahkan ke Keranjang
                                    </button>

                                </form>
                                <form id="buy-now-form" action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" id="buy-now-quantity" value="1">
                                    <input type="hidden" name="is_combined_order_input" id="buy-now-is-combined-order-hidden" value="0">
                                    <input type="hidden" name="combined_quantity_input" id="buy-now-combined-quantity-hidden" value="">
                                    <input type="hidden" name="combined_custom_request_input" id="buy-now-combined-custom-request-hidden" value="">
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
                <div class="product-card-premium fade-in-up bg-white shadow-sm">
                    <a href="{{ route('products.show', $relatedProduct->id) }}" class="card-img-wrapper d-block position-relative overflow-hidden">
                        @if($relatedProduct->images->count() > 0)
                            <img src="{{ asset('storage/'.$relatedProduct->images->first()->image_path) }}"
                                 alt="{{ $relatedProduct->name }}"
                                 class="product-img">
                        @else
                            <img src="https://via.placeholder.com/500x500?text=Karangan+Bunga+Aresha"
                                 alt="{{ $relatedProduct->name }}"
                                 class="product-img">
                        @endif
                        @if($relatedProduct->harga_diskon)
                            <div class="premium-badge discount">-{{ round((($relatedProduct->harga - $relatedProduct->harga_diskon) / $relatedProduct->harga) * 100) }}%</div>
                        @endif
                    </a>
                    <div class="p-3">
                        <h5 class="product-title fw-bold mb-2 text-center">
                            <a href="{{ route('products.show', $relatedProduct->id) }}" class="text-decoration-none text-dark">
                                {{ $relatedProduct->name }}
                            </a>
                        </h5>
                        <div class="product-price mb-3">
                            @if($relatedProduct->harga_diskon)
                                <span class="price-new">Rp {{ number_format($relatedProduct->harga_diskon, 0, ',', '.') }}</span>
                                <span class="price-old">Rp {{ number_format($relatedProduct->harga, 0, ',', '.') }}</span>
                            @else
                                <span class="price-new">Rp {{ number_format($relatedProduct->harga, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $relatedProduct->id) }}" class="btn btn-show-product">Lihat Detail</a>
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
    const combinedCustomRequestHidden = document.getElementById('combined_custom_request_hidden');
    const buyNowIsCombinedOrderHidden = document.getElementById('buy-now-is-combined-order-hidden');
    const buyNowCombinedQuantityHidden = document.getElementById('buy-now-combined-quantity-hidden');
    const buyNowCombinedCustomRequestHidden = document.getElementById('buy-now-combined-custom-request-hidden');

    const isCombinedOrderCheckbox = document.getElementById('is_combined_order_checkbox');
    const combinedQuantityDisplayInput = document.getElementById('combined_quantity_input_display');
    const combinedCustomRequestInput = document.getElementById('combined_custom_request_input');

    if (isCombinedOrderCheckbox && isCombinedOrderHidden && combinedQuantityHidden) {
        isCombinedOrderHidden.value = isCombinedOrderCheckbox.checked ? '1' : '0';
        if (isCombinedOrderCheckbox.checked && combinedQuantityDisplayInput) {
            const selectedValue = combinedQuantityDisplayInput.value;
            if (selectedValue === 'custom') {
                combinedQuantityHidden.value = '';
                if (combinedCustomRequestHidden && combinedCustomRequestInput) {
                    combinedCustomRequestHidden.value = combinedCustomRequestInput.value || '';
                }
            } else {
                combinedQuantityHidden.value = selectedValue;
                if (combinedCustomRequestHidden) {
                    combinedCustomRequestHidden.value = '';
                }
            }
        } else {
            combinedQuantityHidden.value = '';
            if (combinedCustomRequestHidden) {
                combinedCustomRequestHidden.value = '';
            }
        }
    }
    if (buyNowIsCombinedOrderHidden && buyNowCombinedQuantityHidden) {
        buyNowIsCombinedOrderHidden.value = isCombinedOrderCheckbox.checked ? '1' : '0';
        if (isCombinedOrderCheckbox.checked && combinedQuantityDisplayInput) {
            const selectedValue = combinedQuantityDisplayInput.value;
            if (selectedValue === 'custom') {
                buyNowCombinedQuantityHidden.value = '';
                if (buyNowCombinedCustomRequestHidden && combinedCustomRequestInput) {
                    buyNowCombinedCustomRequestHidden.value = combinedCustomRequestInput.value || '';
                }
            } else {
                buyNowCombinedQuantityHidden.value = selectedValue;
                if (buyNowCombinedCustomRequestHidden) {
                    buyNowCombinedCustomRequestHidden.value = '';
                }
            }
        } else {
            buyNowCombinedQuantityHidden.value = '';
            if (buyNowCombinedCustomRequestHidden) {
                buyNowCombinedCustomRequestHidden.value = '';
            }
        }
    }
}

// Update quantity input on change or input
document.getElementById('quantity').addEventListener('change', updateQuantityInput);
document.getElementById('quantity').addEventListener('input', updateQuantityInput);

// Toggle combinable fields visibility and update hidden inputs
document.addEventListener('DOMContentLoaded', function() {
    const isCombinableCheckbox = document.getElementById('is_combined_order_checkbox');
    const combinedOptionsDetails = document.getElementById('combinedOptionsDetails');
    const combinedQuantityDisplayInput = document.getElementById('combined_quantity_input_display');
    const customRequestSection = document.getElementById('customRequestSection');
    const combinedCustomRequestInput = document.getElementById('combined_custom_request_input');

    if (isCombinableCheckbox) {
        function toggleCombinedOptions() {
            if (isCombinableCheckbox.checked) {
                combinedOptionsDetails.style.display = 'block';
                // Set quantity to 1 for combined orders to ensure multiplier works correctly
                document.getElementById('quantity').value = 1;
                updateQuantityInput();
                // Check if custom is selected
                if (combinedQuantityDisplayInput && combinedQuantityDisplayInput.value === 'custom') {
                    if (customRequestSection) customRequestSection.style.display = 'block';
                }
            } else {
                combinedOptionsDetails.style.display = 'none';
                if (customRequestSection) customRequestSection.style.display = 'none';
                // Reset quantity to 1 if user unchecks combined order
                document.getElementById('quantity').value = 1;
                updateQuantityInput();
            }
        }
        isCombinableCheckbox.addEventListener('change', toggleCombinedOptions);
        // Initial state update
        toggleCombinedOptions();
    }

    // Handle combined quantity selection change
    if (combinedQuantityDisplayInput) {
        combinedQuantityDisplayInput.addEventListener('change', function() {
            if (this.value === 'custom') {
                if (customRequestSection) customRequestSection.style.display = 'block';
            } else {
                if (customRequestSection) customRequestSection.style.display = 'none';
            }
            updateQuantityInput();
        });
    }

    // Update custom request when typing
    if (combinedCustomRequestInput) {
        combinedCustomRequestInput.addEventListener('input', function() {
            updateQuantityInput();
        });
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

<style>
    /* Sembunyikan panah bawaan input number untuk Firefox */
    input[type='number'] {
        -moz-appearance: textfield;
    }
    /* Sembunyikan panah bawaan input number untuk Chrome, Safari, Edge */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    /* Sesuaikan lebar input group agar angka terlihat jelas */
    .action-buttons .input-group {
        width: 140px; /* Anda bisa menyesuaikan nilai ini jika diperlukan */
    }

    /* Product Card Styling */
    .product-card-premium {
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,.08);
        transition: all 0.3s ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .product-card-premium:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.15) !important;
    }

    .card-img-wrapper {
        position: relative;
        overflow: hidden;
        height: 300px;
        background: #f8f9fa;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card-premium:hover .product-img {
        transform: scale(1.1);
    }

    .premium-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #dc3545;
        color: white;
        padding: 8px 15px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 14px;
        z-index: 10;
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.4);
    }

    .product-title {
        font-size: 1.1rem;
        color: #2c3e50;
        min-height: 50px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-price {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .price-new {
        font-size: 1.3rem;
        font-weight: 700;
        color: #e91e63;
    }

    .price-old {
        font-size: 1rem;
        color: #999;
        text-decoration: line-through;
    }

    .btn-show-product {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-show-product:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(102, 126, 234, 0.4);
    }
</style>
@endsection
