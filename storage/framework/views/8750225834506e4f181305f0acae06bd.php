

<?php $__env->startSection('title', 'Keranjang Belanja - Aresha Florist'); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="py-3">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Keranjang Belanja</li>
        </ol>
    </div>
</nav>

<!-- Cart Section -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-5 fw-bold">
                <i class="fas fa-shopping-cart me-3"></i>Keranjang Belanja
            </h1>
            <?php if($cartItems->count() > 0): ?>
                <form action="<?php echo e(route('cart.clear')); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                        <i class="fas fa-trash me-2"></i>Kosongkan Keranjang
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <?php if($cartItems->count() > 0): ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="cart-item border-bottom pb-4 mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <?php if($item->product->gambar): ?>
                                        <img src="<?php echo e(asset('storage/'.$item->product->gambar)); ?>" 
                                             alt="<?php echo e($item->product->nama_produk); ?>" 
                                             class="img-fluid rounded">
                                    <?php else: ?>
                                        <img src="https://images.unsplash.com/photo-1518895949257-7621c3c786d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" 
                                             alt="<?php echo e($item->product->nama_produk); ?>" 
                                             class="img-fluid rounded">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="fw-bold mb-2"><?php echo e($item->product->nama_produk); ?></h5>
                                    <p class="text-muted mb-2"><?php echo e(Str::limit($item->product->deskripsi, 80)); ?></p>
                                    <small class="text-muted">
                                        <i class="fas fa-tag me-1"></i><?php echo e($item->product->category->nama_kategori ?? 'Kategori'); ?>

                                    </small>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST" class="d-flex">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <input type="number" 
                                                   name="quantity" 
                                                   value="<?php echo e($item->quantity); ?>" 
                                                   min="1" 
                                                   max="<?php echo e($item->product->stok); ?>"
                                                   class="form-control text-center" 
                                                   style="width: 80px;"
                                                   onchange="this.form.submit()">
                                        </form>
                                    </div>
                                    <small class="text-muted">Stok: <?php echo e($item->product->stok); ?></small>
                                </div>
                                <div class="col-md-2 text-center">
                                    <?php
                                        $price = $item->product->harga_diskon ?? $item->product->harga;
                                        $itemTotal = $price * $item->quantity;
                                    ?>
                                    <div class="fw-bold text-primary">Rp<?php echo e(number_format($itemTotal, 0, ',', '.')); ?></div>
                                    <?php if($item->product->harga_diskon): ?>
                                        <small class="text-muted text-decoration-line-through">
                                            Rp<?php echo e(number_format($item->product->harga * $item->quantity, 0, ',', '.')); ?>

                                        </small>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-2 text-center">
                                    <form action="<?php echo e(route('cart.remove', $item->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus item ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>Ringkasan Belanja
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Item:</span>
                            <span class="fw-bold"><?php echo e($cartItems->sum('quantity')); ?> item</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal:</span>
                            <span class="fw-bold">Rp<?php echo e(number_format($total, 0, ',', '.')); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Ongkir:</span>
                            <span class="fw-bold">Gratis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="h5 mb-0">Total:</span>
                            <span class="h5 text-primary fw-bold mb-0">Rp<?php echo e(number_format($total, 0, ',', '.')); ?></span>
                        </div>
                        <a href="<?php echo e(route('cart.checkout')); ?>" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-credit-card me-2"></i>Lanjut ke Checkout
                        </a>
                        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-primary w-100 mt-2">
                            <i class="fas fa-arrow-left me-2"></i>Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Empty Cart -->
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-cart text-muted" style="font-size: 5rem;"></i>
            </div>
            <h3 class="text-muted mb-3">Keranjang Belanja Kosong</h3>
            <p class="text-muted mb-4">Belum ada produk di keranjang Anda. Mari mulai berbelanja!</p>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Mulai Belanja
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.store', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/cart/index.blade.php ENDPATH**/ ?>