@extends('layouts.admin')

@section('title', 'Laporan Produk Populer - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-star me-2"></i>Laporan Produk Populer</h2>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Filter Laporan Produk Populer</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.popular-products') }}" class="row g-3">
            <div class="col-md-5">
                <label for="start_date" class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-5">
                <label for="end_date" class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-2"></i>Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Hasil Laporan Produk Populer</h5>
    </div>
    <div class="card-body">
        @if($popularProducts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Jumlah Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($popularProducts as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name ?? 'Produk tidak ditemukan' }}</td>
                                <td>{{ $item->product->category->name ?? '-' }}</td>
                                <td>{{ $item->total_quantity_sold }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info mb-0">
                Tidak ada data produk populer yang ditemukan untuk filter yang dipilih.
            </div>
        @endif
    </div>
</div>
@endsection

