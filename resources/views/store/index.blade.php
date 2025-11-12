@extends('layouts.store')

@section('content')

<!-- Hero Section -->
<div class="p-5 mb-5 text-center bg-light rounded-3">
    <h1 class="display-4 fw-bold text-success">Selamat Datang di Aresha Florist 🌸</h1>
    <p class="lead">Temukan bunga segar terbaik untuk setiap momen spesialmu.</p>
    <a href="#produk" class="btn btn-lg btn-success mt-3">Lihat Koleksi</a>
</div>

<!-- Kategori -->
<h3 class="mb-4 text-center">Kategori Bunga</h3>
<div class="d-flex justify-content-center flex-wrap mb-5">
    @foreach($categories as $category)
        <a href="#produk" class="btn btn-outline-success m-2">{{ $category->name }}</a>
    @endforeach
</div>

<!-- Produk -->
<h3 id="produk" class="mb-4 text-center">Produk Terbaru</h3>
<div class="row">
    @foreach($products as $product)
    <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
            @else
                <img src="https://via.placeholder.com/250" class="card-img-top" alt="no image">
            @endif
            <div class="card-body text-center">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="text-success fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <a href="{{ route('store.show', $product->id) }}" class="btn btn-sm btn-success">Lihat Detail</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Call to Action -->
<div class="text-center p-5 bg-success text-white rounded mt-5">
    <h2 class="fw-bold">Pesan Bunga Sekarang</h2>
    <p>Buat momen spesialmu lebih indah dengan rangkaian bunga segar dari kami.</p>
    <a href="#produk" class="btn btn-light btn-lg">Belanja Sekarang</a>
</div>

@endsection
