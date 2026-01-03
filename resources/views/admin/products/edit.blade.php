@extends('layouts.admin')

@section('title', 'Edit Produk - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit me-2"></i>Edit Produk</h2>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Edit Produk</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $product->name) }}" 
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
                                  rows="4">{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
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
                                           value="{{ (int) old('harga', $product->harga) }}" 
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
                                           value="{{ (int) old('harga_diskon', $product->harga_diskon) }}" 
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
                                                {{ old('id_kategori', $product->id_kategori) == $category->id ? 'selected' : '' }}>
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
                                       value="{{ old('stok', $product->stok) }}" 
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
                        <label for="images" class="form-label">Gambar Produk (Bisa lebih dari satu)</label>
                        <input type="file" 
                               class="form-control @error('images.*') is-invalid @enderror" 
                               id="images" 
                               name="images[]" 
                               accept="image/*" 
                               multiple>
                        @error('images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB per gambar</small>
                        
                        <!-- Existing Images Section -->
                        @if($product->images->count() > 0)
                            <div class="mt-4">
                                <label class="form-label d-block">Gambar Saat Ini:</label>
                                <div class="row g-2" id="existingImagesContainer">
                                    @foreach($product->images as $image)
                                        <div class="col-4 position-relative" id="existing-image-{{ $image->id }}">
                                            <img src="{{ asset('storage/'.$image->image_path) }}" 
                                                 alt="{{ $product->name }} - Gambar {{ $loop->iteration }}" 
                                                 class="img-fluid rounded shadow-sm" 
                                                 style="max-height: 120px; object-fit: cover;">
                                            <div class="form-check position-absolute top-0 start-0 bg-light p-1 rounded-bottom-right" style="z-index: 1;">
                                                <input class="form-check-input" type="checkbox" name="existing_images_ids[]" value="{{ $image->id }}" id="delete-image-{{ $image->id }}" checked>
                                                <label class="form-check-label small" for="delete-image-{{ $image->id }}">Keep</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="form-text text-muted mt-2">Hapus centang 'Keep' untuk menghapus gambar yang ada.</small>
                            </div>
                        @endif

                        <!-- New Image Preview Section -->
                        <div id="newImagePreview" class="mt-4" style="display: none;">
                            <label class="form-label d-block">Preview Gambar Baru:</label>
                            <div class="row g-2" id="newImagePreviewsContainer">
                                <!-- New image previews will be dynamically added here -->
                            </div>
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
                        <input class="form-check-input" type="checkbox" id="is_combinable" name="is_combinable" value="1" {{ old('is_combinable', $product->is_combinable) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_combinable">
                            Produk ini dapat digabungkan
                        </label>
                        <small class="form-text text-muted d-block">Centang jika produk ini dapat digabungkan dengan produk lain.</small>
                    </div>

                    <div class="mb-3" id="combinableMultiplierField" style="{{ old('is_combinable', $product->is_combinable) ? '' : 'display: none;' }}">
                        <label for="combinable_multiplier" class="form-label">Pengali Papan Gabungan</label>
                        <div class="input-group">
                            <input type="number" 
                                   class="form-control @error('combinable_multiplier') is-invalid @enderror" 
                                   id="combinable_multiplier" 
                                   name="combinable_multiplier" 
                                   value="{{ (int) old('combinable_multiplier', $product->combinable_multiplier) }}" 
                                   min="1">
                        </div>
                        @error('combinable_multiplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Masukkan jumlah pengali harga jika 2 papan digabungkan (misal: 2 untuk 2x harga). Untuk 4 papan, negosiasi manual.</small>
                    </div>

                    
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Produk
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Image preview functionality for new multiple images
document.getElementById('images').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('newImagePreviewsContainer');
    previewContainer.innerHTML = ''; // Clear existing previews
    document.getElementById('newImagePreview').style.display = 'flex'; // Show container

    if (e.target.files.length > 0) {
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const colDiv = document.createElement('div');
                colDiv.className = 'col-4'; // Adjust column size as needed
                colDiv.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="img-fluid rounded shadow-sm" style="max-height: 120px; object-fit: cover;">
                `;
                previewContainer.appendChild(colDiv);
            };
            reader.readAsDataURL(file);
        });
    } else {
        document.getElementById('newImagePreview').style.display = 'none';
    }
});

// Toggle visibility for existing images when their checkbox is unchecked
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[name="existing_images_ids[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const imageContainer = document.getElementById(`existing-image-${this.value}`);
            if (imageContainer) {
                if (this.checked) {
                    imageContainer.style.opacity = '1';
                    imageContainer.style.border = 'none';
                } else {
                    imageContainer.style.opacity = '0.5';
                    imageContainer.style.border = '2px solid red';
                }
            }
        });
    });

    const isCombinableCheckbox = document.getElementById('is_combinable');
    const combinableMultiplierField = document.getElementById('combinableMultiplierField');
    const combinableMultiplierInput = document.getElementById('combinable_multiplier');
    const form = document.querySelector('form');

    function toggleCombinableFields() {
        if (isCombinableCheckbox.checked) {
            combinableMultiplierField.style.display = 'block';
        } else {
            combinableMultiplierField.style.display = 'none';
            // Clear the value when checkbox is unchecked
            if (combinableMultiplierInput) {
                combinableMultiplierInput.value = '';
            }
        }
    }

    // Ensure field is cleared before form submission if checkbox is not checked
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!isCombinableCheckbox.checked && combinableMultiplierInput) {
                combinableMultiplierInput.value = '';
            }
        });
    }

    isCombinableCheckbox.addEventListener('change', toggleCombinableFields);
    toggleCombinableFields(); // Set initial state
});
</script>
@endsection

