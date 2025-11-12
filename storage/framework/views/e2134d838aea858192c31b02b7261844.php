

<?php $__env->startSection('title', 'Daftar Pelanggan - Admin Panel'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users me-2"></i>Daftar Pelanggan</h2>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Pelanggan Terdaftar (<?php echo e($users->total()); ?>)</h5>
    </div>
    <div class="card-body">
        <?php if($users->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" class="fw-bold text-decoration-underline text-primary">
                                <?php echo e($user->name); ?>

                            </a>
                        </td>
                        <td><?php echo e($user->email); ?></td>
                        <td><?php echo e($user->created_at->format('d M Y H:i')); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.users.show', $user->id)); ?>" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($users->links()); ?>

        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-users text-muted" style="font-size: 4rem;"></i>
            <h3 class="text-muted mt-3">Belum Ada Pelanggan</h3>
            <p class="text-muted">Belum ada pelanggan yang terdaftar.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/admin/users/index.blade.php ENDPATH**/ ?>