

<?php $__env->startSection('title', 'Detail Pelanggan - Admin Panel'); ?>

<?php $__env->startSection('content'); ?>
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Detail Pelanggan</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Nama</div>
            <div class="col-md-9"><?php echo e($user->name); ?></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Email</div>
            <div class="col-md-9"><?php echo e($user->email); ?></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Tanggal Daftar</div>
            <div class="col-md-9"><?php echo e($user->created_at->format('d M Y H:i')); ?></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Status</div>
            <div class="col-md-9">
                <?php if($user->is_admin): ?>
                    <span class="badge bg-primary">Admin</span>
                <?php else: ?>
                    <span class="badge bg-success">Customer</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pesanan
</a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/admin/users/show.blade.php ENDPATH**/ ?>