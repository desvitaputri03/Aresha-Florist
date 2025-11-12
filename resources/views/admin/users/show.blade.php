@extends('layouts.admin')

@section('title', 'Detail Pelanggan - Admin Panel')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Detail Pelanggan</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Nama</div>
            <div class="col-md-9">{{ $user->name }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Email</div>
            <div class="col-md-9">{{ $user->email }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Tanggal Daftar</div>
            <div class="col-md-9">{{ $user->created_at->format('d M Y H:i') }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3 fw-bold">Status</div>
            <div class="col-md-9">
                @if($user->is_admin)
                    <span class="badge bg-primary">Admin</span>
                @else
                    <span class="badge bg-success">Customer</span>
                @endif
            </div>
        </div>
    </div>
</div>
<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pesanan
</a>
@endsection
