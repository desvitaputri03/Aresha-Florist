@extends('layouts.admin')

@section('title', 'Pengaturan Toko')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #C2185B; font-weight: 800;">
            <i class="fas fa-cogs me-2"></i>Pengaturan Toko
        </h2>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header py-3" style="background-color: #C2185B !important; border: none;">
            <h5 class="mb-0 text-white fw-bold">
                <i class="fas fa-university me-2"></i>Informasi Rekening Bank
            </h5>
        </div>
        <div class="card-body" style="background-color: #FCE4EC !important; padding: 2rem;">
            <form action="{{ route('admin.settings.store.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="bank_name" class="form-label fw-bold" style="color: #C2185B;">
                        <i class="fas fa-bank me-2"></i>Nama Bank
                    </label>
                    <input type="text" 
                           class="form-control @error('bank_name') is-invalid @enderror" 
                           id="bank_name" 
                           name="bank_name" 
                           value="{{ old('bank_name', $bankName) }}" 
                           placeholder="Contoh: Bank BCA, Bank Mandiri, dll"
                           required
                           style="border: 1px solid #F8BBD9; background-color: white; padding: 12px;">
                    @error('bank_name')
                        <div class="invalid-feedback d-block mt-2">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="bank_account_number" class="form-label fw-bold" style="color: #C2185B;">
                        <i class="fas fa-credit-card me-2"></i>Nomor Rekening Bank
                    </label>
                    <input type="text" 
                           class="form-control @error('bank_account_number') is-invalid @enderror" 
                           id="bank_account_number" 
                           name="bank_account_number" 
                           value="{{ old('bank_account_number', $bankAccount) }}" 
                           placeholder="Contoh: 1234567890"
                           required
                           style="border: 1px solid #F8BBD9; background-color: white; padding: 12px; font-family: monospace; letter-spacing: 1px;">
                    @error('bank_account_number')
                        <div class="invalid-feedback d-block mt-2">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="alert alert-info rounded-3 mb-4" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Info:</strong> Informasi rekening bank ini akan ditampilkan kepada customer saat mereka melakukan pembayaran transfer.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-lg rounded-pill fw-bold" style="background-color: #C2185B; color: white; border: none; padding: 12px 30px;">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-lg rounded-pill fw-bold" style="background-color: #ccc; color: #333; border: none; padding: 12px 30px;">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 mt-4" style="border-radius: 15px; overflow: hidden; background-color: #FFF7F5;">
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3" style="color: #C2185B;">
                <i class="fas fa-preview me-2"></i>Pratinjau untuk Customer
            </h6>
            <div style="background: white; padding: 20px; border-radius: 10px; border: 1px solid #F8BBD9;">
                <p class="small text-muted mb-2"><strong>Nama Bank</strong></p>
                <p class="fw-bold mb-3">{{ $bankName !== '-' ? $bankName : '(Belum diatur)' }}</p>
                
                <p class="small text-muted mb-2"><strong>Nomor Rekening</strong></p>
                <p class="fw-bold font-monospace">{{ $bankAccount !== '-' ? $bankAccount : '(Belum diatur)' }}</p>
            </div>
        </div>
    </div>

</div>
@endsection