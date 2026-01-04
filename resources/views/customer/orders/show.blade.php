@extends('layouts.store')

@section('title', 'Detail Pesanan - Aresha Florist')

@section('content')
<div class="dashboard-wrapper">
    <div class="dashboard-container">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('customer.orders') }}" class="text-muted text-decoration-none">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat Pesanan
            </a>
            <h2 class="h4 mb-0 fw-bold" style="font-family: 'Playfair Display', serif;">Detail Pesanan #{{ $order->id }}</h2>
        </div>

        <div class="row g-4">
            <!-- Order Information -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 20px;">
                    <h5 class="fw-bold mb-4 text-uppercase ls-wide small" style="color: var(--primary-color);">Informasi Pesanan</h5>
                    
                    <div class="mb-3">
                        <label class="small text-muted d-block mb-1">Status Pesanan</label>
                        @php
                            $statusClass = [
                                'pending' => 'bg-warning text-dark',
                                'pending_payment' => 'bg-warning text-dark',
                                'processing' => 'bg-info text-white',
                                'shipped' => 'bg-primary text-white',
                                'delivered' => 'bg-success text-white',
                                'canceled' => 'bg-danger text-white'
                            ][$order->order_status] ?? 'bg-secondary text-white';
                        @endphp
                        <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted d-block mb-1">Status Pembayaran</label>
                        @php
                            $paymentStatusMap = [
                                'pending' => 'Pending',
                                'pending_transfer' => 'Menunggu Transfer',
                                'awaiting_admin_approval' => 'Menunggu Verifikasi',
                                'paid' => 'Lunas',
                                'failed' => 'Gagal'
                            ];
                            $paymentStatusDisplay = $paymentStatusMap[$order->payment_status] ?? ucfirst($order->payment_status);
                            $badgeClass = match($order->payment_status) {
                                'pending', 'pending_transfer' => 'bg-warning text-dark',
                                'awaiting_admin_approval' => 'bg-info text-white',
                                'paid' => 'bg-success text-white',
                                'failed' => 'bg-danger text-white',
                                default => 'bg-secondary text-white'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill">{{ $paymentStatusDisplay }}</span>
                        
                        @if (($order->payment_status === 'pending' || $order->payment_status === 'pending_transfer') && $order->payment_method === 'transfer')
                            <div class="mt-2">
                                <a href="{{ route('cart.payment.confirm', $order->id) }}" class="btn btn-sm btn-success w-100 rounded-pill">
                                    <i class="fas fa-upload me-1"></i>Unggah Bukti Transfer
                                </a>
                            </div>
                        @endif
                        
                        @if ($order->payment_status === 'awaiting_admin_approval' && $order->payment_method === 'transfer')
                            <div class="mt-2 text-muted small">
                                <i class="fas fa-info-circle me-1"></i>Bukti transfer Anda sedang diverifikasi oleh admin
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted d-block mb-1">Tanggal Pesanan</label>
                        <span class="fw-bold">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>

                    <div class="mb-0">
                        <label class="small text-muted d-block mb-1">Alamat Pengiriman</label>
                        <span class="fw-bold">{{ $order->customer_address }}</span>
                    </div>
                </div>

                @if ($order->payment_method === 'transfer' && $order->proof_of_transfer_image)
                    <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
                        <h5 class="fw-bold mb-4 text-uppercase ls-wide small" style="color: var(--primary-color);">Bukti Transfer</h5>
                        <a href="{{ asset('storage/'.$order->proof_of_transfer_image) }}" target="_blank">
                            <img src="{{ asset('storage/'.$order->proof_of_transfer_image) }}" 
                                 alt="Bukti Transfer"
                                 class="img-fluid rounded-3 shadow-sm">
                        </a>
                    </div>
                @endif
            </div>

            <!-- Order Items -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                    <div class="card-body p-0">
                        <div class="p-4 bg-light border-bottom">
                            <h5 class="fw-bold mb-0 text-uppercase ls-wide small" style="color: var(--primary-color);">Item Pesanan</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 border-0">Produk</th>
                                        <th class="py-3 border-0 text-center">Qty</th>
                                        <th class="py-3 border-0 text-end">Harga</th>
                                        <th class="py-3 border-0 text-end pe-4">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold text-dark">{{ $item->product->name }}</div>
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-end">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="text-end pe-4 fw-bold text-primary">
                                                Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light">
                                    <tr>
                                        <td colspan="3" class="ps-4 py-3 fw-bold text-uppercase small">Total Bayar</td>
                                        <td class="pe-4 py-3 text-end fw-bold h4 text-primary mb-0">
                                            Rp{{ number_format($order->grand_total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-wrapper {
        background: linear-gradient(135deg, #FFF7F5 0%, #ffffff 100%);
        min-height: calc(100vh - 200px);
        padding: 3rem 0;
    }
    .ls-wide { letter-spacing: 0.1em; }
    .table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #666;
    }
</style>
@endsection
