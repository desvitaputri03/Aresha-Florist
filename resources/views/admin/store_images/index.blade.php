@extends('layouts.admin')

@section('title', 'Manajemen Gambar Toko - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-images me-2"></i>Manajemen Gambar Toko</h2>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Unggah Gambar Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.store-images.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="images" class="form-label">Pilih Gambar (Bisa lebih dari satu)</label>
                <input type="file" 
                       class="form-control @error('images.*') is-invalid @enderror" 
                       id="images" 
                       name="images[]" 
                       accept="image/*" 
                       multiple>
                @error('images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Format: JPG, PNG. Maksimal 2MB per gambar</small>
            </div>
            <div id="newImagePreview" class="mt-3 row g-2">
                <!-- New image previews will be dynamically added here -->
            </div>
            <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-upload me-2"></i>Unggah Gambar</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Gambar Toko Saat Ini</h5>
    </div>
    <div class="card-body">
        @if($images->count() > 0)
            <div class="row g-3">
                @foreach($images as $image)
                    <div class="col-md-3 col-sm-4 col-6 position-relative">
                        <img src="{{ asset('storage/'.$image->image_path) }}"
                             alt="Gambar Toko {{ $loop->iteration }}"
                             class="img-fluid rounded shadow-sm" 
                             style="height: 150px; object-fit: cover; width: 100%;">
                        <form action="{{ route('admin.store-images.destroy', $image->id) }}" method="POST" class="position-absolute top-0 end-0 m-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info mb-0">
                Belum ada gambar toko yang diunggah.
            </div>
        @endif
    </div>
</div>

<script>
// Image preview functionality for new multiple images
document.getElementById('images').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('newImagePreview');
    previewContainer.innerHTML = ''; // Clear existing previews

    if (e.target.files.length > 0) {
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const colDiv = document.createElement('div');
                colDiv.className = 'col-md-3 col-sm-4 col-6'; // Adjust column size as needed
                colDiv.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" class="img-fluid rounded shadow-sm" style="height: 150px; object-fit: cover; width: 100%;">
                `;
                previewContainer.appendChild(colDiv);
            };
            reader.readAsDataURL(file);
        });
    } else {
        previewContainer.innerHTML = '';
    }
});
</script>
@endsection

