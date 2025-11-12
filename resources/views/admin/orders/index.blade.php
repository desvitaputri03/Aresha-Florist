@extends('layouts.admin')

@section('title', 'Kelola Pesanan - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-shopping-cart me-2"></i>Kelola Pesanan</h2>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary" onclick="loadStatistics()">
            <i class="fas fa-chart-bar me-2"></i>Statistik
        </button>
    </div>
</div>

<!-- Statistics Card -->
<div id="statistics-card" class="card mb-4" style="display: none;">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Statistik Pesanan</h5>
    </div>
    <div class="card-body">
        <div class="row" id="statistics-content">
            <!-- Statistics will be loaded here -->
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Cari</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ $filters['search'] }}" placeholder="No. pesanan, nama, email...">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status Pesanan</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $filters['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $filters['status'] == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $filters['status'] == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $filters['status'] == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $filters['status'] == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="payment_method" class="form-label">Metode Pembayaran</label>
                <select class="form-select" id="payment_method" name="payment_method">
                    <option value="">Semua Metode</option>
                    <option value="cash" {{ $filters['payment_method'] == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="transfer" {{ $filters['payment_method'] == 'transfer' ? 'selected' : '' }}>Transfer</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="payment_status" class="form-label">Status Pembayaran</label>
                <select class="form-select" id="payment_status" name="payment_status">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $filters['payment_status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $filters['payment_status'] == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $filters['payment_status'] == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="sort" class="form-label">Urutkan</label>
                <select class="form-select" id="sort" name="sort">
                    <option value="latest" {{ $filters['sort'] == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ $filters['sort'] == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="total_asc" {{ $filters['sort'] == 'total_asc' ? 'selected' : '' }}>Total ↑</option>
                    <option value="total_desc" {{ $filters['sort'] == 'total_desc' ? 'selected' : '' }}>Total ↓</option>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Pesanan ({{ $orders->total() }} pesanan)</h5>
    </div>
    <div class="card-body">
        @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Metode Pembayaran</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pesanan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <strong>{{ $order->order_number }}</strong>
                        </td>
                        <td>
                            <div>
                                @if($order->user)
                                    <div class="fw-bold">
                                        <a href="{{ route('admin.users.show', $order->user->id) }}" class="text-decoration-underline text-primary">
                                            {{ $order->user->name }}
                                        </a>
                                    </div>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                @else
                                    <div class="fw-bold">{{ $order->customer_name }}</div>
                                    <small class="text-muted">{{ $order->customer_email }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <strong>Rp{{ number_format($order->grand_total, 0, ',', '.') }}</strong>
                        </td>
                        <td>
                            @if($order->payment_method == 'cash')
                                <span class="badge" style="background: linear-gradient(90deg, #E573A6 60%, #F6A3B9 100%); color: #fff;">
                                    <i class="fas fa-money-bill-wave me-1"></i>Cash
                                </span>
                            @else
                                <span class="badge" style="background: linear-gradient(90deg, #FFD966 60%, #E573A6 100%); color: #B94E7A;">
                                    <i class="fas fa-university me-1"></i>Transfer
                                </span>
                            @endif
                        </td>
                        <td>
                            @switch($order->payment_status)
                                @case('pending')
                                    <span class="badge" style="background: linear-gradient(90deg, #FFD966 60%, #E573A6 100%); color: #B94E7A;">Pending</span>
                                    @break
                                @case('paid')
                                    <span class="badge" style="background: linear-gradient(90deg, #A8D5BA 60%, #E573A6 100%); color: #fff;">Paid</span>
                                    @break
                                @case('failed')
                                    <span class="badge" style="background: linear-gradient(90deg, #E573A6 60%, #B94E7A 100%); color: #fff;">Failed</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            @switch($order->order_status)
                                @case('pending')
                                    <span class="badge" style="background: linear-gradient(90deg, #FFD966 60%, #E573A6 100%); color: #B94E7A;">Pending</span>
                                    @break
                                @case('processing')
                                    <span class="badge" style="background: linear-gradient(90deg, #F6A3B9 60%, #A8D5BA 100%); color: #fff;">Processing</span>
                                    @break
                                @case('shipped')
                                    <span class="badge" style="background: linear-gradient(90deg, #E573A6 60%, #FFD966 100%); color: #B94E7A;">Shipped</span>
                                    @break
                                @case('delivered')
                                    <span class="badge" style="background: linear-gradient(90deg, #A8D5BA 60%, #E573A6 100%); color: #fff;">Delivered</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge" style="background: linear-gradient(90deg, #E573A6 60%, #B94E7A 100%); color: #fff;">Cancelled</span>
                                    @break
                            @endswitch
                        </td>
                        <td>
                            <small>{{ $order->created_at->format('d M Y H:i') }}</small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="btn btn-sm" style="background: linear-gradient(90deg, #E573A6 60%, #F6A3B9 100%); color: #fff;" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-sm" style="background: linear-gradient(90deg, #FFD966 60%, #E573A6 100%); color: #B94E7A;" 
                                        onclick="updateStatus({{ $order->id }})" title="Update Status">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background: linear-gradient(90deg, #E573A6 60%, #B94E7A 100%); color: #fff;"
                                            onclick="return confirm('Hapus pesanan ini?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart text-muted" style="font-size: 4rem;"></i>
            <h3 class="text-muted mt-3">Belum Ada Pesanan</h3>
            <p class="text-muted">Belum ada pesanan yang masuk.</p>
        </div>
        @endif
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateStatusForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="order_status" class="form-label">Status Pesanan</label>
                        <select class="form-select" id="order_status" name="order_status" required>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="payment_status" class="form-label">Status Pembayaran</label>
                        <select class="form-select" id="payment_status" name="payment_status" required>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function loadStatistics() {
    fetch('{{ route("admin.orders.statistics") }}')
        .then(response => response.json())
        .then(data => {
            const content = `
                <div class="col-md-3">
                    <div class="text-center">
                        <h4 class="text-primary">${data.total_orders}</h4>
                        <small class="text-muted">Total Pesanan</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h4 class="text-warning">${data.pending_orders}</h4>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h4 class="text-success">${data.delivered_orders}</h4>
                        <small class="text-muted">Delivered</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <h4 class="text-info">Rp${data.total_revenue.toLocaleString()}</h4>
                        <small class="text-muted">Total Revenue</small>
                    </div>
                </div>
            `;
            document.getElementById('statistics-content').innerHTML = content;
            document.getElementById('statistics-card').style.display = 'block';
        });
}

function updateStatus(orderId) {
    document.getElementById('updateStatusForm').action = `/admin/orders/${orderId}/status`;
    new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
}
</script>
@endsection

