@extends('layouts.siswa')

@section('title', 'Upload Video Baru - SIPENA')
@section('body_class', 'upload-page')

@section('additional_css')
<style>
    .upload-page {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
    }

    /* Upload Page uses hero-banner from websiswa.css */
    /* Additional styling for back button */
    .hero-banner .btn-back {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .hero-banner .btn-back:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.05);
        color: white;
    }
    
    .hero-banner .btn-back i {
        font-size: 1rem;
    }
    
    @media (max-width: 768px) {
        .hero-banner .btn-back {
            width: 40px;
            height: 40px;
            top: 1rem;
            left: 1rem;
        }
        
        .hero-banner .btn-back i {
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 576px) {
        .hero-banner .btn-back {
            width: 36px;
            height: 36px;
        }
        
        .hero-banner .btn-back i {
            font-size: 0.85rem;
        }
    }

    /* Upload Container */
    .upload-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1.5rem;
        margin-top: -60px;
        position: relative;
        z-index: 10;
    }

    /* Main Form Card */
    .form-main-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .form-main-content {
        padding: 2.5rem;
    }

    /* Form Sections */
    .form-section {
        margin-bottom: 2rem;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .form-section-title .icon-wrapper {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #0073E6 0%, #0284c7 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }

    .form-section-title h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    /* Enhanced Form Controls */
    .form-floating-custom {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-floating-custom .form-control,
    .form-floating-custom .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #f8fafc;
    }

    .form-floating-custom .form-control:focus,
    .form-floating-custom .form-select:focus {
        border-color: #0073E6;
        background: white;
        box-shadow: 0 0 0 4px rgba(0, 115, 230, 0.1);
        transform: translateY(-2px);
    }

    .form-floating-custom .form-control-lg {
        padding: 1.25rem 1.5rem;
        font-size: 1.15rem;
        font-weight: 600;
    }

    .form-floating-custom label {
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-floating-custom label .required-star {
        color: #ef4444;
        font-weight: bold;
    }

    /* Video Upload Zone */
    .video-upload-zone {
        border: 3px dashed #cbd5e1;
        border-radius: 20px;
        padding: 3rem 2rem;
        text-align: center;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .video-upload-zone::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 115, 230, 0.05) 0%, rgba(2, 132, 199, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .video-upload-zone:hover::before,
    .video-upload-zone.dragover::before {
        opacity: 1;
    }

    .video-upload-zone:hover {
        border-color: #0073E6;
        transform: translateY(-2px);
    }

    .video-upload-zone.dragover {
        border-color: #0073E6;
        border-style: solid;
        transform: scale(1.02);
    }

    .upload-zone-animation {
        position: relative;
        z-index: 1;
    }

    .upload-icon-container {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #0073E6 0%, #0284c7 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        animation: pulse-glow 2s ease-in-out infinite;
        box-shadow: 0 10px 30px rgba(0, 115, 230, 0.3);
    }

    @keyframes pulse-glow {
        0%, 100% { 
            transform: scale(1);
            box-shadow: 0 10px 30px rgba(0, 115, 230, 0.3);
        }
        50% { 
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 115, 230, 0.5);
        }
    }

    .upload-icon-container i {
        font-size: 2.5rem;
        color: white;
    }

    .video-upload-zone h4 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .video-upload-zone p {
        color: #64748b;
        margin-bottom: 1rem;
    }

    .upload-formats {
        display: flex;
        justify-content: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .format-badge {
        padding: 0.4rem 0.75rem;
        background: white;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .format-badge i {
        margin-right: 0.3rem;
        color: #0073E6;
    }

    .video-upload-zone input[type="file"] {
        display: none;
    }

    /* Video Preview */
    .video-preview {
        display: none;
        margin-top: 1.5rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 16px;
        border: 1px solid #e2e8f0;
    }

    .video-preview.has-video {
        display: block;
    }

    .video-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .video-info-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #0073E6 0%, #0284c7 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .video-info-icon i {
        font-size: 1.5rem;
        color: white;
    }

    .video-info-details h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
        word-break: break-all;
    }

    .video-info-details p {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0;
    }

    .video-info-status {
        margin-left: auto;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .status-badge.success {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .status-badge.error {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    /* Button Submit */
    .btn-submit-video {
        width: 100%;
        padding: 1.25rem 2rem;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 16px;
        background: linear-gradient(135deg, #0073E6 0%, #0284c7 100%);
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        margin-top: 2rem;
    }

    .btn-submit-video::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-submit-video:hover::before {
        left: 100%;
    }

    .btn-submit-video:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 115, 230, 0.4);
    }

    /* Back Button */
    .btn-back {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        color: white;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        z-index: 5;
    }

    .btn-back:hover {
        background: rgba(255,255,255,0.35);
        color: white;
        transform: translateX(-3px);
    }

    /* Header Content Layout */
    .header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 3.5rem;
        padding-left: 0;
    }

    .header-text {
        flex: 1;
        padding-right: 1rem;
    }

    .header-text h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .header-text h1 i {
        margin-right: 0.5rem;
    }

    .header-text p {
        color: rgba(255,255,255,0.9);
        font-size: 1.05rem;
        margin-bottom: 0;
    }

    /* Tips Box */
    .tips-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 2rem;
        border: 1px solid #fcd34d;
    }

    .tips-box-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .tips-box-header i {
        color: #d97706;
        font-size: 1.25rem;
    }

    .tips-box-header h5 {
        font-size: 1rem;
        font-weight: 700;
        color: #92400e;
        margin: 0;
    }

    .tips-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }

    .tip-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #78350f;
    }

    .tip-item i {
        color: #d97706;
        font-size: 0.8rem;
    }

    /* Alert Custom */
    .alert-custom {
        border-radius: 14px;
        border: none;
        padding: 1rem 1.25rem;
    }

    /* Modal Enhanced */
    .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, #0073E6 0%, #0284c7 100%);
        padding: 1.5rem;
    }

    .modal-header .modal-title {
        font-weight: 700;
        color: white;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        padding: 1.25rem 2rem;
        background: #f8fafc;
    }

    /* Select Styled */
    .select-styled {
        position: relative;
    }

    .select-styled .form-select {
        padding-right: 3rem;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .page-header-upload {
            padding: 2.5rem 0 4rem;
        }

        .page-header-upload::after {
            bottom: -30px;
            height: 60px;
        }

        .header-content h1 {
            font-size: 1.8rem;
        }

        .header-content p {
            font-size: 1rem;
        }

        .upload-container {
            margin-top: -30px;
        }
    }

    @media (max-width: 768px) {
        .page-header-upload {
            padding: 2rem 0 3.5rem;
        }

        .page-header-upload::after {
            bottom: -20px;
            height: 50px;
        }

        .header-text h1 {
            font-size: 1.5rem;
            line-height: 1.3;
        }

        .header-text h1 i {
            display: inline;
            font-size: 1.2rem;
        }

        .header-text p {
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .btn-back {
            top: 1rem;
            left: 1rem;
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
        }

        .header-icon i {
            font-size: 1.8rem;
        }

        .header-content {
            padding-top: 3rem;
        }

        .upload-container {
            margin-top: -20px;
            padding: 0 1rem;
        }

        .form-main-content {
            padding: 1.5rem;
        }

        .form-section-title .icon-wrapper {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }

        .form-section-title h3 {
            font-size: 1.1rem;
        }

        .video-upload-zone {
            padding: 2rem 1.5rem;
        }

        .upload-icon-container {
            width: 80px;
            height: 80px;
        }

        .upload-icon-container i {
            font-size: 2rem;
        }

        .video-upload-zone h4 {
            font-size: 1.2rem;
        }

        .tips-grid {
            grid-template-columns: 1fr;
        }

        .video-info {
            flex-direction: column;
            text-align: center;
        }

        .video-info-status {
            margin-left: 0;
            margin-top: 1rem;
        }
    }

    @media (max-width: 576px) {
        .page-header-upload {
            padding: 1.5rem 0 3rem;
        }

        .page-header-upload::before {
            display: none;
        }

        .page-header-upload::after {
            bottom: -15px;
            height: 40px;
        }

        .header-text {
            text-align: left;
        }

        .header-text h1 {
            font-size: 1.15rem;
        }

        .header-text h1 i {
            font-size: 0.95rem;
        }

        .header-text p {
            font-size: 0.8rem;
            padding: 0;
        }

        .btn-back {
            top: 0.75rem;
            left: 0.75rem;
            width: 36px;
            height: 36px;
            font-size: 0.85rem;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
        }

        .header-icon i {
            font-size: 1.5rem;
        }

        .header-content {
            padding-top: 2.5rem;
            gap: 0.75rem;
        }

        .upload-container {
            padding: 0 0.75rem;
            margin-top: -15px;
        }

        .form-main-card {
            border-radius: 16px;
        }

        .form-main-content {
            padding: 1.25rem;
        }

        .form-floating-custom label {
            font-size: 0.9rem;
        }

        .form-floating-custom .form-control,
        .form-floating-custom .form-select {
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            border-radius: 12px;
        }

        .form-floating-custom .form-control-lg {
            padding: 1rem 1.25rem;
            font-size: 1rem;
        }

        .video-upload-zone {
            padding: 1.5rem 1rem;
            border-radius: 16px;
        }

        .upload-icon-container {
            width: 70px;
            height: 70px;
        }

        .upload-icon-container i {
            font-size: 1.75rem;
        }

        .video-upload-zone h4 {
            font-size: 1.1rem;
        }

        .video-upload-zone p {
            font-size: 0.85rem;
        }

        .upload-formats {
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .format-badge {
            font-size: 0.75rem;
        }

        .video-preview {
            padding: 1rem;
            border-radius: 12px;
        }

        .video-info-icon {
            width: 50px;
            height: 50px;
        }

        .video-info-icon i {
            font-size: 1.25rem;
        }

        .video-info-details h5 {
            font-size: 0.9rem;
        }

        .video-info-details p {
            font-size: 0.8rem;
        }

        .btn-submit-video {
            padding: 1rem 1.5rem;
            font-size: 1rem;
            border-radius: 14px;
        }

        .tips-box {
            padding: 1rem;
            border-radius: 12px;
        }

        .tips-box-header h5 {
            font-size: 0.9rem;
        }

        .tip-item {
            font-size: 0.8rem;
        }

        .tip-item i {
            font-size: 0.75rem;
        }

        .header-icon {
            display: none;
        }

        /* Modal responsive */
        .modal-content {
            margin: 0.5rem;
            border-radius: 16px;
        }

        .modal-header {
            padding: 1rem 1.25rem;
        }

        .modal-body {
            padding: 1.5rem 1.25rem;
        }

        .modal-footer {
            padding: 1rem 1.25rem;
            flex-direction: column;
            gap: 0.5rem;
        }

        .modal-footer .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
    <!-- Hero Banner - Same as artikel/video index -->
    <div class="hero-banner">
        <div class="container">
            <!-- Back button -->
            <a href="{{ route('artikel-siswa.upload') }}" class="btn-back" title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>
            
            <div class="hero-content text-center text-white">
                <div class="hero-icon mb-3">
                    <i class="fas fa-video fa-3x"></i>
                </div>
                <h1 class="hero-title">Upload Video Baru</h1>
                <p class="hero-subtitle">Bagikan kreativitasmu melalui konten video yang menarik</p>
            </div>
        </div>
        <div class="hero-wave"></div>
    </div>

    <!-- Upload Container -->
    <div class="upload-container pb-5">
        @if ($errors->any())
            <div class="alert alert-danger alert-custom mb-4">
                <div class="d-flex align-items-start gap-3">
                    <i class="fas fa-exclamation-circle fs-4"></i>
                    <div>
                        <h6 class="mb-2 fw-bold">Terjadi Kesalahan</h6>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-main-card">
            <div class="form-main-content">
                <form id="videoForm" action="{{ route('video.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Video Upload Section -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <div class="icon-wrapper">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <h3>Upload Video</h3>
                        </div>

                        <div class="video-upload-zone" id="videoUploadZone" onclick="document.getElementById('video').click()">
                            <div class="upload-zone-animation">
                                <div class="upload-icon-container">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <h4>Klik atau Drag & Drop Video</h4>
                                <p>Pilih file video dari perangkat Anda</p>
                                <div class="upload-formats">
                                    <span class="format-badge"><i class="fas fa-check"></i>MP4</span>
                                    <span class="format-badge"><i class="fas fa-check"></i>WebM</span>
                                    <span class="format-badge"><i class="fas fa-check"></i>OGG</span>
                                    <span class="format-badge"><i class="fas fa-hdd"></i>Max 50MB</span>
                                </div>
                            </div>
                            <input type="file" name="video" id="video" accept="video/mp4,video/webm,video/ogg" required>
                        </div>

                        <div class="video-preview" id="videoPreview">
                            <div class="video-info">
                                <div class="video-info-icon">
                                    <i class="fas fa-video"></i>
                                </div>
                                <div class="video-info-details">
                                    <h5 id="videoFileName">filename.mp4</h5>
                                    <p id="videoFileSize">0 MB</p>
                                </div>
                                <div class="video-info-status">
                                    <span class="status-badge success" id="videoStatusBadge">
                                        <i class="fas fa-check-circle"></i> Siap diupload
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Video Details Section -->
                    <div class="form-section">
                        <div class="form-section-title">
                            <div class="icon-wrapper">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h3>Detail Video</h3>
                        </div>

                        <div class="form-floating-custom">
                            <label for="judul">
                                <i class="fas fa-heading text-primary me-1"></i>
                                Judul Video <span class="required-star">*</span>
                            </label>
                            <input type="text" name="judul" id="judul" 
                                class="form-control form-control-lg" 
                                value="{{ old('judul') }}" 
                                placeholder="Masukkan judul video yang menarik..."
                                required>
                        </div>

                        <div class="form-floating-custom">
                            <label for="deskripsi">
                                <i class="fas fa-align-left text-success me-1"></i>
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" id="deskripsi" 
                                class="form-control" 
                                rows="4" 
                                placeholder="Jelaskan tentang video Anda...">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="form-floating-custom">
                            <label for="id_kategori">
                                <i class="fas fa-tags text-warning me-1"></i>
                                Kategori (Opsional)
                            </label>
                            <div class="select-styled">
                                <select name="id_kategori" id="id_kategori" class="form-select">
                                    <option value="">Pilih Kategori...</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="button" class="btn-submit-video" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">
                        <i class="fas fa-upload"></i>
                        <span>Upload Video</span>
                    </button>
                </form>

                <!-- Tips Box -->
                <div class="tips-box">
                    <div class="tips-box-header">
                        <i class="fas fa-lightbulb"></i>
                        <h5>Tips Upload Video</h5>
                    </div>
                    <div class="tips-grid">
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Gunakan format MP4 untuk kompatibilitas terbaik</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Resolusi minimal 720p untuk kualitas yang baik</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Judul yang menarik meningkatkan views</span>
                        </div>
                        <div class="tip-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Deskripsi membantu orang menemukan video Anda</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="konfirmasiModalLabel">
                        <i class="fas fa-upload me-2"></i>Konfirmasi Upload
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-4">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #0073E6, #0284c7); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fas fa-video fa-2x text-white"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Upload Video untuk Review?</h5>
                    <p class="text-muted mb-0">
                        Video akan dikirim untuk direview. Setelah disetujui, video akan tampil di halaman utama.
                    </p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold" form="videoForm" style="background: linear-gradient(135deg, #0073E6, #0284c7); border: none;">
                        <i class="fas fa-upload me-2"></i>Ya, Upload Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Validation Error Modal -->
    <div class="modal fade" id="validationErrorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-exclamation-triangle me-2"></i>Validasi Gagal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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
    const uploadZone = document.getElementById('videoUploadZone');
    const videoPreview = document.getElementById('videoPreview');
    
    // Allowed video types
    const allowedTypes = ['video/mp4', 'video/webm', 'video/ogg'];
    const maxSize = 50 * 1024 * 1024; // 50 MB in bytes
    
    // Drag and Drop Events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadZone.addEventListener(eventName, () => uploadZone.classList.add('dragover'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, () => uploadZone.classList.remove('dragover'), false);
    });

    uploadZone.addEventListener('drop', function(e) {
        const files = e.dataTransfer.files;
        if (files.length) {
            videoInput.files = files;
            handleVideoSelect(files[0]);
        }
    });

    // Video Selection Handler
    videoInput.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            handleVideoSelect(this.files[0]);
        }
    });

    function handleVideoSelect(file) {
        const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
        
        document.getElementById('videoFileName').textContent = file.name;
        document.getElementById('videoFileSize').textContent = sizeMB + ' MB';
        
        const statusBadge = document.getElementById('videoStatusBadge');
        
        if (!allowedTypes.includes(file.type)) {
            statusBadge.className = 'status-badge error';
            statusBadge.innerHTML = '<i class="fas fa-times-circle"></i> Format tidak didukung';
        } else if (file.size > maxSize) {
            statusBadge.className = 'status-badge error';
            statusBadge.innerHTML = '<i class="fas fa-times-circle"></i> Ukuran terlalu besar';
        } else {
            statusBadge.className = 'status-badge success';
            statusBadge.innerHTML = '<i class="fas fa-check-circle"></i> Siap diupload';
        }
        
        videoPreview.classList.add('has-video');
        uploadZone.style.display = 'none';
    }
    
    // Validation before showing modal
    uploadBtn.addEventListener('click', function(e) {
        const errors = [];
        
        if (!judulInput.value.trim()) {
            errors.push('Judul video wajib diisi.');
        }
        
        if (!videoInput.files || videoInput.files.length === 0) {
            errors.push('File video wajib dipilih.');
        } else {
            const file = videoInput.files[0];
            
            if (!allowedTypes.includes(file.type)) {
                errors.push('Format video tidak didukung. Gunakan MP4, WebM, atau OGG.');
            }
            
            if (file.size > maxSize) {
                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                errors.push(`Ukuran file (${sizeMB} MB) melebihi batas maksimal 50 MB.`);
            }
        }
        
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
});
</script>
@endsection
