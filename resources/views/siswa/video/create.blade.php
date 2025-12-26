@extends('layouts.siswa')

@section('title', 'Upload Video Baru - SIPENA')
@section('body_class', 'dashboard-page')

@section('content')
    <div class="container my-4">
        <section class="content-section">
            <a href="{{ route('artikel-siswa.upload') }}" class="btn-kembali mb-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <h2 class="section-title">Form Upload Video</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="videoForm" action="{{ route('video.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="form-card">
                            <div class="mb-4">
                                <label for="judul" class="form-label fw-bold fs-5">Judul Video</label>
                                <input type="text" name="judul" id="judul" class="form-control form-control-lg"
                                    value="{{ old('judul') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label fw-bold fs-5">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5">{{ old('deskripsi') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="id_kategori" class="form-label fw-bold fs-5">Kategori (Opsional)</label>
                                <select name="id_kategori" id="id_kategori" class="form-select">
                                    <option value="">Pilih Kategori...</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="video" class="form-label fw-bold fs-5">File Video</label>
                                <input type="file" name="video" id="video" class="form-control" required
                                    accept="video/mp4,video/webm,video/ogg">
                                <small class="form-text text-muted">Format yang didukung: MP4, WebM, OGG. Maksimal ukuran:
                                    50MB.</small>
                            </div>
                            <div class="d-grid mt-4">
                                <!-- Tombol ini TIDAK langsung submit -->
                                <button type="button" class="btn btn-primary fw-bold btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#konfirmasiModal">
                                    Upload Video
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="mb-0 fs-5">
                        Apakah Anda yakin ingin mengupload video ini untuk direview?
                        <br><br>
                        <small class="text-muted">Setelah dikirim, video tidak dapat diedit sampai proses review
                            selesai.</small>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <!-- Tombol ini submit form -->
                    <button type="submit" class="btn btn-primary fw-bold" form="videoForm">Ya, Upload Sekarang</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Validation Error Modal -->
    <div class="modal fade" id="validationErrorModal" tabindex="-1" aria-labelledby="validationErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="validationErrorModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Validasi Gagal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="validationErrorList" class="text-danger mb-0"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadBtn = document.querySelector('[data-bs-target="#konfirmasiModal"]');
    const videoInput = document.getElementById('video');
    const judulInput = document.getElementById('judul');
    
    // Allowed video types
    const allowedTypes = ['video/mp4', 'video/webm', 'video/ogg'];
    const maxSize = 50 * 1024 * 1024; // 50 MB in bytes
    
    uploadBtn.addEventListener('click', function(e) {
        const errors = [];
        
        // Validate title
        if (!judulInput.value.trim()) {
            errors.push('Judul video wajib diisi.');
        }
        
        // Validate video file
        if (!videoInput.files || videoInput.files.length === 0) {
            errors.push('File video wajib dipilih.');
        } else {
            const file = videoInput.files[0];
            
            // Check file type
            if (!allowedTypes.includes(file.type)) {
                errors.push('Format video tidak didukung. Gunakan MP4, WebM, atau OGG.');
            }
            
            // Check file size
            if (file.size > maxSize) {
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                errors.push(`Ukuran file (${sizeMB} MB) melebihi batas maksimal 50 MB.`);
            }
        }
        
        // If there are errors, show error modal instead of confirmation modal
        if (errors.length > 0) {
            e.preventDefault();
            e.stopPropagation();
            
            const errorList = document.getElementById('validationErrorList');
            errorList.innerHTML = errors.map(err => `<li>${err}</li>`).join('');
            
            const errorModal = new bootstrap.Modal(document.getElementById('validationErrorModal'));
            errorModal.show();
            
            return false;
        }
    });
    
    // Show file info when selected
    videoInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            const file = this.files[0];
            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            
            // Check if valid
            let status = '';
            if (!allowedTypes.includes(file.type)) {
                status = '<span class="text-danger"><i class="fas fa-times-circle"></i> Format tidak didukung</span>';
            } else if (file.size > maxSize) {
                status = `<span class="text-danger"><i class="fas fa-times-circle"></i> Ukuran terlalu besar (${sizeMB} MB)</span>`;
            } else {
                status = `<span class="text-success"><i class="fas fa-check-circle"></i> ${file.name} (${sizeMB} MB)</span>`;
            }
            
            // Update the help text
            const helpText = this.parentElement.querySelector('.form-text');
            if (helpText) {
                helpText.innerHTML = `Format: MP4, WebM, OGG. Max: 50MB. <br>${status}`;
            }
        }
    });
});
</script>
@endsection

