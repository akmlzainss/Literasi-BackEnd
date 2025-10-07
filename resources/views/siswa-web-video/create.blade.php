@extends('layouts.layouts')

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
                            <input type="text" name="judul" id="judul" class="form-control form-control-lg" value="{{ old('judul') }}" required>
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
                            <input type="file" name="video" id="video" class="form-control" required accept="video/mp4,video/webm,video/ogg">
                            <small class="form-text text-muted">Format yang didukung: MP4, WebM, OGG. Maksimal ukuran: 50MB.</small>
                        </div>
                        <div class="d-grid mt-4">
                            <!-- Tombol ini TIDAK langsung submit -->
                            <button type="button" class="btn btn-primary fw-bold btn-lg" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">
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
                    <small class="text-muted">Setelah dikirim, video tidak dapat diedit sampai proses review selesai.</small>
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
@endsection
