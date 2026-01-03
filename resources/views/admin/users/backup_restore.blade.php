@extends('layouts.admin')

@section('title', 'Backup & Restore Pengguna')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-shield me-2"></i>Backup & Restore Pengguna</h2>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Backup Data Pengguna</h6>
    </div>
    <div class="card-body">
        <p>Cadangkan data pengguna Anda ke file CSV. File ini akan berisi informasi pengguna dasar.</p>
        <a href="{{ route('admin.users.backup') }}" class="btn btn-success">
            <i class="fas fa-download me-2"></i>Cadangkan Pengguna Sekarang
        </a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pulihkan Data Pengguna</h6>
    </div>
    <div class="card-body">
        <p>Unggah file CSV yang berisi data pengguna untuk memulihkan.</p>
        <form action="{{ route('admin.users.restore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="backup_file" class="form-label">Pilih File Backup (CSV)</label>
                <input type="file" class="form-control @error('backup_file') is-invalid @enderror" id="backup_file" name="backup_file" accept=".csv" required>
                @error('backup_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-warning" onclick="return confirm('PERINGATAN: Memulihkan data pengguna akan menimpa data yang ada. Lanjutkan?')">
                <i class="fas fa-upload me-2"></i>Pulihkan Pengguna
            </button>
        </form>
    </div>
</div>
@endsection

