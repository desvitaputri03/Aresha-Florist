

<?php $__env->startSection('title', 'Laporan - Admin Panel'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-chart-bar me-2"></i>Laporan</h2>
</div>

<div class="d-flex justify-content-end mb-3">
    <a href="<?php echo e(route('admin.reports.pdf')); ?>" class="btn btn-danger" target="_blank">
        <i class="fas fa-file-pdf me-2"></i>Cetak PDF
    </a>
</div>
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Grafik Penjualan Bulanan</h5>
    </div>
    <div class="card-body">
        <canvas id="ordersChart" height="100"></canvas>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Statistik Penjualan</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Statistik</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Pesanan</td>
                    <td><?php echo e(number_format($totalOrders, 0, ',', '.')); ?></td>
                </tr>
                <tr>
                    <td>Total Pendapatan</td>
                    <td>Rp<?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></td>
                </tr>
                <tr>
                    <td>Produk Terlaris</td>
                    <td><?php echo e($topSellingProduct ? $topSellingProduct->product->name . ' (' . $topSellingProduct->total_quantity_sold . 'x)' : 'N/A'); ?></td>
                </tr>
                <tr>
                    <td>Pelanggan Aktif</td>
                    <td><?php echo e(number_format($activeCustomers, 0, ',', '.')); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('ordersChart').getContext('2d');
const ordersChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels, 15, 512) ?>,
        datasets: [{
            label: 'Penjualan Bulanan',
            data: <?php echo json_encode($data, 15, 512) ?>,
            backgroundColor: 'rgba(233, 109, 143, 0.7)',
            borderColor: 'rgba(233, 109, 143, 1)',
            borderWidth: 2,
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\vita\aresha-florist (2)\aresha-florist\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>