@extends('layouts.admin')

@section('title', 'Kelola Produk - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="color: #C2185B; font-weight: 800;"><i class="fas fa-box me-3"></i>Kelola Produk</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.export-pdf') }}" class="btn btn-danger shadow-sm" target="_blank" style="border-radius: 8px;">
            <i class="fas fa-file-pdf me-2"></i>Export PDF
        </a>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm" style="background-color: #C2185B !important; border: none; border-radius: 8px;">
            <i class="fas fa-plus me-2"></i>Tambah Produk Baru
        </a>
    </div>
</div>

<!-- KOTAK FILTER - SEKARANG JADI PINK MEWAH -->
<div class="card mb-4 border-0 shadow-sm" style="background-color: #FCE4EC !important; border-radius: 15px; border: 1px solid #F8BBD9 !important;">
    <div class="card-body p-4">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold" style="color: #C2185B;">Cari Produk</label>
                <div class="input-group">
                    <input type="text" name="search" value="{{ $filters['search'] }}" class="form-control" placeholder="Nama atau deskripsi karangan bunga..." style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important; color: #C2185B;">
                    <button class="btn btn-outline-primary" type="submit" style="background-color: #FFF0F5; border: 1px solid #F8BBD9; border-left: none; color: #C2185B;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold" style="color: #C2185B;">Kategori</label>
                <select name="category" class="form-select" style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important; color: #C2185B;">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $filters['category'] == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold" style="color: #C2185B;">Status Stok</label>
                <select name="stock_status" class="form-select" style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important; color: #C2185B;">
                    <option value="">Semua Status</option>
                    <option value="in_stock" {{ $filters['stock_status'] == 'in_stock' ? 'selected' : '' }}>Tersedia</option>
                    <option value="low_stock" {{ $filters['stock_status'] == 'low_stock' ? 'selected' : '' }}>Stok Rendah</option>
                    <option value="out_of_stock" {{ $filters['stock_status'] == 'out_of_stock' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold" style="color: #C2185B;">Urutkan</label>
                <select name="sort" class="form-select" onchange="this.form.submit()" style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important; color: #C2185B;">
                    <option value="latest" {{ $filters['sort'] == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="name_asc" {{ $filters['sort'] == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="price_asc" {{ $filters['sort'] == 'price_asc' ? 'selected' : '' }}>Harga Rendah</option>
                    <option value="price_desc" {{ $filters['sort'] == 'price_desc' ? 'selected' : '' }}>Harga Tinggi</option>
                </select>
            </div>
        </form>
    </div>
</div>

<!-- DAFTAR PRODUK - HEADER MAGENTA FULL -->
<div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden; border: 1px solid #F8BBD9 !important;">
    <div class="card-header py-3" style="background-color: #C2185B !important; border: none;">
        <h5 class="mb-0 text-white fw-bold">
            <i class="fas fa-list me-2"></i>Daftar Produk
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #FCE4EC;">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th class="text-end">Harga</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Status</th>
                        <th class="pe-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody style="background-color: white;">
                    @forelse($products as $product)
                    <tr>
                        <td class="ps-4 text-muted">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                        <td>
                            @if($product->images->first())
                                <img src="{{ asset('storage/'.$product->images->first()->image_path) }}" class="rounded shadow-sm" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #FCE4EC;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #FFF0F5; color: #C2185B;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold" style="color: #2c2c2c;">{{ $product->name }}</div>
                            <small class="text-muted">{{ Str::limit($product->deskripsi, 50) }}</small>
                        </td>
                        <td><span class="badge" style="background-color: #FCE4EC; color: #C2185B;">{{ $product->category->name ?? '-' }}</span></td>
                        <td class="text-end fw-bold">
                            @if($product->harga_diskon)
                                <div class="text-success">Rp{{ number_format($product->harga_diskon, 0, ',', '.') }}</div>
                                <small class="text-muted text-decoration-line-through">Rp{{ number_format($product->harga, 0, ',', '.') }}</small>
                            @else
                                <div>Rp{{ number_format($product->harga, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($product->stok > 0)
                                <span class="badge rounded-pill" style="background-color: #FCE4EC; color: #C2185B; border: 1px solid #F8BBD9;">{{ $product->stok }}</span>
                            @else
                                <span class="badge bg-danger rounded-pill">Habis</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $product->stok > 0 ? 'success' : 'secondary' }}">
                                {{ $product->stok > 0 ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td class="pe-4 text-center">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-info text-white" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-success text-white" title="Lihat" target="_blank"><i class="fas fa-eye"></i></a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteProduct({{ $product->id }})" title="Hapus"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-5 text-muted">Belum ada produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center p-4">
            {{ $products->links() }}
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" style="display: none;">
    @csrf @method('DELETE')
</form>

<script>
function deleteProduct(productId) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/products/${productId}`;
        form.submit();
    }
}
</script>

<style>
    /* Styling Pagination agar Kecil & Pink */
    .pagination .page-link { color: #C2185B; border-color: #F8BBD9; }
    .pagination .page-item.active .page-link { background-color: #C2185B; border-color: #C2185B; }
</style>
@endsection