@extends('layouts.store')

@section('title', 'Keranjang Belanja - Aresha Florist')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Keranjang Belanja</li>
        </ol>
    </div>
</nav>

<!-- Cart Section -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-5 fw-bold">
                <i class="fas fa-shopping-cart me-3"></i>Keranjang Belanja
            </h1>
            @if($cartItems->count() > 0)
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                        <i class="fas fa-trash me-2"></i>Kosongkan Keranjang
                    </button>
                </form>
            @endif
        </div>

        @if($cartItems->count() > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @foreach($cartItems as $item)
                        <div class="cart-item border-bottom pb-4 mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    @if($item->product->images->count() > 0)
                                        <img src="{{ asset('storage/'.$item->product->images->first()->image_path) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="img-fluid rounded">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1518895949257-7621c3c786d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" 
                                             alt="{{ $item->product->name }}" 
                                             class="img-fluid rounded">
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h5 class="fw-bold mb-2">{{ $item->product->name }}</h5>
                                    <p class="text-muted mb-2">{{ Str::limit($item->product->deskripsi, 80) }}</p>
                                    @if($item->is_combined_order)
                                        <div class="mb-2">
                                            <span class="badge bg-primary">
                                                <i class="fas fa-expand-arrows-alt me-1"></i>
                                                Papan Gandeng
                                                @if($item->combined_quantity)
                                                    ({{ $item->combined_quantity }} Papan)
                                                @elseif($item->combined_custom_request)
                                                    (Custom)
                                                @endif
                                            </span>
                                        </div>
                                        @if($item->combined_custom_request)
                                            <div class="alert alert-info py-2 px-3 mb-2 small">
                                                <strong>Permintaan Khusus:</strong><br>
                                                {{ $item->combined_custom_request }}
                                            </div>
                                        @endif
                                    @endif
                                    <small class="text-muted">
                                        <i class="fas fa-tag me-1"></i>{{ $item->product->category->name ?? 'Kategori' }}
                                    </small>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" 
                                                   name="quantity" 
                                                   value="{{ $item->quantity }}" 
                                                   min="1" 
                                                   max="{{ $item->product->stok }}"
                                                   class="form-control text-center" 
                                                   style="width: 80px;"
                                                   onchange="this.form.submit()">
                                        </form>
                                    </div>
                                    <small class="text-muted">Stok: {{ $item->product->stok }}</small>
                                </div>
                                <div class="col-md-2 text-center">
                                    @php
                                        $price = $item->product->harga_diskon ?? $item->product->harga;
                                        // Apply combined board pricing
                                        if ($item->is_combined_order && $item->product->is_combinable) {
                                            if ($item->combined_quantity) {
                                                $itemTotal = ($price * ($item->product->combinable_multiplier ?? 1)) * $item->quantity;
                                            } elseif ($item->combined_custom_request) {
                                                // Custom request - use conservative estimate
                                                $itemTotal = ($price * ($item->product->combinable_multiplier ?? 3)) * $item->quantity;
                                            } else {
                                                $itemTotal = $price * $item->quantity;
                                            }
                                        } else {
                                            $itemTotal = $price * $item->quantity;
                                        }
                                    @endphp
                                    <div class="fw-bold text-primary">Rp{{ number_format($itemTotal, 0, ',', '.') }}</div>
                                    @if($item->combined_custom_request)
                                        <small class="text-warning d-block mt-1">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Harga akan dikonfirmasi
                                        </small>
                                    @endif
                                    @if($item->product->harga_diskon && !$item->is_combined_order)
                                        <small class="text-muted text-decoration-line-through">
                                            Rp{{ number_format($item->product->harga * $item->quantity, 0, ',', '.') }}
                                        </small>
                                    @endif
                                </div>
                                <div class="col-md-2 text-center">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus item ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>Ringkasan Belanja
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Item:</span>
                            <span class="fw-bold">{{ $cartItems->sum('quantity') }} item</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal:</span>
                            <span class="fw-bold">Rp{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Ongkir:</span>
                            <span class="fw-bold">Gratis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 mb-0">Total:</span>
                            <span class="h5 text-primary fw-bold mb-0">Rp{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-credit-card me-2"></i>Lanjut ke Checkout
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary w-100 mt-2">
                            <i class="fas fa-arrow-left me-2"></i>Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-cart text-muted" style="font-size: 5rem;"></i>
            </div>
            <h3 class="text-muted mb-3">Keranjang Belanja Kosong</h3>
            <p class="text-muted mb-4">Belum ada produk di keranjang Anda. Mari mulai berbelanja!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
            </a>
        </div>
        @endif
    </div>
</section>
@endsection

