<?php $__env->startSection('title', 'Pesanan Saya - Aresha Florist'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Pesanan Saya</h4>
                </div>
                <div class="card-body">
                    <?php if($orders->isEmpty()): ?>
                        <div class="alert alert-info">Anda belum memiliki pesanan.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status Pesanan</th>
                                        <th>Status Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($order->id); ?></td>
                                            <td><?php echo e($order->created_at->format('d M Y')); ?></td>
                                            <td>Rp<?php echo e(number_format($order->grand_total, 0, ',', '.')); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e(($order->order_status === 'pending' || $order->order_status === 'pending_payment') ? 'warning' : ($order->order_status === 'delivered' ? 'success' : 'danger')); ?>">
                                                    <?php echo e(ucfirst($order->order_status)); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <?php if($order->payment_status === 'pending_transfer'): ?>
                                                    <span class="badge bg-warning">Menunggu Bukti TF</span>
                                                <?php elseif($order->payment_status === 'awaiting_admin_approval'): ?>
                                                    <span class="badge bg-info">Menunggu Verifikasi Admin</span>
                                                <?php elseif($order->payment_status === 'paid'): ?>
                                                    <span class="badge bg-success">Lunas</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?php echo e(ucfirst($order->payment_status)); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo e(route('customer.orders.show', $order->id)); ?>" class="btn btn-sm btn-accent-outline">Lihat Detail</a>
                                                <?php if($order->payment_method === 'transfer' && $order->payment_status === 'pending_transfer'): ?>
                                                    <a href="<?php echo e(route('cart.payment.confirm', $order->id)); ?>" class="btn btn-sm btn-success mt-1">Unggah Bukti TF</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.store', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/customer/orders/index.blade.php ENDPATH**/ ?>