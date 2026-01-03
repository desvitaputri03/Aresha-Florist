@extends('layouts.admin')

@section('title', 'Detail Pesanan - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-receipt me-2"></i>Detail Pesanan</h2>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <!-- Order Information -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>No. Pesanan:</strong></td>
                                <td>{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal:</strong></td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status Pesanan:</strong></td>
                                <td>
                                    @switch($order->order_status)
                                        @case('pending')
                                            <span class="badge bg-warning">Pending</span>
                                            @break
                                        @case('processing')
                                            <span class="badge bg-info">Processing</span>
                                            @break
                                        @case('shipped')
                                            <span class="badge bg-primary">Shipped</span>
                                            @break
                                        @case('delivered')
                                            <span class="badge bg-success">Delivered</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Status Pembayaran:</strong></td>
                                <td>
                                    @switch($order->payment_status)
                                        @case('pending')
                                            <span class="badge bg-warning">Pending</span>
                                            @break
                                        @case('paid')
                                            <span class="badge bg-success">Paid</span>
                                            @break
                                        @case('failed')
                                            <span class="badge bg-danger">Failed</span>
                                            @break
                                    @endswitch
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Metode Pembayaran:</strong></td>
                                <td>
                                    @if($order->payment_method == 'cash')
                                        <span class="badge bg-success">
                                            <i class="fas fa-money-bill-wave me-1"></i>Cash on Delivery
                                        </span>
                                    @else
                                        <span class="badge bg-primary">
                                            <i class="fas fa-university me-1"></i>Transfer Bank
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Admin:</strong></td>
                                <td>{{ $order->admin->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Customer:</strong></td>
                                <td>{{ $order->user->name ?? 'Guest' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pemesan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="120"><strong>Nama:</strong></td>
                                <td>{{ $order->customer_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $order->customer_email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon:</strong></td>
                                <td>{{ $order->customer_phone }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <strong>Alamat Pengiriman (Padang):</strong>
                            <p class="mt-2">{{ $order->customer_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Karangan Bunga (Florist Specific) -->
        <div class="card mb-4 border-info shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-flower me-2"></i>Detail Karangan Bunga</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Nama Penerima:</strong></td>
                                <td class="text-primary fw-bold">{{ $order->recipient_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Kirim:</strong></td>
                                <td class="text-danger fw-bold">
                                    {{ \Carbon\Carbon::parse($order->delivery_date)->format('d F Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Acara:</strong></td>
                                <td>{{ $order->event_type ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded border">
                            <strong class="text-dark d-block mb-2"><i class="fas fa-edit me-2"></i>Pesan di Papan (Custom Message):</strong>
                            <div class="p-3 bg-white border rounded shadow-sm" style="font-size: 1.1rem; border-left: 5px solid var(--primary-color) !important;">
                                <em class="text-dark">"{{ $order->custom_message }}"</em>
                            </div>
                        </div>
                        @if($order->notes)
                        <div class="mt-3">
                            <strong>Catatan Tambahan:</strong>
                            <p class="mt-1 text-muted">{{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Order Summary & Actions -->
    <div class="col-lg-4">
        <div class="card mb-4 shadow-sm border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Ringkasan Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal Produk:</span>
                    <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Biaya Pengiriman:</span>
                    <span class="text-success">Rp{{ number_format($order->shipping_cost, 0, ',', '.') }} (Gratis)</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0 fw-bold">TOTAL BAYAR:</span>
                    <span class="h4 text-primary fw-bold mb-0">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Update Status -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Update Status</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="order_status" class="form-label">Status Pesanan</label>
                        <select class="form-select" id="order_status" name="order_status" required>
                            <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="payment_status" class="form-label">Status Pembayaran</label>
                        <select class="form-select" id="payment_status" name="payment_status" required>
                            <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Payment Proof Image -->
        @if($order->proof_of_transfer_image)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Bukti Transfer</h5>
            </div>
            <div class="card-body text-center">
                <a href="{{ asset('storage/' . $order->proof_of_transfer_image) }}" target="_blank">
                    <img src="{{ asset('storage/' . $order->proof_of_transfer_image) }}" alt="Bukti Transfer" class="img-fluid rounded" style="max-height: 300px;">
                </a>
                <p class="mt-2 text-muted">Klik gambar untuk melihat ukuran penuh</p>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection

