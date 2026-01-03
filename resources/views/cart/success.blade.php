@extends('layouts.store')

@section('title', 'Pesanan Berhasil | Aresha Florist')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg overflow-hidden fade-in-up" style="border-radius: 20px;">
                <div class="card-header bg-primary text-white text-center py-5 border-0">
                    <div class="mb-3">
                        <i class="fas fa-check-circle fa-5x"></i>
                    </div>
                    <h2 class="fw-bold">Pesanan Berhasil Dibuat!</h2>
                    <p class="lead mb-0">Terima kasih atas kepercayaan Anda pada Aresha Florist</p>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    @if(session('success'))
                        <div class="alert alert-success border-0 rounded-4 mb-4 text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="order-summary mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                            <div>
                                <h5 class="fw-bold mb-1">Nomor Pesanan</h5>
                                <p class="text-muted mb-0">#{{ $order->order_number }}</p>
                            </div>
                            <div class="text-end">
                                <h5 class="fw-bold mb-1">Tanggal Pesanan</h5>
                                <p class="text-muted mb-0">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-uppercase small text-primary mb-3">Detail Pengiriman</h6>
                                <div class="bg-light p-3 rounded-3 h-100">
                                    <p class="mb-1"><strong>Penerima:</strong> {{ $order->recipient_name }}</p>
                                    <p class="mb-1"><strong>Acara:</strong> {{ $order->event_type }}</p>
                                    <p class="mb-1"><strong>Tanggal Kirim:</strong> {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</p>
                                    <p class="mb-0"><strong>Alamat:</strong> {{ $order->customer_address }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-uppercase small text-primary mb-3">Detail Pemesan</h6>
                                <div class="bg-light p-3 rounded-3 h-100">
                                    <p class="mb-1"><strong>Nama:</strong> {{ $order->customer_name }}</p>
                                    <p class="mb-1"><strong>Telepon:</strong> {{ $order->customer_phone }}</p>
                                    <p class="mb-0"><strong>Metode Bayar:</strong> {{ strtoupper($order->payment_method) }}</p>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold text-uppercase small text-primary mb-3">Item Pesanan</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-borderless align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Produk</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end pe-3">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center">
                                                @if($item->product->images->count() > 0)
                                                    <img src="{{ asset('storage/'.$item->product->images->first()->image_path) }}" 
                                                         class="rounded-3 me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <p class="fw-bold mb-0">{{ $item->product->name }}</p>
                                                    <small class="text-muted">Rp{{ number_format($item->price, 0, ',', '.') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end pe-3">Rp{{ number_format($item->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-top">
                                    <tr>
                                        <td colspan="2" class="text-end fw-bold py-3">Total Pembayaran</td>
                                        <td class="text-end fw-bold text-primary py-3 pe-3 fs-5">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="text-center mt-5 d-grid gap-3 d-md-flex justify-content-center">
                            @if($order->payment_method === 'transfer' && $order->payment_status === 'pending_transfer')
                                <a href="{{ route('cart.payment.confirm', $order->id) }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                                    Unggah Bukti Transfer
                                </a>
                            @endif
                            <a href="{{ url('/') }}" class="btn btn-outline-dark btn-lg px-5 rounded-pill">
                                Kembali ke Beranda
                            </a>
                            <a href="https://wa.me/6281374428198?text=Halo%20Aresha%20Florist,%20saya%20ingin%20konfirmasi%20pesanan%20%23{{ $order->order_number }}" 
                               target="_blank" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm">
                                <i class="fab fa-whatsapp me-2"></i>Konfirmasi WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-primary { background-color: var(--primary-color) !important; }
    .text-primary { color: var(--primary-color) !important; }
    .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
    .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
</style>
@endsection
