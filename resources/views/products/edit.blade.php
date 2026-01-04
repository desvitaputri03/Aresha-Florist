@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<h2>Edit Produk</h2>
<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
    </div>
    <div class="mb-3">
        <label>Kategori</label>
        <select name="id_kategori" class="form-control" required>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $product->id_kategori == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control">{{ $product->deskripsi }}</textarea>
    </div>
    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="harga" class="form-control" value="{{ $product->harga }}" required>
    </div>
    <div class="mb-3">
        <label>Harga Diskon (Opsional)</label>
        <input type="number" name="harga_diskon" class="form-control" value="{{ $product->harga_diskon }}">
    </div>
    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stok" class="form-control" value="{{ $product->stok }}" required>
    </div>
    <div class="mb-3">
        <label>Gambar</label><br>
        @if($product->images->count() > 0)
            <img src="{{ asset('storage/'.$product->images->first()->image_path) }}" width="120" class="mb-2"><br>
        @endif
        <input type="file" name="gambar" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
