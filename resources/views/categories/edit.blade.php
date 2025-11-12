@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Kategori</h2>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $category->name) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
