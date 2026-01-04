@extends('layouts.admin')

@section('title', 'Kelola Pesanan - Admin Panel')

@section('content')
<!-- Header Halaman -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="color: #C2185B; font-weight: 800;"><i class="fas fa-shopping-cart me-2"></i>Kelola Pesanan</h2>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary" style="border-color: #C2185B; color: #C2185B; font-weight: 600;" onclick="loadStatistics()">
            <i class="fas fa-chart-bar me-2"></i>Statistik
        </button>
    </div>
</div>

<!-- Statistics Card (Awalnya Sembunyi) -->
<div id="statistics-card" class="card mb-4 border-0 shadow-sm" style="display: none; background-color: #FCE4EC !important; border-radius: 15px;">
    <div class="card-header border-0 py-3" style="background-color: #C2185B !important;">
        <h5 class="mb-0 text-white fw-bold"><i class="fas fa-chart-pie me-2"></i>Statistik Pesanan</h5>
    </div>
    <div class="card-body">
        <div class="row text-center" id="statistics-content">
            <!-- Isi statistik diisi lewat JS -->
        </div>
    </div>
</div>

<!-- KOTAK FILTER - SEKARANG JADI PINK MEWAH (BUKAN PUTIH) -->
<div class="card mb-4 border-0 shadow-sm" style="background-color: #FCE4EC !important; border-radius: 15px; border: 1px solid #F8BBD9 !important;">
    <div class="card-body p-4">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label fw-bold" style="color: #C2185B;">Cari</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ $filters['search'] ?? '' }}" placeholder="No. pesanan, nama, email..."
                       style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important; color: #C2185B; font-weight: 500;">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label fw-bold" style="color: #C2185B;">Status Pesanan</label>
                <select class="form-select" id="status" name="status" style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important;">
                    <option value="">Semua Status</option>
                    @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $st)
                        <option value="{{ $st }}" {{ ($filters['status'] ?? '') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="payment_method" class="form-label fw-bold" style="color: #C2185B;">Metode</label>
                <select class="form-select" id="payment_method" name="payment_method" style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important;">
                    <option value="">Semua Metode</option>
                    <option value="cash" {{ ($filters['payment_method'] ?? '') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="transfer" {{ ($filters['payment_method'] ?? '') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="payment_status" class="form-label fw-bold" style="color: #C2185B;">Pembayaran</label>
                <select class="form-select" id="payment_status" name="payment_status" style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ ($filters['payment_status'] ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ ($filters['payment_status'] ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="sort" class="form-label fw-bold" style="color: #C2185B;">Urutkan</label>
                <select class="form-select" id="sort" name="sort" style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important;">
                    <option value="latest" {{ ($filters['sort'] ?? '') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ ($filters['sort'] ?? '') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary w-100" style="background-color: #C2185B !important; border: none;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- DAFTAR PESANAN - HEADER MAGENTA MEWAH -->
<div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden; border: 1px solid #F8BBD9 !important;">
    <div class="card-header py-3" style="background-color: #C2185B !important; border: none;">
        <h5 class="mb-0 text-white fw-bold">
            <i class="fas fa-list me-2"></i>Daftar Pesanan ({{ $orders->total() }} pesanan)
        </h5>
    </div>
    <div class="card-body p-0" style="background-color: #ffffff;">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background-color: #FCE4EC;">
                    <tr>
                        <th class="ps-4">No. Pesanan</th>
                        <th>Customer</th>
                        <th class="text-end">Total</th>
                        <th>Metode</th>
                        <th>Bayar</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th class="pe-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td class="ps-4">
                            <a href="{{ route('admin.orders.show', $order->id) }}" style="color: #C2185B; font-weight: 800; text-decoration: none;">{{ $order->order_number }}</a>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $order->user->name ?? $order->customer_name }}</div>
                            <small class="text-muted">{{ $order->user->email ?? $order->customer_email }}</small>
                        </td>
                        <td class="text-end fw-bold">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge" style="background-color: {{ $order->payment_method == 'cash' ? '#0d6efd' : '#0dcaf0' }}; color: white;">
                                {{ strtoupper($order->payment_method) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : ($order->order_status == 'pending' ? 'warning' : 'info') }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </td>
                        <td><small>{{ $order->created_at->format('d M Y') }}<br>{{ $order->created_at->format('H:i') }}</small></td>
                        <td class="pe-4 text-center">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm" style="background-color: #C2185B; color: white;"><i class="fas fa-eye"></i></a>
                                <button type="button" class="btn btn-sm btn-info text-white" onclick="updateStatus({{ $order->id }})"><i class="fas fa-edit"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center p-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header text-white" style="background-color: #C2185B;">
                <h5 class="modal-title">Update Status Pesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateStatusForm" method="POST" style="display: none;">
                @csrf @method('PATCH')
            </form>
            <div class="modal-body" style="background-color: #FCE4EC;">
                <div class="alert alert-info small d-none" id="statusMessage" role="alert"></div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Status Pesanan</label>
                    <select class="form-select" id="order_status" name="order_status" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status Pembayaran (Opsional)</label>
                    <select class="form-select" id="payment_status" name="payment_status">
                        <option value="">-- Tidak diubah --</option>
                        <option value="pending">Pending</option>
                        <option value="pending_transfer">Menunggu Transfer</option>
                        <option value="awaiting_admin_approval">Menunggu Verifikasi</option>
                        <option value="paid">Paid</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #FCE4EC;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitStatusBtn" style="background-color: #C2185B; border: none;">
                    <span class="spinner-border spinner-border-sm me-2 d-none" id="loadingSpinner" role="status" aria-hidden="true"></span>
                    <span id="submitBtnText">Update</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function loadStatistics() {
    fetch('{{ route("admin.orders.statistics") }}')
        .then(response => response.json())
        .then(data => {
            const content = `
                <div class="col-md-3"><h4 style="color:#C2185B;">${data.total_orders}</h4><small>Total Pesanan</small></div>
                <div class="col-md-3"><h4 style="color:#ffc107;">${data.pending_orders}</h4><small>Pending</small></div>
                <div class="col-md-3"><h4 style="color:#198754;">${data.delivered_orders}</h4><small>Selesai</small></div>
                <div class="col-md-3"><h4 style="color:#0d6efd;">Rp${data.total_revenue.toLocaleString()}</h4><small>Pendapatan</small></div>
            `;
            document.getElementById('statistics-content').innerHTML = content;
            document.getElementById('statistics-card').style.display = 'block';
        });
}

let currentOrderId = null;

function updateStatus(orderId) {
    currentOrderId = orderId;
    // Reset form
    document.getElementById('order_status').value = '';
    document.getElementById('payment_status').value = '';
    document.getElementById('statusMessage').textContent = '';
    document.getElementById('statusMessage').classList.add('d-none');
    document.getElementById('submitBtnText').textContent = 'Update';
    document.getElementById('loadingSpinner').classList.add('d-none');
    document.getElementById('submitStatusBtn').disabled = false;
    
    new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
}

// Handle submit button click
document.getElementById('submitStatusBtn').addEventListener('click', function() {
    const orderStatus = document.getElementById('order_status').value;
    const paymentStatus = document.getElementById('payment_status').value;
    
    if (!orderStatus) {
        alert('Pilih status pesanan terlebih dahulu!');
        return;
    }
    
    // Show loading state
    this.disabled = true;
    document.getElementById('loadingSpinner').classList.remove('d-none');
    document.getElementById('submitBtnText').textContent = 'Menyimpan...';
    
    // Prepare form data
    const formData = new FormData();
    formData.append('_token', document.querySelector('[name="_token"]').value);
    formData.append('_method', 'PATCH');
    formData.append('order_status', orderStatus);
    if (paymentStatus) {
        formData.append('payment_status', paymentStatus);
    }
    
    // Send AJAX request
    fetch(`/admin/orders/${currentOrderId}/status`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Show success message
            const messageDiv = document.getElementById('statusMessage');
            messageDiv.textContent = '✓ ' + data.message;
            messageDiv.classList.remove('d-none', 'alert-danger');
            messageDiv.classList.add('alert-success');
            
            // Reload page after 1.5 seconds
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Gagal memperbarui status');
        }
    })
    .catch(error => {
        const messageDiv = document.getElementById('statusMessage');
        messageDiv.textContent = '✗ ' + error.message;
        messageDiv.classList.remove('d-none', 'alert-success');
        messageDiv.classList.add('alert-danger');
        
        // Reset button
        this.disabled = false;
        document.getElementById('loadingSpinner').classList.add('d-none');
        document.getElementById('submitBtnText').textContent = 'Update';
    });
});
</script>
@endsection