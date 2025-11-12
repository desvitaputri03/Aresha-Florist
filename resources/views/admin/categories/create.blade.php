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
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Contoh: Mawar, Lily, Tulip"
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
                                  rows="4" 
                                  placeholder="Deskripsi singkat tentang kategori ini">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-info-circle me-2"></i>Informasi
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-check text-success me-1"></i>
                                        Nama kategori harus unik
                                    </small>
                                </li>
                                <li class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-check text-success me-1"></i>
                                        Deskripsi bersifat opsional
                                    </small>
                                </li>
                                <li>
                                    <small class="text-muted">
                                        <i class="fas fa-check text-success me-1"></i>
                                        Kategori dapat digunakan untuk produk
                                    </small>
                                </li>
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

