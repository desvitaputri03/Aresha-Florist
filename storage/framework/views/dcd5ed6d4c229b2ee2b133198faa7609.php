<?php $__env->startSection('title', 'Detail Pesanan - Aresha Florist'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Detail Pesanan #<?php echo e($order->id); ?></h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status Pesanan:</strong>
                        <span class="badge bg-<?php echo e(($order->order_status === 'pending' || $order->order_status === 'pending_payment') ? 'warning' : ($order->order_status === 'delivered' ? 'success' : 'danger')); ?> ms-2">
                            <?php echo e(ucfirst($order->order_status)); ?>

                        </span>
                    </div>
                    <div class="mb-3">
                        <strong>Status Pembayaran:</strong>
                        <?php if($order->payment_status === 'pending_transfer'): ?>
                            <span class="badge bg-warning ms-2">Menunggu Bukti Transfer</span>
                            <?php if($order->payment_method === 'transfer'): ?>
                                <a href="<?php echo e(route('cart.payment.confirm', $order->id)); ?>" class="btn btn-sm btn-success ms-2">Unggah Bukti TF</a>
                            <?php endif; ?>
                        <?php elseif($order->payment_status === 'awaiting_admin_approval'): ?>
                            <span class="badge bg-info ms-2">Menunggu Verifikasi Admin</span>
                        <?php elseif($order->payment_status === 'paid'): ?>
                            <span class="badge bg-success ms-2">Lunas</span>
                        <?php else: ?>
                            <span class="badge bg-secondary ms-2"><?php echo e(ucfirst($order->payment_status)); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <strong>Tanggal Pesanan:</strong> <?php echo e($order->created_at->format('d M Y H:i')); ?>

                    </div>
                    <div class="mb-3">
                        <strong>Alamat Pengiriman:</strong> <?php echo e($order->customer_address); ?>

                    </div>
                    <div class="mb-3">
                        <strong>Total Harga:</strong> Rp<?php echo e(number_format($order->grand_total, 0, ',', '.')); ?>

                    </div>

                    <?php if($order->payment_method === 'transfer' && $order->proof_of_transfer_image): ?>
                        <div class="mb-3">
                            <strong>Bukti Transfer:</strong>
                            <div class="mt-2">
                                <a href="<?php echo e(asset('storage/'.$order->proof_of_transfer_image)); ?>" target="_blank">
                                    <img src="<?php echo e(asset('storage/'.$order->proof_of_transfer_image)); ?>" 
                                         alt="Bukti Transfer"
                                         class="img-fluid rounded" 
                                         style="max-height: 200px;">
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <h5 class="mt-4">Item Pesanan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kuantitas</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item->product->name); ?></td>
                                        <td><?php echo e($item->quantity); ?></td>
                                        <td>Rp<?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                                        <td>Rp<?php echo e(number_format($item->quantity * $item->price, 0, ',', '.')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-secondary mt-3">Kembali ke Daftar Pesanan</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.store', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/customer/orders/show.blade.php ENDPATH**/ ?>