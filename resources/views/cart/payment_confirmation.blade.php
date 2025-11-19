@extends('layouts.store')

@section('title', 'Konfirmasi Pembayaran - Aresha Florist')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Konfirmasi Pembayaran Transfer Bank</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <p>Pesanan Anda <strong>#{{ $order->order_number }}</strong> menunggu pembayaran. Mohon transfer sebesar <strong>Rp{{ number_format($order->grand_total, 0, ',', '.') }}</strong> ke rekening <strong>{{ $bankName }}</strong> Nomor: <strong>{{ $bankAccountNumber }}</strong> a.n. Aresha Florist.</p>

                    <p class="mt-4">Setelah melakukan transfer, silakan unggah bukti pembayaran Anda di bawah ini:</p>

                    <form action="{{ route('cart.payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="proof_of_transfer_image" class="form-label">Unggah Bukti Transfer <span class="text-danger">*</span></label>
                            <input type="file"
                                   class="form-control @error('proof_of_transfer_image') is-invalid @enderror"
                                   id="proof_of_transfer_image"
                                   name="proof_of_transfer_image"
                                   accept="image/*" required>
                            @error('proof_of_transfer_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB.</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Bukti Transfer</button>
                        <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-secondary">Kembali ke Detail Pesanan</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection





