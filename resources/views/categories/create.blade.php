@extends('layouts.store')

@section('title', 'Tambah Kategori')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content">
                    <h1 class="display-4 mb-4 fw-bold text-white">
                        <i class="fas fa-plus-circle me-3"></i>Tambah Kategori
                    </h1>
                    <p class="lead mb-4 text-white" style="max-width: 600px; margin: 0 auto;">
                        Buat kategori baru untuk mengorganisir produk bunga Anda
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="#form" class="btn-accent">
                            <i class="fas fa-form me-2"></i>Isi Form
                        </a>
                        <a href="{{ route('categories.index') }}" class="btn-accent-outline">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Form Section -->
<section id="form" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="product-card fade-in-up">
                    <div class="p-4">
                        <h3 class="fw-bold mb-4 text-center">
                            <i class="fas fa-tag me-2 text-primary"></i>Form Tambah Kategori
                        </h3>


                <form action="{{ route('categories.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name" class="form-label">
                                <i class="fas fa-tag me-1"></i>Nama Kategori
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   required
                                   value="{{ old('name') }}"
                                   placeholder="Masukkan nama kategori"
                                   maxlength="100">
                            <div class="invalid-feedback">
                                @error('name')
                                    {{ $message }}
                                @else
                                    Nama kategori wajib diisi
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Contoh: Mawar, Lily, Tulip, dll.
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="slug" class="form-label">
                                <i class="fas fa-link me-1"></i>Slug URL
                            </label>
                            <input type="text"
                                   name="slug"
                                   id="slug"
                                   class="form-control @error('slug') is-invalid @enderror"
                                   value="{{ old('slug') }}"
                                   placeholder="Slug akan dibuat otomatis"
                                   readonly>
                            <div class="invalid-feedback">
                                @error('slug')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Slug akan dibuat otomatis dari nama kategori
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left me-1"></i>Deskripsi Kategori
                        </label>
                        <textarea name="description"
                                  id="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Masukkan deskripsi kategori (opsional)"
                                  maxlength="500">{{ old('description') }}</textarea>
                        <div class="invalid-feedback">
                            @error('description')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Deskripsi akan membantu pelanggan memahami kategori ini
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="color" class="form-label">
                                <i class="fas fa-palette me-1"></i>Warna Kategori
                            </label>
                            <div class="input-group">
                                <input type="color"
                                       name="color"
                                       id="color"
                                       class="form-control form-control-color @error('color') is-invalid @enderror"
                                       value="{{ old('color', '#10b981') }}"
                                       title="Pilih warna untuk kategori">
                                <span class="input-group-text">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                            <div class="invalid-feedback">
                                @error('color')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Warna akan digunakan untuk identifikasi visual kategori
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="icon" class="form-label">
                                <i class="fas fa-icons me-1"></i>Icon Kategori
                            </label>
                            <select name="icon"
                                    id="icon"
                                    class="form-select @error('icon') is-invalid @enderror">
                                <option value="">Pilih Icon</option>
                                <option value="fas fa-rose" {{ old('icon') == 'fas fa-rose' ? 'selected' : '' }}>🌹 Mawar</option>
                                <option value="fas fa-seedling" {{ old('icon') == 'fas fa-seedling' ? 'selected' : '' }}>🌱 Lily</option>
                                <option value="fas fa-flower" {{ old('icon') == 'fas fa-flower' ? 'selected' : '' }}>🌸 Tulip</option>
                                <option value="fas fa-sun" {{ old('icon') == 'fas fa-sun' ? 'selected' : '' }}>🌻 Matahari</option>
                                <option value="fas fa-cloud" {{ old('icon') == 'fas fa-cloud' ? 'selected' : '' }}>☁️ Baby Breath</option>
                                <option value="fas fa-heart" {{ old('icon') == 'fas fa-heart' ? 'selected' : '' }}>❤️ Romantis</option>
                                <option value="fas fa-gift" {{ old('icon') == 'fas fa-gift' ? 'selected' : '' }}>🎁 Hadiah</option>
                            </select>
                            <div class="invalid-feedback">
                                @error('icon')
                                    {{ $message }}
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Icon akan ditampilkan di menu dan halaman kategori
                            </div>
                        </div>
        </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="is_active"
                                   id="is_active"
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                <i class="fas fa-toggle-on me-1"></i>Kategori Aktif
                            </label>
                        </div>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Kategori aktif akan ditampilkan di website
                        </div>
        </div>

                        <div class="d-flex gap-3 justify-content-center mt-5">
                            <button type="submit" class="btn-accent">
                                <i class="fas fa-save me-2"></i>Simpan Kategori
                            </button>
                            <a href="{{ route('categories.index') }}" class="btn-accent-outline">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
    </form>
</div>
            </div>
        </div>
    </div>
</section>

<script>
// Add smooth scrolling animation to elements
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all fade-in-up elements
document.querySelectorAll('.fade-in-up').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});

// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    document.getElementById('slug').value = slug;
});

// Form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>
@endsection
