<?php $__env->startSection('title', 'Konfirmasi Pembayaran - Aresha Florist'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Konfirmasi Pembayaran Transfer Bank</h4>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <p>Pesanan Anda <strong>#<?php echo e($order->order_number); ?></strong> menunggu pembayaran. Mohon transfer sebesar <strong>Rp<?php echo e(number_format($order->grand_total, 0, ',', '.')); ?></strong> ke rekening <strong><?php echo e($bankName); ?></strong> Nomor: <strong><?php echo e($bankAccountNumber); ?></strong> a.n. Aresha Florist.</p>

                    <p class="mt-4">Setelah melakukan transfer, silakan unggah bukti pembayaran Anda di bawah ini:</p>

                    <form action="<?php echo e(route('cart.payment.upload', $order->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="proof_of_transfer_image" class="form-label">Unggah Bukti Transfer <span class="text-danger">*</span></label>
                            <input type="file"
                                   class="form-control <?php $__errorArgs = ['proof_of_transfer_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="proof_of_transfer_image"
                                   name="proof_of_transfer_image"
                                   accept="image/*" required>
                            <?php $__errorArgs = ['proof_of_transfer_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Bukti Transfer</button>
                        <a href="<?php echo e(route('customer.orders.show', $order->id)); ?>" class="btn btn-secondary">Kembali ke Detail Pesanan</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>






<?php echo $__env->make('layouts.store', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/cart/payment_confirmation.blade.php ENDPATH**/ ?>