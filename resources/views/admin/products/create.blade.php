@extends('layouts.admin')

@section('title', 'Tambah Produk Baru - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus me-2"></i>Tambah Produk Baru</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Produk</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga Normal <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control @error('harga') is-invalid @enderror" 
                                           id="harga" 
                                           name="harga" 
                                           value="{{ old('harga') }}" 
                                           min="0" 
                                           required>
                                </div>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga_diskon" class="form-label">Harga Diskon</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control @error('harga_diskon') is-invalid @enderror" 
                                           id="harga_diskon" 
                                           name="harga_diskon" 
                                           value="{{ old('harga_diskon') }}" 
                                           min="0">
                                </div>
                                @error('harga_diskon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kosongkan jika tidak ada diskon</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('id_kategori') is-invalid @enderror" 
                                        id="id_kategori" 
                                        name="id_kategori" 
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('id_kategori') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('stok') is-invalid @enderror" 
                                       id="stok" 
                                       name="stok" 
                                       value="{{ old('stok') }}" 
                                       min="0" 
                                       required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Produk</label>
                        <input type="file" 
                               class="form-control @error('gambar') is-invalid @enderror" 
                               id="gambar" 
                               name="gambar" 
                               accept="image/*">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                        
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Combinable Options -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Opsi Papan Gabungan</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_combinable" name="is_combinable" value="1" {{ old('is_combinable') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_combinable">
                            Produk ini dapat digabungkan
                        </label>
                        <small class="form-text text-muted d-block">Centang jika produk ini dapat digabungkan dengan produk lain.</small>
                    </div>

                    <div class="mb-3" id="combinedPriceMultiplierField" style="display: none;">
                        <label for="combined_price_multiplier" class="form-label">Pengali Harga Gabungan</label>
                        <div class="input-group">
                            <input type="number" 
                                   class="form-control @error('combined_price_multiplier') is-invalid @enderror" 
                                   id="combined_price_multiplier" 
                                   name="combined_price_multiplier" 
                                   value="{{ old('combined_price_multiplier') }}" 
                                   step="0.01" 
                                   min="0.01" 
                                   max="10.00">
                        </div>
                        @error('combined_price_multiplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Faktor pengali untuk harga jika papan digabungkan (misal: 1.8 untuk 2 papan berarti harga total 1.8x harga normal per papan). Kosongkan jika harga dihitung secara otomatis.</small>
                    </div>

                    <div class="mb-3" id="combinedDescriptionField" style="display: none;">
                        <label for="combined_description" class="form-label">Deskripsi Gabungan</label>
                        <textarea class="form-control @error('combined_description') is-invalid @enderror" 
                                  id="combined_description" 
                                  name="combined_description" 
                                  rows="4">{{ old('combined_description') }}</textarea>
                        @error('combined_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Deskripsi khusus yang ditampilkan jika produk ini dibeli sebagai papan gabungan.</small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Image preview functionality
document.getElementById('gambar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagePreview').style.display = 'none';
    }
});

// Toggle combinable fields
document.addEventListener('DOMContentLoaded', function() {
    const isCombinableCheckbox = document.getElementById('is_combinable');
    const combinedPriceMultiplierField = document.getElementById('combinedPriceMultiplierField');
    const combinedDescriptionField = document.getElementById('combinedDescriptionField');

    function toggleCombinableFields() {
        if (isCombinableCheckbox.checked) {
            combinedPriceMultiplierField.style.display = 'block';
            combinedDescriptionField.style.display = 'block';
        } else {
            combinedPriceMultiplierField.style.display = 'none';
            combinedDescriptionField.style.display = 'none';
        }
    }

    isCombinableCheckbox.addEventListener('change', toggleCombinableFields);
    toggleCombinableFields(); // Set initial state
});
</script>
@endsection

