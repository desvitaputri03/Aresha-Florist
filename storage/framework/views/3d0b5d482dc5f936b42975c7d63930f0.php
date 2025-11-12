<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Dashboard specific styles */
    .product-card {
        background: var(--bg-white);
        border: 1px solid rgba(194, 24, 91, 0.2);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-color);
    }

    .text-primary {
        color: var(--primary-color) !important;
    }

    .bg-light {
        background: var(--accent-secondary) !important;
    }

    .text-muted {
        color: var(--text-muted) !important;
    }

    .btn-accent {
        background: var(--primary-color);
        color: var(--bg-white);
        border: none;
        border-radius: var(--border-radius);
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-block;
    }

    .btn-accent:hover {
        background: var(--primary-dark);
        color: var(--bg-white);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        text-decoration: none;
    }

    .btn-accent-outline {
        background: transparent;
        color: var(--bg-white);
        border: 2px solid var(--bg-white);
        border-radius: var(--border-radius);
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-block;
    }

    .btn-accent-outline:hover {
        background: var(--bg-white);
        color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        text-decoration: none;
    }

    .text-warning {
        color: var(--primary-color) !important;
    }

    .fade-in-up {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease-out;
    }

    .fade-in-up.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8 mx-auto text-center">
                <div class="hero-content">
                    <h1 class="display-4 mb-4 fw-bold text-white">
                        <i class="fas fa-tachometer-alt me-3"></i>Dashboard Admin
                    </h1>
                    <p class="lead mb-4 text-white" style="max-width: 600px; margin: 0 auto;">
                        Selamat datang di Admin Panel Aresha Florist
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="#stats" class="btn-accent">
                            <i class="fas fa-chart-bar me-2"></i>Lihat Statistik
                        </a>
                        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn-accent-outline">
                            <i class="fas fa-plus me-2"></i>Tambah Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Cards -->
<section id="stats" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Statistik Dashboard</h2>
            <p class="lead text-muted">Ringkasan data dan informasi penting</p>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="product-card fade-in-up">
                    <div class="p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-shopping-bag text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="fw-bold text-primary mb-2"><?php echo e($totalProducts ?? 0); ?></h3>
                        <h5 class="fw-bold mb-2">Total Produk</h5>
                        <p class="text-muted mb-0">Jumlah produk yang tersedia</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="product-card fade-in-up">
                    <div class="p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-tags text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="fw-bold text-primary mb-2"><?php echo e($totalCategories ?? 0); ?></h3>
                        <h5 class="fw-bold mb-2">Kategori</h5>
                        <p class="text-muted mb-0">Jumlah kategori produk</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="product-card fade-in-up">
                    <div class="p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-shopping-cart text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="fw-bold text-primary mb-2"><?php echo e($totalOrders ?? 0); ?></h3>
                        <h5 class="fw-bold mb-2">Pesanan Hari Ini</h5>
                        <p class="text-muted mb-0">Pesanan yang masuk hari ini</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="product-card fade-in-up">
                    <div class="p-4 text-center">
                        <div class="mb-3">
                            <i class="fas fa-dollar-sign text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="fw-bold text-primary mb-2">Rp<?php echo e(number_format($totalRevenue ?? 0, 0, ',', '.')); ?></h3>
                        <h5 class="fw-bold mb-2">Pendapatan Bulan Ini</h5>
                        <p class="text-muted mb-0">Total pendapatan bulan ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Recent Products -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Produk Terbaru</h2>
            <p class="lead text-muted">Produk yang baru ditambahkan</p>
        </div>

        <div class="row g-4">
            <?php $__empty_1 = true; $__currentLoopData = $recentProducts ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-4 col-md-6">
                <div class="product-card fade-in-up">
                    <div class="position-relative">
                        <?php if($product->gambar): ?>
                            <img src="<?php echo e(asset('storage/'.$product->gambar)); ?>"
                                 alt="<?php echo e($product->nama_produk); ?>"
                                 class="img-fluid">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1518895949257-7621c3c786d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                                 alt="<?php echo e($product->nama_produk); ?>"
                                 class="img-fluid">
                        <?php endif; ?>
                        <div class="product-badge"><?php echo e($product->category->nama_kategori ?? 'Kategori'); ?></div>
                    </div>
                    <div class="p-4">
                        <h5 class="fw-bold mb-2"><?php echo e($product->nama_produk); ?></h5>
                        <p class="text-muted mb-3"><?php echo e(Str::limit($product->deskripsi, 60)); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <?php if($product->harga_diskon): ?>
                                    <span class="h5 text-primary mb-0">Rp<?php echo e(number_format($product->harga_diskon,0,',','.')); ?></span>
                                    <small class="text-muted text-decoration-line-through ms-2">Rp<?php echo e(number_format($product->harga,0,',','.')); ?></small>
                                <?php else: ?>
                                    <span class="h5 text-primary mb-0">Rp<?php echo e(number_format($product->harga,0,',','.')); ?></span>
                                <?php endif; ?>
                            </div>
                            <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn-accent btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-box me-1"></i>Stok: <?php echo e($product->stok); ?>

                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-shopping-bag text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="text-muted mb-3">Belum Ada Produk</h3>
                    <p class="text-muted mb-4">Mulai dengan menambahkan produk pertama Anda.</p>
                    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn-accent">
                        <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-5">
            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn-accent">
                <i class="fas fa-eye me-2"></i>Lihat Semua Produk
            </a>
        </div>
    </div>
</section>

<!-- Quick Actions -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Aksi Cepat</h2>
            <p class="lead text-muted">Kelola toko Anda dengan mudah</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="product-card fade-in-up text-center">
                    <div class="p-4">
                        <div class="mb-3">
                            <i class="fas fa-plus-circle text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Tambah Produk</h5>
                        <p class="text-muted mb-4">Tambahkan produk baru ke katalog</p>
                        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn-accent">
                            <i class="fas fa-plus me-2"></i>Tambah
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="product-card fade-in-up text-center">
                    <div class="p-4">
                        <div class="mb-3">
                            <i class="fas fa-tag text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Tambah Kategori</h5>
                        <p class="text-muted mb-4">Buat kategori baru untuk produk</p>
                        <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn-accent">
                            <i class="fas fa-plus me-2"></i>Tambah
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="product-card fade-in-up text-center">
                    <div class="p-4">
                        <div class="mb-3">
                            <i class="fas fa-shopping-cart text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Kelola Pesanan</h5>
                        <p class="text-muted mb-4">Lihat dan kelola semua pesanan</p>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn-accent">
                            <i class="fas fa-eye me-2"></i>Kelola
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="product-card fade-in-up text-center">
                    <div class="p-4">
                        <div class="mb-3">
                            <i class="fas fa-tags text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Kelola Kategori</h5>
                        <p class="text-muted mb-4">Edit dan kelola semua kategori</p>
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn-accent">
                            <i class="fas fa-eye me-2"></i>Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- System Info -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="product-card fade-in-up">
                    <div class="p-4 text-center">
                        <h3 class="fw-bold mb-4">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Informasi Sistem
                        </h3>
                        <div class="row mb-4">
                            <div class="col-6">
                                <div class="fw-bold text-primary fs-2"><?php echo e($lowStockProducts ?? 0); ?></div>
                                <small class="text-muted">Stok Rendah</small>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold text-warning fs-2"><?php echo e($outOfStockProducts ?? 0); ?></div>
                                <small class="text-muted">Stok Habis</small>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                Terakhir diupdate: <?php echo e(now()->format('d M Y H:i')); ?>

                            </small>
                        </div>
                    </div>
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
    el.classList.add('visible');
    observer.observe(el);
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>