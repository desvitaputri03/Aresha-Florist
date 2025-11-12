@extends('layouts.admin')

@section('title', 'Edit Kategori - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit me-2"></i>Edit Kategori</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Form Edit Kategori</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $category->name) }}" 
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
                                  placeholder="Deskripsi singkat tentang kategori ini">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" 
                               class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug', $category->slug) }}" 
                               placeholder="karangan-bunga-mawar">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">URL-friendly version of the name. Leave empty to auto-generate.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="warna" class="form-label">Warna</label>
                                <input type="text" 
                                       class="form-control @error('warna') is-invalid @enderror" 
                                       id="warna" 
                                       name="warna" 
                                       value="{{ old('warna', $category->warna) }}" 
                                       placeholder="#ff0000 atau red">
                                @error('warna')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ikon" class="form-label">Ikon</label>
                                <input type="text" 
                                       class="form-control @error('ikon') is-invalid @enderror" 
                                       id="ikon" 
                                       name="ikon" 
                                       value="{{ old('ikon', $category->ikon) }}" 
                                       placeholder="fas fa-heart">
                                @error('ikon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>
                        <small class="form-text text-muted">Kategori aktif akan ditampilkan di frontend</small>
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
                                <li class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-check text-success me-1"></i>
                                        Slug akan digunakan di URL
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
                    <i class="fas fa-save me-2"></i>Update Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

