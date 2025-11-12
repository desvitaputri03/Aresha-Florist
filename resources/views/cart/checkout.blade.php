@extends('layouts.store')

@section('title', 'Checkout - Aresha Florist')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Keranjang</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </div>
</nav>

<!-- Checkout Section -->
<section class="py-5">
    <div class="container">
        <h1 class="display-5 fw-bold mb-4">
            <i class="fas fa-credit-card me-3"></i>Checkout
        </h1>

        <form action="{{ route('cart.process-checkout') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <!-- Customer Information -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2"></i>Informasi Pelanggan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('nama') is-invalid @enderror" 
                                               id="nama" 
                                               name="nama" 
                                               value="{{ old('nama') }}" 
                                               required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telepon" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('telepon') is-invalid @enderror" 
                                               id="telepon" 
                                               name="telepon" 
                                               value="{{ old('telepon') }}" 
                                               required>
                                        @error('telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                                  id="alamat" 
                                                  name="alamat" 
                                                  rows="3" 
                                                  required>{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan Pesanan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                          id="catatan" 
                                          name="catatan" 
                                          rows="3" 
                                          placeholder="Catatan khusus untuk pesanan (opsional)">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-credit-card me-2"></i>Metode Pembayaran
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" {{ old('payment_method') == 'cash' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cash">
                                            <i class="fas fa-money-bill-wave me-2"></i><strong>Cash on Delivery (COD)</strong>
                                            <br><small class="text-muted">Bayar saat barang diterima</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="transfer" value="transfer" {{ old('payment_method') == 'transfer' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="transfer">
                                            <i class="fas fa-university me-2"></i><strong>Transfer Bank</strong>
                                            <br><small class="text-muted">Transfer ke rekening admin</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="transfer-info" class="alert alert-info" style="display: none;">
                                <h6><i class="fas fa-info-circle me-2"></i>Informasi Transfer:</h6>
                                <p class="mb-2"><strong>Bank:</strong> BCA</p>
                                <p class="mb-2"><strong>No. Rekening:</strong> 1234567890</p>
                                <p class="mb-2"><strong>Atas Nama:</strong> Aresha Florist</p>
                                <p class="mb-0"><strong>Catatan:</strong> Transfer sesuai total pesanan dan konfirmasi melalui WhatsApp</p>
                            </div>
                            
                            <div id="cash-info" class="alert alert-success">
                                <h6><i class="fas fa-truck me-2"></i>Cash on Delivery:</h6>
                                <p class="mb-0">Pembayaran dilakukan saat barang diterima. Driver akan memberikan struk pembayaran.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-receipt me-2"></i>Ringkasan Pesanan
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item->product->name }}</h6>
                                    <small class="text-muted">{{ $item->quantity }}x</small>
                                </div>
                                <div class="text-end">
                                    @php
                                        $price = $item->product->harga_diskon ?? $item->product->harga;
                                        $itemTotal = $price * $item->quantity;
                                    @endphp
                                    <div class="fw-bold">Rp{{ number_format($itemTotal, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            @endforeach
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Ongkir:</span>
                                <span class="text-success">Gratis</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="h5 mb-0">Total:</span>
                                <span class="h5 text-primary fw-bold mb-0">Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-check me-2"></i>Konfirmasi Pesanan
                            </button>
                            
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
// Toggle payment method info
document.addEventListener('DOMContentLoaded', function() {
    const cashRadio = document.getElementById('cash');
    const transferRadio = document.getElementById('transfer');
    const cashInfo = document.getElementById('cash-info');
    const transferInfo = document.getElementById('transfer-info');

    function togglePaymentInfo() {
        if (cashRadio.checked) {
            cashInfo.style.display = 'block';
            transferInfo.style.display = 'none';
        } else if (transferRadio.checked) {
            cashInfo.style.display = 'none';
            transferInfo.style.display = 'block';
        } else {
            // If no radio is checked, hide both info sections
            cashInfo.style.display = 'none';
            transferInfo.style.display = 'none';
        }
    }

    cashRadio.addEventListener('change', togglePaymentInfo);
    transferRadio.addEventListener('change', togglePaymentInfo);
    
    // Initial state based on previously selected value (if any)
    togglePaymentInfo();
});
</script>
@endsection
