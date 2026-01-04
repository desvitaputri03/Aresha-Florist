@extends('layouts.admin')

@section('title', 'Tambah Produk Baru - Admin Panel')

@section('content')
<!-- Judul Halaman -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="color: #C2185B; font-weight: 800;"><i class="fas fa-plus me-3"></i>Tambah Produk Baru</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary shadow-sm" style="border-radius: 8px; background-color: #6C757D !important; border: none;">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<!-- Card Utama Warna Pink Lembut -->
<div class="card border-0 shadow-sm" style="background-color: #FCE4EC !important; border-radius: 15px; overflow: hidden; border: 1px solid #F8BBD9 !important;">
    <!-- Header Magenta Full Mewah -->
    <div class="card-header py-3" style="background-color: #C2185B !important; border: none;">
        <h5 class="mb-0 text-white fw-bold">
            <i class="fas fa-edit me-2"></i>Form Tambah Produk
        </h5>
    </div>
    
    <div class="card-body p-4" style="background-color: #FCE4EC !important;">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <!-- Kolom Kiri: Detail Produk -->
                <div class="col-md-8">
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold" style="color: #C2185B;">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" 
                               style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important; color: #C2185B; font-weight: 500;" placeholder="Contoh: Karangan Bunga Papan Wisuda" required>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-bold" style="color: #C2185B;">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" 
                                  style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important; color: #C2185B;" placeholder="Detail produk...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="harga" class="form-label fw-bold" style="color: #C2185B;">Harga Normal <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: #FFF0F5; border: 1px solid #F8BBD9; border-right: none;">Rp</span>
                                    <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', 0) }}" 
                                           style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important; border-left: none;" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="harga_diskon" class="form-label fw-bold" style="color: #C2185B;">Harga Diskon</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: #FFF0F5; border: 1px solid #F8BBD9; border-right: none;">Rp</span>
                                    <input type="number" class="form-control" id="harga_diskon" name="harga_diskon" value="{{ old('harga_diskon', 0) }}" 
                                           style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important; border-left: none;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="id_kategori" class="form-label fw-bold" style="color: #C2185B;">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_kategori" name="id_kategori" style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important;" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('id_kategori') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="stok" class="form-label fw-bold" style="color: #C2185B;">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok', 0) }}" 
                                       style="background-color: #FFF0F5 !important; border: 1px solid #F8BBD9 !important;" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Gambar -->
                <div class="col-md-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #C2185B;">Gambar Produk</label>
                        <div class="p-3 rounded border" style="background-color: #FFF0F5; border: 1px dashed #C2185B !important;">
                            <input type="file" class="form-control" id="images" name="images[]" multiple style="background: transparent; border: none;">
                            <small class="text-muted d-block mt-2">Pilih beberapa foto karangan bunga.</small>
                        </div>
                        <div id="imagePreview" class="mt-3 row g-2"></div>
                    </div>
                </div>
            </div>

            <!-- Opsi Papan Gabungan -->
            <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; border: 1px solid #F8BBD9 !important;">
                <div class="card-header py-2" style="background-color: #F8BBD9 !important; border: none;">
                    <h6 class="mb-0 fw-bold" style="color: #C2185B;">Opsi Papan Gabungan</h6>
                </div>
                <div class="card-body" style="background-color: #FFF0F5 !important;">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="is_combinable" name="is_combinable" value="1" {{ old('is_combinable') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_combinable" style="color: #C2185B;">
                            Produk ini dapat digabungkan (Misal: Order 2-4 papan)
                        </label>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold" style="background-color: #C2185B !important; border: none !important; border-radius: 8px;">
                    <i class="fas fa-save me-2"></i>Simpan Produk ke Katalog
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Preview Gambar
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    Array.from(e.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = f => {
            const div = document.createElement('div');
            div.className = 'col-4';
            div.innerHTML = `<img src="${f.target.result}" class="img-fluid rounded shadow-sm border">`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endsection