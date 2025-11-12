@extends('layouts.store')

@section('title', 'Detail Pesanan - Aresha Florist')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Detail Pesanan #{{ $order->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status Pesanan:</strong>
                        <span class="badge bg-{{ ($order->order_status === 'pending' || $order->order_status === 'pending_payment') ? 'warning' : ($order->order_status === 'delivered' ? 'success' : 'danger') }} ms-2">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <strong>Status Pembayaran:</strong>
                        @if ($order->payment_status === 'pending_transfer')
                            <span class="badge bg-warning ms-2">Menunggu Bukti Transfer</span>
                            @if ($order->payment_method === 'transfer')
                                <a href="{{ route('cart.payment.confirm', $order->id) }}" class="btn btn-sm btn-success ms-2">Unggah Bukti TF</a>
                            @endif
                        @elseif ($order->payment_status === 'awaiting_admin_approval')
                            <span class="badge bg-info ms-2">Menunggu Verifikasi Admin</span>
                        @elseif ($order->payment_status === 'paid')
                            <span class="badge bg-success ms-2">Lunas</span>
                        @else
                            <span class="badge bg-secondary ms-2">{{ ucfirst($order->payment_status) }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}
                    </div>
                    <div class="mb-3">
                        <strong>Alamat Pengiriman:</strong> {{ $order->customer_address }}
                    </div>
                    <div class="mb-3">
                        <strong>Total Harga:</strong> Rp{{ number_format($order->grand_total, 0, ',', '.') }}
                    </div>

                    @if ($order->payment_method === 'transfer' && $order->proof_of_transfer_image)
                        <div class="mb-3">
                            <strong>Bukti Transfer:</strong>
                            <div class="mt-2">
                                <a href="{{ asset('storage/'.$order->proof_of_transfer_image) }}" target="_blank">
                                    <img src="{{ asset('storage/'.$order->proof_of_transfer_image) }}" 
                                         alt="Bukti Transfer"
                                         class="img-fluid rounded" 
                                         style="max-height: 200px;">
                                </a>
                            </div>
                        </div>
                    @endif

                    <h5 class="mt-4">Item Pesanan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kuantitas</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <a href="{{ route('customer.orders') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Pesanan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
