@extends('layouts.admin')

@section('title', 'Tambah Kategori Baru - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus me-2"></i>Tambah Kategori Baru</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Tambah Kategori</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Contoh: Papan Rustic, Bunga Akrilik"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="4" 
                                  placeholder="Deskripsi singkat tentang kategori ini">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">
                                Kategori Aktif
                            </label>
                        </div>
                        <small class="form-text text-muted">Kategori aktif akan langsung ditampilkan di halaman depan toko.</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 text-primary">
                                <i class="fas fa-info-circle me-2"></i>Informasi
                            </h6>
                            <ul class="list-unstyled mb-0 small text-muted">
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>Nama kategori harus unik.</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i>Deskripsi membantu pelanggan mengenal kategori.</li>
                                <li><i class="fas fa-check text-success me-2"></i>Sistem akan membuat URL otomatis dari nama kategori.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

