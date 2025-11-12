@extends('layouts.admin')

@section('title', 'Daftar Pelanggan - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users me-2"></i>Daftar Pelanggan</h2>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Pelanggan Terdaftar ({{ $users->total() }})</h5>
    </div>
    <div class="card-body">
        @if($users->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="fw-bold text-decoration-underline text-primary">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-users text-muted" style="font-size: 4rem;"></i>
            <h3 class="text-muted mt-3">Belum Ada Pelanggan</h3>
            <p class="text-muted">Belum ada pelanggan yang terdaftar.</p>
        </div>
        @endif
    </div>
</div>
@endsection
