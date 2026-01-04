@extends('layouts.admin')

@section('title', 'Laporan Analisis Penjualan - Aresha Florist')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="color: var(--primary-color); font-weight: 800;"><i class="fas fa-chart-line me-2"></i>Laporan Analisis Penjualan</h2>
</div>

<!-- 1. Filter Section (Tetap di Atas) -->
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body rounded shadow-sm" style="background-color: var(--secondary-color);">
        <form method="GET" action="{{ route('admin.reports.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label" style="color: var(--primary-color); font-weight: 700;">Dari Bulan:</label>
                    <select class="form-select border-primary" name="start_month">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $startMonth == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: var(--primary-color); font-weight: 700;">Tahun:</label>
                    <select class="form-select border-primary" name="start_year">
                        @for ($y = now()->year - 2; $y <= now()->year + 1; $y++)
                            <option value="{{ $y }}" {{ $startYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: var(--primary-color); font-weight: 700;">Sampai Bulan:</label>
                    <select class="form-select border-primary" name="end_month">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $endMonth == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: var(--primary-color); font-weight: 700;">Tahun:</label>
                    <select class="form-select border-primary" name="end_year">
                        @for ($y = now()->year - 2; $y <= now()->year + 1; $y++)
                            <option value="{{ $y }}" {{ $endYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1" style="background: var(--primary-color); border: none;">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.reports.pdf', request()->all()) }}" class="btn btn-danger" target="_blank" style="background: #dc3545; border: none;">
                        <i class="fas fa-file-pdf me-2"></i>Cetak PDF
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- 2. Grafik Penjualan (Pindah ke Sini) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold text-center" style="color: var(--primary-color);"><i class="fas fa-chart-bar me-2"></i>Tren Penjualan Bulanan</h5>
            </div>
            <div class="card-body" style="background-color: #fff;">
                <canvas id="salesChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- 3. Kotak Statistik (Bawah Grafik & Tanpa Produk Terlaris) -->
<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="background-color: var(--secondary-color); border-left: 5px solid var(--primary-color) !important;">
            <div class="card-body text-center py-4">
                <i class="fas fa-shopping-cart mb-2" style="font-size: 2rem; color: var(--primary-color);"></i>
                <h6 class="text-uppercase small fw-bold" style="color: var(--primary-color);">Total Pesanan</h6>
                <h3 class="mb-0 fw-bold" style="color: var(--primary-color);">{{ number_format($totalOrders, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="background-color: var(--secondary-color); border-left: 5px solid var(--primary-color) !important;">
            <div class="card-body text-center py-4">
                <i class="fas fa-wallet mb-2" style="font-size: 2rem; color: var(--primary-color);"></i>
                <h6 class="text-uppercase small fw-bold" style="color: var(--primary-color);">Total Pendapatan</h6>
                <h3 class="mb-0 fw-bold" style="color: var(--primary-color);">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm" style="background-color: var(--secondary-color); border-left: 5px solid var(--primary-color) !important;">
            <div class="card-body text-center py-4">
                <i class="fas fa-users mb-2" style="font-size: 2rem; color: var(--primary-color);"></i>
                <h6 class="text-uppercase small fw-bold" style="color: var(--primary-color);">Pelanggan Aktif</h6>
                <h3 class="mb-0 fw-bold" style="color: var(--primary-color);">{{ number_format($activeCustomers, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'bar',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: @json($data),
            backgroundColor: 'rgba(194, 24, 91, 0.7)',
            borderColor: 'rgba(194, 24, 91, 1)',
            borderWidth: 2,
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { 
            y: { 
                beginAtZero: true, 
                ticks: { callback: v => 'Rp' + v.toLocaleString('id-ID') } 
            } 
        }
    }
});
</script>
@endsection