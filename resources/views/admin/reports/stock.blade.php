@extends('layouts.admin')

@section('title', 'Laporan Stok Produk - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-chart-bar me-2"></i>Laporan Stok Produk</h2>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Filter Laporan Stok</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.stock') }}" class="row g-3">
            <div class="col-md-4">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-select" id="category_id" name="category_id">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="start_date" class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
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
        <h5 class="mb-0">Hasil Laporan Stok</h5>
    </div>
    <div class="card-body">
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Tanggal Dibuat</th>
                            <th>Tanggal Diperbarui</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? '-' }}</td>
                                <td>
                                    @if($product->stok > 10)
                                        <span class="badge bg-success">{{ $product->stok }}</span>
                                    @elseif($product->stok > 0)
                                        <span class="badge bg-warning">{{ $product->stok }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $product->stok }}</span>
                                    @endif
                                </td>
                                <td>{{ $product->created_at->format('d M Y') }}</td>
                                <td>{{ $product->updated_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info mb-0">
                Tidak ada data stok produk yang ditemukan untuk filter yang dipilih.
            </div>
        @endif
    </div>
</div>
@endsection

