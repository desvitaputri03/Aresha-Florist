@extends('layouts.store')

@section('title', 'Pesanan Saya - Aresha Florist')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Pesanan Saya</h4>
                </div>
                <div class="card-body">
                    @if ($orders->isEmpty())
                        <div class="alert alert-info">Anda belum memiliki pesanan.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status Pesanan</th>
                                        <th>Status Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                            <td>Rp{{ number_format($order->grand_total, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge bg-{{ ($order->order_status === 'pending' || $order->order_status === 'pending_payment') ? 'warning' : ($order->order_status === 'delivered' ? 'success' : 'danger') }}">
                                                    {{ ucfirst($order->order_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($order->payment_status === 'pending_transfer')
                                                    <span class="badge bg-warning">Menunggu Bukti TF</span>
                                                @elseif ($order->payment_status === 'awaiting_admin_approval')
                                                    <span class="badge bg-info">Menunggu Verifikasi Admin</span>
                                                @elseif ($order->payment_status === 'paid')
                                                    <span class="badge bg-success">Lunas</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($order->payment_status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-sm btn-accent-outline">Lihat Detail</a>
                                                @if ($order->payment_method === 'transfer' && $order->payment_status === 'pending_transfer')
                                                    <a href="{{ route('cart.payment.confirm', $order->id) }}" class="btn btn-sm btn-success mt-1">Unggah Bukti TF</a>
                                                @endif
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
</div>
@endsection
