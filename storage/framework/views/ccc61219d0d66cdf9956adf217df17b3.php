<?php $__env->startSection('title', 'Dashboard Customer - Aresha Florist'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Selamat Datang, <?php echo e(auth()->user()->name ?? 'Customer'); ?>!</h4>
                </div>
                <div class="card-body">
                    <p>Dari sini, Anda dapat mengelola akun Anda dan melihat pesanan Anda.</p>
                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-user-edit fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Edit Profil</h5>
                                    <p class="card-text">Perbarui informasi pribadi Anda.</p>
                                    <a href="<?php echo e(route('customer.profile.edit')); ?>" class="btn btn-accent">Perbarui</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-box-open fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Pesanan Saya</h5>
                                    <p class="card-text">Lacak dan kelola pesanan Anda.</p>
                                    <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-accent">Lihat Pesanan</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-shopping-cart fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Keranjang</h5>
                                    <p class="card-text">Lihat item di keranjang Anda.</p>
                                    <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-accent">Lihat Keranjang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.store', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>