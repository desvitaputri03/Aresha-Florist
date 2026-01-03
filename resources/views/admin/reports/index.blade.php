@extends('layouts.admin')

@section('title', 'Laporan - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-chart-bar me-2"></i>Laporan</h2>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <form method="GET" action="{{ route('admin.reports.index') }}" class="w-100 me-3">
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label" for="period-select">Tipe Laporan:</label>
            <select class="form-select" id="period-select" name="period">
                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Bulanan</option>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label" for="start_month">Dari Bulan:</label>
            <select class="form-select" id="start_month" name="start_month">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ (isset(request()->start_month) && request()->start_month == $m) ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label" for="start_year">Tahun:</label>
            <select class="form-select" id="start_year" name="start_year">
                @for ($y = now()->year - 5; $y <= now()->year + 1; $y++)
                    <option value="{{ $y }}" {{ (isset(request()->start_year) && request()->start_year == $y) ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label" for="end_month">Sampai Bulan:</label>
            <select class="form-select" id="end_month" name="end_month">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ (isset(request()->end_month) && request()->end_month == $m) ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label" for="end_year">Tahun:</label>
            <select class="form-select" id="end_year" name="end_year">
                @for ($y = now()->year - 5; $y <= now()->year + 1; $y++)
                    <option value="{{ $y }}" {{ (isset(request()->end_year) && request()->end_year == $y) ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-md-1 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </div>
</form>
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
                    <td>{{ number_format($totalOrders, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Total Pendapatan</td>
                    <td>Rp{{ number_format($totalRevenue, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Produk Terlaris</td>
                    <td>{{ $topSellingProduct ? $topSellingProduct->product->name . ' (' . $topSellingProduct->total_quantity_sold . 'x)' : 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Pelanggan Aktif</td>
                    <td>{{ number_format($activeCustomers, 0, ',', '.') }}</td>
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
        labels: @json($labels),
        datasets: [{
            label: 'Penjualan Bulanan',
            data: @json($data),
            backgroundColor: 'rgba(194, 24, 91, 0.7)', // Menggunakan warna --primary-color dengan opacity
            borderColor: 'rgba(194, 24, 91, 1)', // Menggunakan warna --primary-color tanpa opacity
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
