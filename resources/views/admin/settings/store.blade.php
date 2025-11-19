@extends('layouts.admin')

@section('title', 'Pengaturan Toko')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Pengaturan Toko</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pengaturan Pembayaran & Ongkir</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.store.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="bank_name" class="form-label">Nama Bank</label>
                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" value="{{ old('bank_name', $bankName) }}" required>
                    @error('bank_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="bank_account_number" class="form-label">Nomor Rekening Bank</label>
                    <input type="text" class="form-control @error('bank_account_number') is-invalid @enderror" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', $bankAccount) }}" required>
                    @error('bank_account_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- 
                <div class="mb-3">
                    <label for="cost_per_km_outside_padang" class="form-label">Biaya Ongkir per KM (Luar Padang)</label>
                    <input type="number" step="0.01" class="form-control @error('cost_per_km_outside_padang') is-invalid @enderror" id="cost_per_km_outside_padang" name="cost_per_km_outside_padang" value="{{ old('cost_per_km_outside_padang', $costPerKm) }}" required>
                    @error('cost_per_km_outside_padang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="default_distance_outside_padang_km" class="form-label">Jarak Default (Luar Padang) dalam KM</label>
                    <input type="number" class="form-control @error('default_distance_outside_padang_km') is-invalid @enderror" id="default_distance_outside_padang_km" name="default_distance_outside_padang_km" value="{{ old('default_distance_outside_padang_km', $defaultDistance) }}" min="0" required>
                    @error('default_distance_outside_padang_km')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="google_maps_api_key" class="form-label">Google Maps API Key</label>
                    <input type="text" class="form-control @error('google_maps_api_key') is-invalid @enderror" id="google_maps_api_key" name="google_maps_api_key" value="{{ old('google_maps_api_key', $googleMapsApiKey) }}">
                    @error('google_maps_api_key')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                --}}
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

</div>
@endsection
