@extends('layouts.store')

@section('content')
<div class="row">
    <div class="col-md-5">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded">
        @else
            <img src="https://via.placeholder.com/300" class="img-fluid rounded">
        @endif
    </div>
    <div class="col-md-7">
        <h2>{{ $product->name }}</h2>
        <h4 class="text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
        <p>{{ $product->description }}</p>
        <button class="btn btn-primary">Tambah ke Keranjang</button>
    </div>
</div>
@endsection
