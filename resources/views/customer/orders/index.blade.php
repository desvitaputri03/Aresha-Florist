@extends('layouts.store')

@section('title', 'Pesanan Saya - Aresha Florist')

@section('content')
<div class="dashboard-wrapper">
    <div class="dashboard-container">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('customer.dashboard') }}" class="text-muted text-decoration-none">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
            <h2 class="h4 mb-0 fw-bold" style="font-family: 'Playfair Display', serif;">Riwayat Pesanan Saya</h2>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
            <div class="card-body p-0">
                @if ($orders->isEmpty())
                    <div class="p-5 text-center">
                        <div class="mb-4 text-muted opacity-50" style="font-size: 3rem;">
                            <i class="fas fa-shopping-basket"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Belum Ada Pesanan</h5>
                        <p class="text-muted mb-4">Anda belum melakukan pemesanan apa pun di Aresha Florist.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-4" style="background: var(--primary-color); border: none;">Mulai Belanja</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0">Nomor Pesanan</th>
                                    <th class="py-3 border-0">Tanggal</th>
                                    <th class="py-3 border-0">Total</th>
                                    <th class="py-3 border-0">Status Pesanan</th>
                                    <th class="py-3 border-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="fw-bold text-dark">#{{ $order->id }}</span>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <span class="fw-bold text-primary">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
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
                                                {{ ucfirst($order->order_status === 'delivered' ? 'Selesai' : ($order->order_status === 'pending' ? 'Menunggu' : $order->order_status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="border-color: var(--primary-color); color: var(--primary-color);">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
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
    .table thead th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #666;
    }
    .table tbody td {
        padding: 1.25rem 0.75rem;
        font-size: 0.95rem;
    }
</style>
@endsection
