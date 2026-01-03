@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content">
                    <h1 class="display-4 mb-4 fw-bold text-white">
                        <i class="fas fa-tags me-3"></i>Kelola Kategori
                    </h1>
                    <p class="lead mb-4 text-white" style="max-width: 600px; margin: 0 auto;">
                        Kelola kategori produk untuk mengorganisir koleksi karangan bunga
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="#categories" class="btn-accent">
                            <i class="fas fa-list me-2"></i>Lihat Kategori
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn-accent-outline">
                            <i class="fas fa-plus me-2"></i>Tambah Kategori
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories List -->
<section id="categories" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Daftar Kategori</h2>
            <p class="lead text-muted">Kelola semua kategori produk Anda</p>
        </div>

        @if($categories->count() > 0)
        <div class="row g-4">
            @foreach($categories as $index => $category)
            <div class="col-lg-4 col-md-6">
                <div class="product-card fade-in-up">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">{{ $category->name }}</h5>
                                <span class="badge bg-primary">{{ $category->products_count }} produk</span>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.categories.edit', $category->id) }}">
                                        <i class="fas fa-edit me-2"></i>Edit
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteCategory({{ $category->id }}, {{ $category->products_count }})">
                                        <i class="fas fa-trash me-2"></i>Hapus
                                    </a></li>
                                </ul>
                            </div>
                        </div>

                        <p class="text-muted mb-3">
                            {{ $category->deskripsi ? Str::limit($category->deskripsi, 80) : 'Tidak ada deskripsi' }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                Dibuat: {{ $category->created_at->format('d M Y') }}
                            </small>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="deleteCategory({{ $category->id }}, {{ $category->products_count }})"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-tags text-muted" style="font-size: 4rem;"></i>
            </div>
            <h3 class="text-muted mb-3">Belum Ada Kategori</h3>
            <p class="text-muted mb-4">Mulai dengan menambahkan kategori pertama untuk mengorganisir produk Anda.</p>
            <a href="{{ route('admin.categories.create') }}" class="btn-accent">
                <i class="fas fa-plus me-2"></i>Tambah Kategori Pertama
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

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

function deleteCategory(categoryId, productsCount) {
    if (productsCount > 0) {
        alert('Tidak dapat menghapus kategori yang memiliki produk. Silakan hapus atau pindahkan produk terlebih dahulu.');
        return;
    }

    if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/categories/${categoryId}`;
        form.submit();
    }
}
</script>
@endsection

