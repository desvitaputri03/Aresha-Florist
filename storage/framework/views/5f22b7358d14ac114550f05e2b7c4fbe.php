<?php $__env->startSection('title', 'Kelola Produk - Admin Panel'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-shopping-bag me-2"></i>Kelola Produk</h2>
    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Produk Baru
    </a>
</div>

<!-- Filter & Search Bar -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Cari Produk</label>
                <div class="input-group">
                    <input type="text" name="search" value="<?php echo e($filters['search']); ?>" class="form-control" placeholder="Nama atau deskripsi karangan bunga...">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kategori</label>
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e($filters['category'] == $category->id ? 'selected' : ''); ?>>
                            <?php echo e($category->nama_kategori); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status Stok</label>
                <select name="stock_status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="in_stock" <?php echo e($filters['stock_status'] == 'in_stock' ? 'selected' : ''); ?>>Tersedia</option>
                    <option value="low_stock" <?php echo e($filters['stock_status'] == 'low_stock' ? 'selected' : ''); ?>>Stok Rendah</option>
                    <option value="out_of_stock" <?php echo e($filters['stock_status'] == 'out_of_stock' ? 'selected' : ''); ?>>Habis</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Urutkan</label>
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="latest" <?php echo e($filters['sort'] == 'latest' ? 'selected' : ''); ?>>Terbaru</option>
                    <option value="name_asc" <?php echo e($filters['sort'] == 'name_asc' ? 'selected' : ''); ?>>Nama A-Z</option>
                    <option value="name_desc" <?php echo e($filters['sort'] == 'name_desc' ? 'selected' : ''); ?>>Nama Z-A</option>
                    <option value="price_asc" <?php echo e($filters['sort'] == 'price_asc' ? 'selected' : ''); ?>>Harga Rendah</option>
                    <option value="price_desc" <?php echo e($filters['sort'] == 'price_desc' ? 'selected' : ''); ?>>Harga Tinggi</option>
                    <option value="stock_asc" <?php echo e($filters['sort'] == 'stock_asc' ? 'selected' : ''); ?>>Stok Rendah</option>
                    <option value="stock_desc" <?php echo e($filters['sort'] == 'stock_desc' ? 'selected' : ''); ?>>Stok Tinggi</option>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Produk</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loop->iteration + ($products->currentPage() - 1) * $products->perPage()); ?></td>
                        <td>
                            <?php if($product->gambar): ?>
                                <img src="<?php echo e(asset('storage/'.$product->gambar)); ?>"
                                     alt="<?php echo e($product->name); ?>"
                                     class="rounded"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="fw-bold"><?php echo e($product->name); ?></div>
                            <small class="text-muted"><?php echo e(Str::limit($product->deskripsi, 50)); ?></small>
                        </td>
                        <td>
                            <span class="badge" style="background: var(--accent-color); color: #ffffff;"><?php echo e($product->category->nama_kategori ?? '-'); ?></span>
                        </td>
                        <td>
                            <?php if($product->harga_diskon): ?>
                                <div class="text-success fw-bold">Rp<?php echo e(number_format($product->harga_diskon, 0, ',', '.')); ?></div>
                                <small class="text-muted text-decoration-line-through">Rp<?php echo e(number_format($product->harga, 0, ',', '.')); ?></small>
                            <?php else: ?>
                                <div class="fw-bold">Rp<?php echo e(number_format($product->harga, 0, ',', '.')); ?></div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($product->stok > 10): ?>
                                <span class="badge" style="background: var(--primary-color); color: #ffffff;"><?php echo e($product->stok); ?></span>
                            <?php elseif($product->stok > 0): ?>
                                <span class="badge" style="background: var(--accent-secondary); color: #ffffff;"><?php echo e($product->stok); ?></span>
                            <?php else: ?>
                                <span class="badge" style="background: var(--accent-color); color: #ffffff;">Habis</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($product->stok > 0): ?>
                                <span class="badge" style="background: var(--primary-color); color: #ffffff;">Aktif</span>
                            <?php else: ?>
                                <span class="badge" style="background: var(--accent-color); color: #ffffff;">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>"
                                   class="btn btn-sm btn-primary"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo e(route('products.show', $product->id)); ?>"
                                   class="btn btn-sm btn-success"
                                   title="Lihat"
                                   target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        onclick="deleteProduct(<?php echo e($product->id); ?>)"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                            Belum ada karangan bunga
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($products->links()); ?>

        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/admin/products/index.blade.php ENDPATH**/ ?>