@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<h2>Tambah Produk</h2>
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Kategori</label>
        <select name="id_kategori" class="form-control" required>
            <option value="">--Pilih Kategori--</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="harga" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Harga Diskon (Opsional)</label>
        <input type="number" name="harga_diskon" class="form-control">
    </div>
    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stok" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Gambar</label>
        <input type="file" name="gambar" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
