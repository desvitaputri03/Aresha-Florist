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
                <h5 class="mb-0">Informasi Customer</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nama:</strong></td>
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
                            <strong>Alamat:</strong>
                            <p class="mt-2">{{ $order->customer_address }}</p>
                        </div>
                        @if($order->notes)
                        <div class="mt-3">
                            <strong>Catatan:</strong>
                            <p class="mt-2">{{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Item Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product->gambar)
                                            <img src="{{ asset('storage/'.$item->product->gambar) }}" 
                                                 alt="{{ $item->product->nama_produk }}" 
                                                 class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $item->product->nama_produk }}</div>
                                            <small class="text-muted">{{ $item->product->category->nama_kategori ?? 'Kategori' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td><strong>Rp{{ number_format($item->total_price, 0, ',', '.') }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Summary & Actions -->
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Ringkasan Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Ongkir:</span>
                    <span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="h5 mb-0">Total:</span>
                    <span class="h5 text-primary fw-bold mb-0">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</span>
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

