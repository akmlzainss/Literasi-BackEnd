@extends('layouts.siswa')

@section('title', 'Tulis Artikel Baru - SiPena')

@section('body_class', 'upload-page')

@section('additional_css')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
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

    /* Form Container */
    .upload-container {
        max-width: 1200px;
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

    /* Editor Container */
    .editor-container {
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
    }

    .editor-container:focus-within {
        border-color: #0073E6;
        box-shadow: 0 0 0 4px rgba(0, 115, 230, 0.1);
    }

    /* Quill Editor Styles */
    #quill-editor {
        height: 400px;
        font-size: 1rem;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .ql-toolbar.ql-snow {
        border: none;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
        padding: 12px;
    }

    .ql-container.ql-snow {
        border: none;
        font-size: 1rem;
    }

    .ql-editor {
        padding: 1.25rem;
        line-height: 1.7;
    }

    .ql-editor.ql-blank::before {
        color: #94a3b8;
        font-style: normal;
    }

    /* Sidebar Settings Card */
    .settings-card {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid #e2e8f0;
        position: sticky;
        top: 100px;
    }

    .settings-card-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .settings-card-header .icon-wrapper {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #0073E6 0%, #0284c7 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
    }

    .settings-card-header h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    /* Image Upload Zone */
    .upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: center;
        background: white;
        transition: all 0.3s ease;
        cursor: pointer;
        margin-bottom: 1.5rem;
    }

    .upload-zone:hover {
        border-color: #0073E6;
        background: rgba(0, 115, 230, 0.03);
    }

    .upload-zone.dragover {
        border-color: #0073E6;
        background: rgba(0, 115, 230, 0.08);
        transform: scale(1.02);
    }

    .upload-zone-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .upload-zone-icon i {
        font-size: 1.5rem;
        color: #0073E6;
    }

    .upload-zone h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
    }

    .upload-zone p {
        font-size: 0.875rem;
        color: #64748b;
        margin: 0;
    }

    .upload-zone input[type="file"] {
        display: none;
    }

    .image-preview {
        display: none;
        margin-top: 1rem;
    }

    .image-preview img {
        max-width: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .image-preview.has-image {
        display: block;
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

    /* Submit Button */
    .btn-submit-article {
        width: 100%;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 14px;
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
    }

    .btn-submit-article::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-submit-article:hover::before {
        left: 100%;
    }

    .btn-submit-article:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 115, 230, 0.4);
    }

    /* Tips Section */
    .tips-box {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 16px;
        padding: 1.25rem;
        margin-top: 1.5rem;
        border: 1px solid #fcd34d;
    }

    .tips-box-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .tips-box-header i {
        color: #d97706;
        font-size: 1.1rem;
    }

    .tips-box-header h5 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #92400e;
        margin: 0;
    }

    .tips-box ul {
        margin: 0;
        padding-left: 1.25rem;
    }

    .tips-box li {
        font-size: 0.85rem;
        color: #78350f;
        margin-bottom: 0.35rem;
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

    /* Word Count */
    .word-count {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem 1rem;
        background: #f1f5f9;
        border-radius: 10px;
        margin-top: 0.75rem;
    }

    .word-count-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.85rem;
        color: #64748b;
    }

    .word-count-item i {
        color: #3b82f6;
    }

    .word-count-item span {
        font-weight: 600;
        color: #1e293b;
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
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        padding: 1.25rem 2rem;
        background: #f8fafc;
    }

    /* Alert Custom */
    .alert-custom {
        border-radius: 14px;
        border: none;
        padding: 1rem 1.25rem;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .settings-card {
            position: relative;
            top: 0;
            margin-top: 2rem;
        }

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

        .form-section-title {
            flex-wrap: wrap;
        }

        .form-section-title .icon-wrapper {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }

        .form-section-title h3 {
            font-size: 1.1rem;
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

        .settings-card {
            padding: 1.25rem;
            border-radius: 16px;
        }

        .settings-card-header .icon-wrapper {
            width: 40px;
            height: 40px;
        }

        .settings-card-header h4 {
            font-size: 1.1rem;
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

        .upload-zone {
            padding: 1.5rem 1rem;
            border-radius: 12px;
        }

        .upload-zone-icon {
            width: 50px;
            height: 50px;
        }

        .upload-zone-icon i {
            font-size: 1.25rem;
        }

        .upload-zone h5 {
            font-size: 0.95rem;
        }

        .upload-zone p {
            font-size: 0.8rem;
        }

        .btn-submit-article {
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
            border-radius: 12px;
        }

        .tips-box {
            padding: 1rem;
            border-radius: 12px;
        }

        .tips-box-header h5 {
            font-size: 0.9rem;
        }

        .tips-box ul {
            font-size: 0.8rem;
        }

        .tips-box li {
            margin-bottom: 0.25rem;
        }

        .word-count {
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
        }

        .word-count-item {
            font-size: 0.8rem;
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
                    <i class="fas fa-pencil-alt fa-3x"></i>
                </div>
                <h1 class="hero-title">Tulis Artikel Baru</h1>
                <p class="hero-subtitle">Wujudkan ide kreatifmu dalam bentuk tulisan yang menginspirasi</p>
            </div>
        </div>
        <div class="hero-wave"></div>
    </div>

    <!-- Form Container -->
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

        <form id="artikelForm" action="{{ route('artikel-siswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="form-main-card">
                        <div class="form-main-content">
                            <!-- Judul Section -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <div class="icon-wrapper">
                                        <i class="fas fa-heading"></i>
                                    </div>
                                    <h3>Judul Artikel</h3>
                                </div>
                                <div class="form-floating-custom">
                                    <label for="judul">
                                        Judul yang Menarik <span class="required-star">*</span>
                                    </label>
                                    <input type="text" name="judul" id="judul" 
                                        class="form-control form-control-lg" 
                                        value="{{ old('judul') }}" 
                                        placeholder="Masukkan judul artikel yang menarik perhatian..."
                                        required>
                                </div>
                            </div>

                            <!-- Konten Section -->
                            <div class="form-section">
                                <div class="form-section-title">
                                    <div class="icon-wrapper">
                                        <i class="fas fa-align-left"></i>
                                    </div>
                                    <h3>Isi Artikel</h3>
                                </div>
                                <div class="form-floating-custom">
                                    <label>
                                        Tulis Kontenmu <span class="required-star">*</span>
                                    </label>
                                    <div class="editor-container">
                                        <div id="quill-editor">{!! old('isi') !!}</div>
                                        <input type="hidden" name="isi" id="isi_artikel">
                                    </div>
                                    <div class="word-count">
                                        <div class="word-count-item">
                                            <i class="fas fa-font"></i>
                                            <span id="charCount">0</span> karakter
                                        </div>
                                        <div class="word-count-item">
                                            <i class="fas fa-file-word"></i>
                                            <span id="wordCount">0</span> kata
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Settings -->
                <div class="col-lg-4">
                    <div class="settings-card">
                        <div class="settings-card-header">
                            <div class="icon-wrapper">
                                <i class="fas fa-cog"></i>
                            </div>
                            <h4>Pengaturan</h4>
                        </div>

                        <!-- Image Upload -->
                        <div class="form-floating-custom">
                            <label>
                                <i class="fas fa-image text-primary"></i>
                                Gambar Sampul (Opsional)
                            </label>
                            <div class="upload-zone" id="uploadZone" onclick="document.getElementById('gambar').click()">
                                <div class="upload-zone-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <h5>Klik untuk upload</h5>
                                <p>atau drag & drop gambar di sini</p>
                                <input type="file" name="gambar" id="gambar" accept="image/*">
                            </div>
                            <div class="image-preview" id="imagePreview">
                                <img id="previewImg" src="" alt="Preview">
                            </div>
                        </div>

                        <!-- Jenis Tulisan -->
                        <div class="form-floating-custom">
                            <label for="jenis">
                                <i class="fas fa-book text-success"></i>
                                Jenis Tulisan
                            </label>
                            <div class="select-styled">
                                <select name="jenis" id="jenis" class="form-select" required>
                                    <option value="bebas" selected>📝 Tulisan Bebas</option>
                                    <option value="resensi_buku">📚 Resensi Buku</option>
                                    <option value="resensi_film">🎬 Resensi Film</option>
                                </select>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div class="form-floating-custom">
                            <label for="id_kategori">
                                <i class="fas fa-tags text-warning"></i>
                                Pilih Kategori
                            </label>
                            <div class="select-styled">
                                <select name="id_kategori" id="id_kategori" class="form-select">
                                    <option value="">Pilih kategori...</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Usulan Kategori -->
                        <div class="form-floating-custom">
                            <label for="usulan_kategori">
                                <i class="fas fa-plus-circle text-info"></i>
                                Atau Usulkan Kategori Baru
                            </label>
                            <input type="text" name="usulan_kategori" id="usulan_kategori" 
                                class="form-control" 
                                placeholder="Contoh: Teknologi"
                                value="{{ old('usulan_kategori') }}">
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Isi salah satu saja
                            </small>
                        </div>

                        <!-- Submit Button -->
                        <button type="button" class="btn-submit-article" data-bs-toggle="modal" data-bs-target="#confirmModal">
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim untuk Review</span>
                        </button>

                        <!-- Tips -->
                        <div class="tips-box">
                            <div class="tips-box-header">
                                <i class="fas fa-lightbulb"></i>
                                <h5>Tips Menulis</h5>
                            </div>
                            <ul>
                                <li>Gunakan judul yang menarik perhatian</li>
                                <li>Minimal 100 karakter untuk isi artikel</li>
                                <li>Tambahkan gambar untuk engagement yang lebih baik</li>
                                <li>Periksa kembali sebelum mengirim</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="confirmModalLabel">
                        <i class="fas fa-check-circle me-2"></i>Konfirmasi Pengiriman
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-4">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #0073E6, #0284c7); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fas fa-paper-plane fa-2x text-white"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Kirim Artikel untuk Review?</h5>
                    <p class="text-muted mb-0">
                        Setelah dikirim, artikel akan masuk ke proses review dan tidak dapat diedit sampai proses selesai.
                    </p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold" form="artikelForm">
                        <i class="fas fa-check me-2"></i>Ya, Kirim Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
        $(document).ready(function() {
            // Quill Editor Init
            var quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Tulis isi artikel kamu di sini...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['blockquote', 'code-block'],
                        ['link'],
                        ['clean']
                    ]
                }
            });

            // Sync Quill content to hidden input
            quill.on('text-change', function() {
                var html = quill.root.innerHTML;
                $('#isi_artikel').val(html);
                updateWordCount();
            });

            // Initial sync if there's old content
            if (quill.getText().trim().length > 0) {
                $('#isi_artikel').val(quill.root.innerHTML);
                updateWordCount();
            }

            // Word Count
            function updateWordCount() {
                const content = quill.getText().trim();
                const charCount = content.length;
                const wordCount = content ? content.split(/\s+/).filter(word => word.length > 0).length : 0;
                $('#charCount').text(charCount);
                $('#wordCount').text(wordCount);
            }

            // Image Preview
            $('#gambar').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImg').attr('src', e.target.result);
                        $('#imagePreview').addClass('has-image');
                        $('#uploadZone').hide();
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Drag and Drop
            const uploadZone = document.getElementById('uploadZone');
            
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
                    document.getElementById('gambar').files = files;
                    $('#gambar').trigger('change');
                }
            });

            // Form Validation
            $('[data-bs-target="#confirmModal"]').on('click', function(e) {
                // Sync Quill content before validation
                $('#isi_artikel').val(quill.root.innerHTML);
                
                let isValid = true;
                let errors = [];
                
                const judul = $('#judul').val().trim();
                if (!judul) {
                    errors.push('Judul artikel wajib diisi.');
                    $('#judul').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#judul').removeClass('is-invalid');
                }
                
                const isiText = quill.getText().trim();
                if (!isiText || isiText.length < 100) {
                    errors.push('Isi artikel minimal 100 karakter. Saat ini: ' + isiText.length + ' karakter.');
                    isValid = false;
                }
                
                const kategori = $('#id_kategori').val();
                const usulanKategori = $('#usulan_kategori').val().trim();
                if (!kategori && !usulanKategori) {
                    errors.push('Pilih kategori atau usulkan kategori baru.');
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    let errorHtml = '<div class="alert alert-danger alert-custom" id="validationErrors">' +
                        '<div class="d-flex align-items-start gap-3">' +
                        '<i class="fas fa-exclamation-circle fs-4"></i>' +
                        '<div><h6 class="mb-2 fw-bold">Harap perbaiki kesalahan berikut:</h6><ul class="mb-0 ps-3">';
                    errors.forEach(function(err) {
                        errorHtml += '<li>' + err + '</li>';
                    });
                    errorHtml += '</ul></div></div></div>';
                    
                    $('#validationErrors').remove();
                    $('.upload-container').prepend(errorHtml);
                    
                    $('html, body').animate({
                        scrollTop: $('.upload-container').offset().top - 100
                    }, 300);
                    
                    return false;
                }
                
                $('#validationErrors').remove();
            });

            // Sync before form submit
            $('form').on('submit', function() {
                $('#isi_artikel').val(quill.root.innerHTML);
            });
        });
    </script>
@endsection
