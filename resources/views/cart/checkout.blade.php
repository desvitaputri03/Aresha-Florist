@extends('layouts.store')

@section('title', 'Checkout - Aresha Florist')

@section('content')
<!-- Checkout Section -->
<section class="py-5 bg-light">
    <div class="container py-lg-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-5 text-center">
                    <h1 class="display-6 fw-bold mb-2" style="font-family: 'Playfair Display', serif;">Selesaikan Pesanan</h1>
                    <p class="text-muted">Isi detail pengiriman Anda di bawah ini</p>
                </div>

                <form action="{{ route('cart.process-checkout') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4 border-radius-sm">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row g-4">
                        <!-- Customer Information -->
                        <div class="col-lg-7">
                            <div class="card border-0 shadow-sm p-4 h-100">
                                <h5 class="fw-bold mb-4 h6 text-uppercase ls-wide" style="color: var(--primary-color);">
                                    <i class="fas fa-user-edit me-2"></i>Informasi Pemesan
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="nama" class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg fs-6 @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', auth()->user()->name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="telepon" class="form-label small fw-bold">No. WhatsApp/Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg fs-6 @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', auth()->user()->phone) }}" required>
                                </div>


                                <div class="mb-3">
                                    <label for="alamat" class="form-label small fw-bold">Alamat Lengkap di Padang <span class="text-danger">*</span></label>
                                    <textarea class="form-control fs-6 @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="4" required>{{ old('alamat', auth()->user()->address) }}</textarea>
                                </div>

                                <hr class="my-4">

                                <h5 class="fw-bold mb-4 h6 text-uppercase ls-wide" style="color: var(--primary-color);">
                                    <i class="fas fa-calendar-check me-2"></i>Detail Pesanan
                                </h5>

                                <div class="mb-3">
                                    <label for="delivery_date" class="form-label small fw-bold">Tanggal Pengiriman <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-lg fs-6 @error('delivery_date') is-invalid @enderror" id="delivery_date" name="delivery_date" value="{{ old('delivery_date') }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="recipient_name" class="form-label small fw-bold">Nama Penerima <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control fs-6 @error('recipient_name') is-invalid @enderror" id="recipient_name" name="recipient_name" value="{{ old('recipient_name') }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="event_type" class="form-label small fw-bold">Jenis Acara <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control fs-6 @error('event_type') is-invalid @enderror" id="event_type" name="event_type" value="{{ old('event_type') }}" required>
                                    </div>
                                </div>

                                <div class="mb-0">
                                    <label for="custom_message" class="form-label small fw-bold">Isi Pesan / Ucapan <span class="text-danger">*</span></label>
                                    <textarea class="form-control fs-6 @error('custom_message') is-invalid @enderror" id="custom_message" name="custom_message" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary & Payment -->
                        <div class="col-lg-5">
                            <!-- Summary -->
                            <div class="card border-0 shadow-sm p-4 mb-4">
                                <h5 class="fw-bold mb-4 h6 text-uppercase ls-wide" style="color: var(--primary-color);">Ringkasan Pesanan</h5>
                                
                                @foreach($cartItems as $item)
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="small flex-grow-1">
                                        <div class="fw-bold">{{ $item->product->name }}</div>
                                        <div class="text-muted">
                                            @if($item->is_combined_order)
                                                @if($item->combined_quantity)
                                                    Papan Gandeng ({{ $item->combined_quantity }} papan)
                                                @elseif($item->combined_custom_request)
                                                    Papan Gandeng (Custom)
                                                @endif
                                            @else
                                                {{ $item->quantity }}x
                                            @endif
                                        </div>
                                        @if($item->combined_custom_request)
                                            <div class="text-info small mt-1">
                                                <i class="fas fa-info-circle me-1"></i>
                                                {{ Str::limit($item->combined_custom_request, 50) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="fw-bold fs-5">
                                        @php
                                            $price = $item->product->harga_diskon ?? $item->product->harga;
                                            $itemTotal = $price * $item->quantity;
                                        @endphp
                                        Rp{{ number_format($itemTotal, 0, ',', '.') }}
                                    </div>
                                </div>
                                @endforeach

                                <hr class="my-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small text-muted">Subtotal:</span>
                                    <span class="small fw-bold">Rp{{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="small text-muted">Ongkos Kirim (Padang):</span>
                                    <span class="small fw-bold text-success">Gratis</span>
                                </div>
                                <div class="d-flex justify-content-between py-3 border-top">
                                    <span class="h5 fw-bold mb-0">Total Bayar:</span>
                                    <span class="h4 fw-bold mb-0" style="color: var(--accent-pink);">Rp{{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="card border-0 shadow-sm p-4">
                                <h5 class="fw-bold mb-4 h6 text-uppercase ls-wide" style="color: var(--primary-color);">Metode Pembayaran</h5>
                                
                                <div class="payment-options">
                                    <div class="form-check custom-option mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="transfer" required>
                                        <label class="form-check-label ps-2" for="transfer">
                                            <div class="fw-bold small">Transfer Bank</div>
                                            <div class="text-muted extra-small">Kirim bukti via sistem/WhatsApp</div>
                                        </label>
                                    </div>
                                    <div class="form-check custom-option mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod">
                                        <label class="form-check-label ps-2" for="cod">
                                            <div class="fw-bold small">Cash on Delivery (COD)</div>
                                            <div class="text-muted extra-small">Bayar di tempat saat barang sampai</div>
                                        </label>
                                    </div>
                                    <div class="form-check custom-option">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash">
                                        <label class="form-check-label ps-2" for="cash">
                                            <div class="fw-bold small">Bayar di Toko</div>
                                            <div class="text-muted extra-small">Ambil dan bayar langsung ke toko</div>
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 mt-4 border-radius-sm fw-bold ls-wide" style="background: var(--primary-color); border: none;">
                                    KONFIRMASI PESANAN
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    .ls-wide { letter-spacing: 0.1em; }
    .extra-small { font-size: 0.75rem; }
    .custom-option {
        padding: 1.25rem;
        border: 1px solid #eee;
        border-radius: 4px;
        transition: var(--transition);
        cursor: pointer;
    }
    .custom-option:hover {
        border-color: var(--accent-color);
        background: var(--secondary-color);
    }
    .form-check-input:checked + .form-check-label {
        color: var(--primary-color);
    }
    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="{{ route('cart.process-checkout') }}"]');
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const submitButton = form.querySelector('button[type="submit"]');
    
    // Validasi sebelum submit
    form.addEventListener('submit', function(e) {
        let paymentSelected = false;
        paymentMethods.forEach(function(radio) {
            if (radio.checked) {
                paymentSelected = true;
            }
        });
        
        if (!paymentSelected) {
            e.preventDefault();
            alert('Silakan pilih metode pembayaran terlebih dahulu!');
            return false;
        }
        
        // Disable submit button untuk mencegah double submission
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
    });
    
    // Highlight selected payment method
    paymentMethods.forEach(function(radio) {
        radio.addEventListener('change', function() {
            paymentMethods.forEach(function(r) {
                const option = r.closest('.custom-option');
                if (option) {
                    option.style.borderColor = '#eee';
                    option.style.backgroundColor = '';
                }
            });
            
            const selectedOption = this.closest('.custom-option');
            if (selectedOption) {
                selectedOption.style.borderColor = 'var(--accent-color)';
                selectedOption.style.backgroundColor = 'var(--secondary-color)';
            }
        });
    });
    
    // Set minimum date untuk delivery_date
    const deliveryDateInput = document.getElementById('delivery_date');
    if (deliveryDateInput) {
        const today = new Date().toISOString().split('T')[0];
        deliveryDateInput.setAttribute('min', today);
    }
});
</script>
@endsection