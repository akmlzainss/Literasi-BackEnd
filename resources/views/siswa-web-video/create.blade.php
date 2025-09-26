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

        <form action="{{ route('video.store') }}" method="POST" enctype="multipart/form-data">
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
                            <button type="submit" class="btn btn-primary fw-bold btn-lg">Upload Video</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection
```

### 6. Perbarui Navigasi dan Halaman Pilihan Upload

**`layouts/layouts.blade.php`:**
Tambahkan link "Video" di navbar.

```php
<ul class="navbar-nav ms-auto align-items-lg-center">
    <li class="nav-item">
        <a href="{{ route('dashboard-siswa') }}" class="nav-link ...">Beranda</a>
    </li>
    <li class="nav-item">
        <a class="nav-link ..." href="{{ route('artikel-siswa.index') }}">Artikel</a>
    </li>
    <!-- TAMBAHKAN INI -->
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('video.index') ? 'active' : '' }}" href="{{ route('video.index') }}">
            <i class="fas fa-play-circle me-1 d-lg-none"></i>Video
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('artikel-siswa.upload') }}" class="nav-link ...">Upload</a>
    </li>
    ...
</ul>
```

**`upload-choice.blade.php`:**
Aktifkan kartu upload video.

```php
<!-- Ganti bagian Video Card (Coming Soon) -->
<div class="col-md-6 col-lg-5">
    <div class="choice-card animate-ready">
        <div class="card-body text-center">
            <div class="choice-icon mb-4">
                <i class="fas fa-video fa-4x text-primary"></i>
                <div class="icon-glow"></div>
            </div>
            <h4 class="card-title fw-bold mb-3">Upload Video Baru</h4>
            <p class="card-text text-muted mb-4">
                Punya karya dalam bentuk video? Bagikan di sini dan tunjukkan kreativitasmu kepada semua orang!
            </p>
            <div class="choice-features mb-4">
                <div class="feature-item">
                    <i class="fas fa-check-circle text-success me-2"></i><span>Video HD</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle text-success me-2"></i><span>Komentar & Suka</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle text-success me-2"></i><span>Mode Scroll</span>
                </div>
            </div>
            <a href="{{ route('video.create') }}" class="btn btn-primary btn-lg w-100 fw-bold stretched-link">
                <i class="fas fa-video me-2"></i>Mulai Upload
            </a>
        </div>
    </div>
</div>
