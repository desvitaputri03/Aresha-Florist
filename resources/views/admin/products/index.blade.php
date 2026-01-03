@extends('layouts.admin')

@section('title', 'Kelola Produk - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-shopping-bag me-2"></i>Kelola Produk</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.export-pdf') }}" class="btn btn-danger" target="_blank">
            <i class="fas fa-file-pdf me-2"></i>Export PDF
        </a>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Produk Baru
        </a>
    </div>
</div>

<!-- Filter & Search Bar -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Cari Produk</label>
                <div class="input-group">
                    <input type="text" name="search" value="{{ $filters['search'] }}" class="form-control" placeholder="Nama atau deskripsi karangan bunga...">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kategori</label>
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $filters['category'] == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status Stok</label>
                <select name="stock_status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="in_stock" {{ $filters['stock_status'] == 'in_stock' ? 'selected' : '' }}>Tersedia</option>
                    <option value="low_stock" {{ $filters['stock_status'] == 'low_stock' ? 'selected' : '' }}>Stok Rendah</option>
                    <option value="out_of_stock" {{ $filters['stock_status'] == 'out_of_stock' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Urutkan</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="latest" {{ $filters['sort'] == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="name_asc" {{ $filters['sort'] == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="name_desc" {{ $filters['sort'] == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    <option value="price_asc" {{ $filters['sort'] == 'price_asc' ? 'selected' : '' }}>Harga Rendah</option>
                    <option value="price_desc" {{ $filters['sort'] == 'price_desc' ? 'selected' : '' }}>Harga Tinggi</option>
                    <option value="stock_asc" {{ $filters['sort'] == 'stock_asc' ? 'selected' : '' }}>Stok Rendah</option>
                    <option value="stock_desc" {{ $filters['sort'] == 'stock_desc' ? 'selected' : '' }}>Stok Tinggi</option>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Produk</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                        <td>
                            @if($product->images->first())
                                <img src="{{ asset('storage/'.$product->images->first()->image_path) }}"
                                     alt="{{ $product->name }}"
                                     class="rounded"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold">{{ $product->name }}</div>
                            <small class="text-muted">{{ Str::limit($product->deskripsi, 50) }}</small>
                        </td>
                        <td>
                            <span class="badge" style="background: var(--accent-color); color: #ffffff;">{{ $product->category->name ?? '-' }}</span>
                        </td>
                        <td>
                            @if($product->harga_diskon)
                                <div class="text-success fw-bold">Rp{{ number_format($product->harga_diskon, 0, ',', '.') }}</div>
                                <small class="text-muted text-decoration-line-through">Rp{{ number_format($product->harga, 0, ',', '.') }}</small>
                            @else
                                <div class="fw-bold">Rp{{ number_format($product->harga, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td>
                            @if($product->stok > 10)
                                <span class="badge" style="background: var(--primary-color); color: #ffffff;">{{ $product->stok }}</span>
                            @elseif($product->stok > 0)
                                <span class="badge" style="background: var(--accent-secondary); color: #ffffff;">{{ $product->stok }}</span>
                            @else
                                <span class="badge" style="background: var(--accent-color); color: #ffffff;">Habis</span>
                            @endif
                        </td>
                        <td>
                            @if($product->stok > 0)
                                <span class="badge" style="background: var(--primary-color); color: #ffffff;">Aktif</span>
                            @else
                                <span class="badge" style="background: var(--accent-color); color: #ffffff;">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="btn btn-sm btn-primary"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="btn btn-sm btn-success"
                                   title="Lihat"
                                   target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        onclick="deleteProduct({{ $product->id }})"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                            Belum ada karangan bunga
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
    /* Pagination styling untuk admin - kecil */
    div.d-flex.justify-content-center .pagination {
        gap: 2px !important;
    }
    
    div.d-flex.justify-content-center .pagination .page-item {
        margin: 0 !important;
    }
    
    div.d-flex.justify-content-center .pagination .page-link {
        padding: 3px 6px !important;
        font-size: 12px !important;
        min-width: auto !important;
        border-radius: 3px !important;
        line-height: 1 !important;
        height: auto !important;
    }
    
    div.d-flex.justify-content-center .pagination .page-item.active .page-link {
        background-color: #007bff !important;
        border-color: #007bff !important;
    }
    
    div.d-flex.justify-content-center .pagination .page-link:hover {
        background-color: #f0f0f0 !important;
        color: #007bff !important;
    }
    
    div.d-flex.justify-content-center .pagination .page-item.disabled .page-link {
        padding: 3px 6px !important;
        font-size: 12px !important;
    }
</style>

<script>
function deleteProduct(productId) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/products/${productId}`;
        form.submit();
    }
}
</script>
@endsection

