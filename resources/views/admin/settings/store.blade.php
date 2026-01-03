@extends('layouts.admin')

@section('title', 'Pengaturan Toko')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Pengaturan Toko</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pengaturan Pembayaran</h6>
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

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

</div>
@endsection