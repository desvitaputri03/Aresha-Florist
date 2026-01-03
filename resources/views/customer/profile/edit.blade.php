@extends('layouts.store')

@section('title', 'Edit Profil - Aresha Florist')

@section('content')
<div class="dashboard-wrapper">
    <div class="dashboard-container">
        <div class="mb-4">
            <a href="{{ route('customer.dashboard') }}" class="text-muted text-decoration-none d-inline-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="card border-0 shadow-lg mx-auto overflow-hidden" style="border-radius: 20px; max-width: 550px;">
            <!-- Header Banner -->
            <div class="py-4 text-center" style="background: linear-gradient(135deg, var(--primary-color), #f6a3b9);">
                <h2 class="h4 mb-0 fw-bold text-white" style="font-family: 'Playfair Display', serif;">Pengaturan Profil</h2>
            </div>

            <div class="card-body p-4 p-md-5">
                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px; background: #f0fdf4; color: #166534;">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('customer.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold text-dark mb-2">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-user"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0 py-2" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold text-dark mb-2">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control border-start-0 ps-0 py-2" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>
                    </div>

                    <div class="my-4 py-2">
                        <div class="d-flex align-items-center">
                            <span class="fw-bold text-muted small text-uppercase ls-wide">Ganti Password</span>
                            <div class="flex-grow-1 ms-3 border-top opacity-10"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold text-dark mb-2">Password Baru <small class="text-muted fw-normal">(Opsional)</small></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0 py-2" id="password" name="password" autocomplete="new-password">
                        </div>
                        <p class="text-muted mt-2 mb-0" style="font-size: 0.75rem;">
                            <i class="fas fa-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengubah password lama.
                        </p>
                    </div>

                    <div class="mb-5">
                        <label for="password_confirmation" class="form-label fw-bold text-dark mb-2">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-shield-alt"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0 py-2" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="d-grid mt-2">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm" style="background: var(--primary-color); border: none;">
                            Update Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-wrapper {
        background: #fdfaf9;
        min-height: calc(100vh - 200px);
        padding: 4rem 0;
    }
    .ls-wide { letter-spacing: 0.1em; }
    
    .form-control {
        border-color: #dee2e6;
        transition: all 0.2s;
    }
    
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: none;
        z-index: 3;
    }
    
    .input-group-text {
        border-color: #dee2e6;
    }
    
    .input-group:focus-within .input-group-text {
        border-color: var(--primary-color);
        color: var(--primary-color) !important;
    }

    .btn-primary:active {
        transform: scale(0.98);
    }
</style>
@endsection


