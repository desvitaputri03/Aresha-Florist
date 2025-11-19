

<?php $__env->startSection('title', 'Register - Aresha Florist'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Register</h4>
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo e(route('register.post')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-success">Daftar</button>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-link">Sudah punya akun? Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

 

<?php echo $__env->make('layouts.store', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/auth/register.blade.php ENDPATH**/ ?>