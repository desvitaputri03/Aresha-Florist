@extends('layouts.admin')

@section('title', 'Laporan - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-chart-bar me-2"></i>Laporan</h2>
</div>

<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.reports.pdf') }}" class="btn btn-danger" target="_blank">
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
                    <td>120</td>
                </tr>
                <tr>
                    <td>Total Pendapatan</td>
                    <td>Rp 25.000.000</td>
                </tr>
                <tr>
                    <td>Produk Terlaris</td>
                    <td>Bouquet Mawar Merah</td>
                </tr>
                <tr>
                    <td>Pelanggan Aktif</td>
                    <td>45</td>
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
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
            label: 'Pesanan',
            data: [10, 15, 20, 18, 25, 30, 28, 22, 19, 24, 27, 35],
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
@endsection
