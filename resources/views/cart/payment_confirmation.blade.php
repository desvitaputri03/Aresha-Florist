@extends('layouts.store')

@section('title', 'Konfirmasi Pembayaran - Aresha Florist')

@section('content')
<div class="dashboard-wrapper">
    <div class="dashboard-container">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('customer.orders.show', $order->id) }}" class="text-muted text-decoration-none">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail Pesanan
            </a>
            <h2 class="h4 mb-0 fw-bold" style="font-family: 'Playfair Display', serif;">Konfirmasi Pembayaran Transfer</h2>
        </div>

        <div class="row g-4">
            <!-- Bank Information -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 20px; background: linear-gradient(135deg, #FFF7F5 0%, #FCE4EC 100%);">
                    <h5 class="fw-bold mb-4" style="color: var(--primary-color);">
                        <i class="fas fa-university me-2"></i>Informasi Rekening Bank
                    </h5>
                    
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info rounded-3 mb-3" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Silakan transfer ke rekening berikut:</strong>
                    </div>

                    <div class="mb-4">
                        <label class="small text-muted d-block mb-2">Nama Bank</label>
                        <div class="p-3 bg-white rounded-3 border border-1">
                            <span class="fw-bold fs-5">{{ $bankName !== '-' ? $bankName : 'Hubungi Admin untuk Info Rekening' }}</span>
                            @if($bankName === '-')
                                <div class="small text-danger mt-2">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Admin belum mengatur informasi rekening
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="small text-muted d-block mb-2">Nomor Rekening</label>
                        <div class="p-3 bg-white rounded-3 border border-1 d-flex justify-content-between align-items-center">
                            <span class="fw-bold fs-5 font-monospace">{{ $bankAccountNumber !== '-' ? $bankAccountNumber : '(Hubungi Admin)' }}</span>
                            @if($bankAccountNumber !== '-')
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="copyToClipboard('{{ $bankAccountNumber }}')">
                                    <i class="fas fa-copy me-1"></i>Salin
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 border-start border-primary border-4">
                        <small class="text-muted d-block mb-2"><strong>Jumlah Transfer:</strong></small>
                        <span class="h5 fw-bold text-primary">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Upload Proof Section -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 20px;">
                    <h5 class="fw-bold mb-4" style="color: var(--primary-color);">
                        <i class="fas fa-receipt me-2"></i>Unggah Bukti Transfer
                    </h5>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Ada kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-warning rounded-3 mb-4" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Penting!</strong> Upload screenshot atau foto bukti transfer Anda agar pesanan dapat diverifikasi.
                    </div>

                    <form action="{{ route('cart.payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        <div class="mb-4">
                            <label for="proof_of_transfer_image" class="form-label fw-bold mb-3">
                                <i class="fas fa-image me-2"></i>Pilih Bukti Transfer
                            </label>
                            <div class="upload-area rounded-3 p-5 text-center border-2 border-dashed" id="uploadArea" style="border-color: var(--primary-color); background-color: #fafafa; cursor: pointer;">
                                <i class="fas fa-cloud-upload-alt" style="font-size: 3rem; color: var(--primary-color); opacity: 0.5;"></i>
                                <p class="mt-3 text-muted mb-2">Seret file di sini atau klik untuk memilih</p>
                                <small class="text-muted d-block">Format: JPG, PNG, PDF (Maks 5MB)</small>
                                <input type="file" id="proof_of_transfer_image" name="proof_of_transfer_image" 
                                       accept=".jpg,.jpeg,.png,.pdf" required
                                       style="display: none;">
                            </div>
                            @error('proof_of_transfer_image')
                                <div class="text-danger small mt-2"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Preview -->
                        <div id="filePreview" class="mb-4" style="display: none;">
                            <label class="form-label fw-bold mb-2">Preview File</label>
                            <div class="p-3 bg-light rounded-3 border border-1">
                                <img id="previewImage" src="" alt="Preview" class="img-fluid rounded-2" style="max-height: 200px; display: none;">
                                <p id="previewFileName" class="mt-2 mb-0 text-muted small"></p>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg rounded-pill fw-bold" style="background: var(--primary-color); border: none; color: white; padding: 12px;">
                                <i class="fas fa-check me-2"></i>Konfirmasi Upload Bukti Transfer
                            </button>
                            <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-outline-secondary btn-lg rounded-pill">
                                Kembali
                            </a>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="alert alert-info rounded-3 mb-0" role="alert">
                        <h6 class="fw-bold mb-2"><i class="fas fa-lightbulb me-2"></i>Tips Upload:</h6>
                        <ul class="mb-0 small ms-2">
                            <li>Pastikan bukti transfer jelas dan terlihat nama bank, nomor rekening tujuan, dan nominal transfer</li>
                            <li>File harus dalam format JPG, PNG, atau PDF</li>
                            <li>Ukuran file maksimal 5MB</li>
                            <li>Setelah upload, tim admin akan memverifikasi dalam 1-2 jam</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-wrapper {
        background: linear-gradient(135deg, #FFF7F5 0%, #ffffff 100%);
        min-height: calc(100vh - 200px);
        padding: 3rem 0;
    }

    .upload-area {
        transition: all 0.3s ease;
    }

    .upload-area:hover {
        background-color: #f8f9fa !important;
        border-color: var(--primary-color) !important;
    }

    .upload-area.drag-over {
        background-color: #FCE4EC !important;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 20px rgba(193, 33, 91, 0.1);
    }
</style>

<script>
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('proof_of_transfer_image');
    const filePreview = document.getElementById('filePreview');
    const previewImage = document.getElementById('previewImage');
    const previewFileName = document.getElementById('previewFileName');

    // Click to upload
    uploadArea.addEventListener('click', () => fileInput.click());

    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('drag-over');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('drag-over');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            handleFileSelect();
        }
    });

    // File selection handler
    fileInput.addEventListener('change', handleFileSelect);

    function handleFileSelect() {
        const file = fileInput.files[0];
        if (!file) return;

        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('File terlalu besar! Maksimal 5MB.');
            fileInput.value = '';
            filePreview.style.display = 'none';
            return;
        }

        // Show preview
        filePreview.style.display = 'block';
        previewFileName.textContent = file.name + ' (' + (file.size / 1024).toFixed(2) + ' KB)';

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.style.display = 'none';
        }
    }

    function copyToClipboard(text) {
        if (!text) {
            alert('Nomor rekening tidak tersedia. Silakan hubungi admin.');
            return;
        }
        navigator.clipboard.writeText(text).then(() => {
            alert('Nomor rekening berhasil disalin!');
        });
    }

    // Form submit handler
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        if (!fileInput.files.length) {
            e.preventDefault();
            alert('Pilih file bukti transfer terlebih dahulu!');
            return false;
        }
    });
</script>
@endsection





