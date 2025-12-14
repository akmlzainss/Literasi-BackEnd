@extends('layouts.siswa')

@section('title', 'Upload Karya - SIPENA')

@section('body_class', 'upload-choice-page')

@section('content')
    <div class="container py-5">
        <!-- Page Header with Animation -->
        <div class="page-header text-center mb-5">
            <div class="header-icon mb-4">
                <i class="fas fa-cloud-upload-alt fa-4x text-primary"></i>
            </div>
            <h1 class="display-5 fw-bold mb-3 animate-ready">Mulai Berbagi Karyamu!</h1>
            <p class="lead text-muted mb-4 animate-ready">
                Pilih jenis konten yang ingin kamu buat dan bagikan kepada teman-temanmu di SIPENA.
            </p>
            <div class="header-decoration">
                <div class="decoration-line"></div>
                <i class="fas fa-star decoration-icon"></i>
                <div class="decoration-line"></div>
            </div>
        </div>

        <!-- Choice Cards -->
        <div class="row g-4 justify-content-center">
            <!-- Artikel Card -->
            <div class="col-md-6 col-lg-5">
                <div class="choice-card animate-ready">
                    <div class="card-body text-center">
                        <div class="choice-icon mb-4">
                            <i class="fas fa-pencil-alt fa-4x text-primary"></i>
                            <div class="icon-glow"></div>
                        </div>
                        <h4 class="card-title fw-bold mb-3">Tulis Artikel Baru</h4>
                        <p class="card-text text-muted mb-4">
                            Bagikan cerita inspiratif, ulasan buku/film, atau tulisan bebas lainnya.
                            Wujudkan ide kreatifmu dalam bentuk artikel yang menarik.
                            <br><small class="text-info">Kamu sudah menulis {{ $userArticles }} artikel!</small>
                        </p>
                        <div class="choice-features mb-4">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Editor WYSIWYG</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Upload Gambar</span>
                            </div>
                        </div>
                        <a href="{{ route('artikel-siswa.create') }}"
                            class="btn btn-primary btn-lg w-100 fw-bold stretched-link">
                            <i class="fas fa-pen-fancy me-2"></i>Mulai Menulis
                        </a>
                    </div>
                </div>
            </div>

            <!-- Video Card -->
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
                            <br><small class="text-info">Kamu sudah mengunggah {{ $userVideos }} video!</small>
                        </p>
                        <div class="choice-features mb-4">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i><span>Video HD</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i><span>Komentar & Suka</span>
                            </div>
                        </div>
                        <a href="{{ route('video.create') }}" class="btn btn-primary btn-lg w-100 fw-bold stretched-link">
                            <i class="fas fa-video me-2"></i>Mulai Upload
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="stats-section mt-5">
                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="stat-card animate-ready">
                            <div class="stat-icon">
                                <i class="fas fa-users text-primary"></i>
                            </div>
                            <div class="stat-number">{{ $activeWriters }}</div>
                            <div class="stat-label">Penulis Aktif</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card animate-ready">
                            <div class="stat-icon">
                                <i class="fas fa-newspaper text-success"></i>
                            </div>
                            <div class="stat-number">{{ $publishedArticles }}</div>
                            <div class="stat-label">Artikel Published</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card animate-ready">
                            <div class="stat-icon">
                                <i class="fas fa-video text-success"></i>
                            </div>
                            <div class="stat-number">{{ $publishedVideos }}</div>
                            <div class="stat-label">Video Published</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips Section -->
            <div class="tips-section mt-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="tips-card animate-ready">
                            <div class="tips-header text-center mb-4">
                                <i class="fas fa-lightbulb fa-2x text-warning mb-3"></i>
                                <h3 class="fw-bold">Tips Menulis Artikel yang Menarik</h3>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="tip-item">
                                        <div class="tip-number">1</div>
                                        <div class="tip-content">
                                            <h6 class="fw-semibold">Judul yang Menarik</h6>
                                            <p class="small text-muted mb-0">Buat judul yang membuat pembaca penasaran</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="tip-item">
                                        <div class="tip-number">2</div>
                                        <div class="tip-content">
                                            <h6 class="fw-semibold">Paragraf Pembuka</h6>
                                            <p class="small text-muted mb-0">Mulai dengan hook yang kuat</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="tip-item">
                                        <div class="tip-number">3</div>
                                        <div class="tip-content">
                                            <h6 class="fw-semibold">Gunakan Gambar</h6>
                                            <p class="small text-muted mb-0">Visual yang menarik meningkatkan engagement</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="tip-item">
                                        <div class="tip-number">4</div>
                                        <div class="tip-content">
                                            <h6 class="fw-semibold">Proofreading</h6>
                                            <p class="small text-muted mb-0">Selalu cek kembali sebelum publikasi</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            /* CSS dengan animasi lebih mulus dan natural */
            .upload-choice-page {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                min-height: 100vh;
            }

            .page-header {
                position: relative;
                padding: 2rem 0;
                perspective: 1000px;
            }

            .header-icon {
                animation: float 4s ease-in-out infinite;
                transform-style: preserve-3d;
                will-change: transform;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px) rotateX(0deg);
                }

                50% {
                    transform: translateY(-12px) rotateX(3deg);
                }
            }

            .header-decoration {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 1rem;
                margin-top: 2rem;
            }

            .decoration-line {
                width: 50px;
                height: 2px;
                background: linear-gradient(90deg, #0073e6, #00c4b4);
                animation: lineExpand 3s ease-in-out infinite;
            }

            @keyframes lineExpand {

                0%,
                100% {
                    width: 50px;
                    opacity: 1;
                }

                50% {
                    width: 60px;
                    opacity: 0.8;
                }
            }

            .decoration-icon {
                color: #0073e6;
                animation: pulse 3s ease-in-out infinite;
                transform-style: preserve-3d;
            }

            @keyframes pulse {

                0%,
                100% {
                    transform: scale(1) rotateY(0deg);
                    opacity: 1;
                }

                50% {
                    transform: scale(1.15) rotateY(8deg);
                    opacity: 0.9;
                }
            }

            .choice-card {
                position: relative;
                min-height: 400px;
                background: white;
                border-radius: 16px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                transform-style: preserve-3d;
                border: 1px solid rgba(0, 115, 230, 0.08);
            }

            .choice-card:hover {
                transform: translateY(-8px) scale(1.02);
                box-shadow: 0 12px 30px rgba(0, 115, 230, 0.15);
                border-color: rgba(0, 115, 230, 0.2);
            }

            .choice-icon {
                position: relative;
                display: inline-block;
                perspective: 1000px;
                transition: transform 0.4s ease;
            }

            .choice-card:hover .choice-icon {
                transform: scale(1.05) rotateY(5deg);
            }

            .icon-glow {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 90px;
                height: 90px;
                background: radial-gradient(circle, rgba(0, 115, 230, 0.25), transparent 70%);
                border-radius: 50%;
                animation: glow 3s ease-in-out infinite;
                pointer-events: none;
            }

            @keyframes glow {

                0%,
                100% {
                    transform: translate(-50%, -50%) scale(0.85);
                    opacity: 0.6;
                }

                50% {
                    transform: translate(-50%, -50%) scale(1.15);
                    opacity: 0.3;
                }
            }

            .choice-features {
                text-align: left;
                background: rgba(0, 115, 230, 0.04);
                border-radius: 10px;
                padding: 1rem;
                margin: 0 1rem;
                border: 1px solid rgba(0, 115, 230, 0.08);
                transition: all 0.3s ease;
            }

            .choice-card:hover .choice-features {
                background: rgba(0, 115, 230, 0.08);
                border-color: rgba(0, 115, 230, 0.15);
            }

            .feature-item {
                margin-bottom: 0.5rem;
                font-size: 0.9rem;
                transition: transform 0.3s ease;
            }

            .choice-card:hover .feature-item {
                transform: translateX(3px);
            }

            .stats-section {
                padding: 3rem 0;
            }

            .stat-card {
                background: white;
                border-radius: 16px;
                padding: 1.5rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                transform-style: preserve-3d;
                border: 1px solid rgba(0, 115, 230, 0.08);
                position: relative;
                overflow: hidden;
            }

            .stat-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 3px;
                background: linear-gradient(90deg, #0073e6, #00c4b4);
                transform: scaleX(0);
                transition: transform 0.4s ease;
            }

            .stat-card:hover {
                transform: translateY(-6px) scale(1.02);
                box-shadow: 0 10px 25px rgba(0, 115, 230, 0.15);
                border-color: rgba(0, 115, 230, 0.2);
            }

            .stat-card:hover::before {
                transform: scaleX(1);
            }

            .stat-icon {
                font-size: 2.5rem;
                margin-bottom: 1rem;
                transition: all 0.4s ease;
                display: inline-block;
            }

            .stat-card:hover .stat-icon {
                transform: scale(1.1) rotateY(10deg);
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
                color: #1a202c;
                margin-bottom: 0.5rem;
                transition: all 0.3s ease;
            }

            .stat-card:hover .stat-number {
                color: #0073e6;
                transform: scale(1.05);
            }

            .stat-label {
                color: #4a5568;
                font-weight: 500;
                transition: color 0.3s ease;
            }

            .stat-card:hover .stat-label {
                color: #2d3748;
            }

            .tips-section {
                padding: 3rem 0;
            }

            .tips-card {
                background: white;
                border-radius: 16px;
                padding: 2rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                border: 1px solid #e2e8f0;
                transition: all 0.3s ease;
            }

            .tips-card:hover {
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            }

            .tips-header i {
                animation: bulbGlow 2s ease-in-out infinite;
                display: inline-block;
            }

            @keyframes bulbGlow {

                0%,
                100% {
                    transform: scale(1);
                    filter: brightness(1);
                }

                50% {
                    transform: scale(1.08);
                    filter: brightness(1.2);
                }
            }

            .tip-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem;
                background: rgba(0, 115, 230, 0.03);
                border-radius: 10px;
                margin-bottom: 1rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border: 1px solid transparent;
            }

            .tip-item:hover {
                background: rgba(0, 115, 230, 0.08);
                transform: translateX(8px);
                border-color: rgba(0, 115, 230, 0.15);
            }

            .tip-number {
                background: linear-gradient(135deg, #0073e6, #00c4b4);
                color: white;
                width: 32px;
                height: 32px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                font-size: 0.9rem;
                flex-shrink: 0;
                box-shadow: 0 2px 8px rgba(0, 115, 230, 0.3);
                transition: all 0.3s ease;
            }

            .tip-item:hover .tip-number {
                transform: scale(1.1) rotate(5deg);
                box-shadow: 0 4px 12px rgba(0, 115, 230, 0.4);
            }

            .tip-content h6 {
                margin-bottom: 0.25rem;
                color: #1a202c;
                transition: color 0.3s ease;
            }

            .tip-item:hover .tip-content h6 {
                color: #0073e6;
            }

            .btn-primary {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }

            .btn-primary::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.2);
                transform: translate(-50%, -50%);
                transition: width 0.6s ease, height 0.6s ease;
            }

            .btn-primary:hover::before {
                width: 300px;
                height: 300px;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0, 115, 230, 0.3);
            }

            /* Smooth scroll behavior */
            * {
                scroll-behavior: smooth;
            }

            /* Responsive adjustments - Mobile Optimized */
            @media (max-width: 768px) {
                .container {
                    padding-left: 1.5rem;
                    padding-right: 1.5rem;
                    max-width: 100%;
                }

                .page-header {
                    padding: 1.5rem 0;
                }

                .header-icon {
                    animation: floatMobile 3s ease-in-out infinite;
                }

                @keyframes floatMobile {

                    0%,
                    100% {
                        transform: translateY(0px);
                    }

                    50% {
                        transform: translateY(-8px);
                    }
                }

                .choice-card {
                    min-height: auto;
                    margin-bottom: 1.5rem;
                    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
                }

                .choice-card:hover {
                    transform: translateY(-4px) scale(1.01);
                    box-shadow: 0 8px 20px rgba(0, 115, 230, 0.12);
                }

                .choice-card .card-body {
                    padding: 1.75rem 1.25rem;
                }

                .choice-icon {
                    margin-bottom: 1rem;
                }

                .choice-icon i {
                    font-size: 3rem !important;
                }

                .icon-glow {
                    width: 70px;
                    height: 70px;
                }

                .card-title {
                    font-size: 1.4rem;
                }

                .choice-features {
                    padding: 0.875rem;
                    margin: 0 0.5rem;
                }

                .feature-item {
                    font-size: 0.85rem;
                    margin-bottom: 0.4rem;
                }

                .btn-lg {
                    padding: 0.75rem 1.25rem;
                    font-size: 1rem;
                }

                .stats-section {
                    padding: 2rem 0;
                }

                .stat-card {
                    margin-bottom: 1rem;
                    padding: 1.25rem;
                    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
                }

                .stat-card:hover {
                    transform: translateY(-3px) scale(1.01);
                }

                .stat-icon {
                    font-size: 2.2rem;
                    margin-bottom: 0.75rem;
                }

                .stat-number {
                    font-size: 2.2rem;
                }

                .stat-label {
                    font-size: 0.9rem;
                }

                .tips-section {
                    padding: 2rem 0;
                }

                .tips-card {
                    padding: 1.5rem;
                }

                .tips-header h3 {
                    font-size: 1.3rem;
                }

                .tips-header i {
                    font-size: 1.75rem !important;
                }

                .tip-item {
                    padding: 0.875rem;
                    margin-bottom: 0.75rem;
                }

                .header-decoration {
                    margin-top: 1.5rem;
                }

                .decoration-line {
                    width: 35px;
                }
            }

            @media (max-width: 576px) {
                .container {
                    padding-left: 1.25rem;
                    padding-right: 1.25rem;
                    max-width: 100%;
                }

                .py-5 {
                    padding-top: 2rem !important;
                    padding-bottom: 2rem !important;
                }

                .page-header {
                    padding: 1rem 0;
                    margin-bottom: 2rem !important;
                }

                .header-icon {
                    margin-bottom: 1rem !important;
                }

                .header-icon i {
                    font-size: 2.5rem !important;
                }

                .page-header h1 {
                    font-size: 1.6rem;
                    line-height: 1.3;
                    margin-bottom: 0.75rem !important;
                }

                .page-header .lead {
                    font-size: 0.95rem;
                    line-height: 1.5;
                    padding: 0 0.5rem;
                }

                .header-decoration {
                    margin-top: 1rem;
                    gap: 0.75rem;
                }

                .decoration-line {
                    width: 25px;
                    height: 1.5px;
                }

                .decoration-icon {
                    font-size: 0.9rem;
                }

                .row.g-4 {
                    gap: 1rem !important;
                }

                .choice-card {
                    border-radius: 14px;
                    margin-bottom: 1rem;
                    margin-left: 0.5rem;
                    margin-right: 0.5rem;
                }

                .choice-card .card-body {
                    padding: 1.5rem 1rem;
                }

                .choice-icon i {
                    font-size: 2.5rem !important;
                }

                .icon-glow {
                    width: 60px;
                    height: 60px;
                }

                .card-title {
                    font-size: 1.25rem;
                    margin-bottom: 0.75rem !important;
                }

                .card-text {
                    font-size: 0.9rem;
                    line-height: 1.6;
                }

                .card-text small {
                    font-size: 0.8rem;
                    display: block;
                    margin-top: 0.5rem;
                }

                .choice-features {
                    text-align: left;
                    margin: 0 0.25rem;
                    padding: 0.75rem;
                }

                .feature-item {
                    font-size: 0.8rem;
                    display: flex;
                    align-items: center;
                }

                .feature-item i {
                    font-size: 0.9rem;
                }

                .btn-lg {
                    padding: 0.7rem 1rem;
                    font-size: 0.95rem;
                }

                .stats-section {
                    padding: 1.5rem 0;
                    margin-top: 2rem !important;
                }

                .stats-section .row {
                    margin-left: 0.5rem;
                    margin-right: 0.5rem;
                }

                .stats-section .col-md-4 {
                    padding-left: 0.5rem;
                    padding-right: 0.5rem;
                }

                .stat-card {
                    padding: 1rem;
                    border-radius: 14px;
                    margin-bottom: 0.75rem;
                }

                .stat-icon {
                    font-size: 2rem;
                    margin-bottom: 0.5rem;
                }

                .stat-number {
                    font-size: 2rem;
                    margin-bottom: 0.25rem;
                }

                .stat-label {
                    font-size: 0.85rem;
                }

                .tips-section {
                    padding: 1.5rem 0;
                    margin-top: 2rem !important;
                }

                .tips-section .col-lg-8 {
                    padding-left: 0.5rem;
                    padding-right: 0.5rem;
                }

                .tips-card {
                    padding: 1.25rem;
                    border-radius: 14px;
                }

                .tips-header {
                    margin-bottom: 1rem !important;
                }

                .tips-header i {
                    font-size: 1.5rem !important;
                    margin-bottom: 0.5rem !important;
                }

                .tips-header h3 {
                    font-size: 1.15rem;
                    line-height: 1.4;
                }

                .tip-item {
                    flex-direction: row;
                    text-align: left;
                    gap: 0.75rem;
                    padding: 0.75rem;
                    border-radius: 10px;
                    margin-bottom: 0.5rem;
                }

                .tip-item:hover {
                    transform: translateX(5px);
                }

                .tip-number {
                    width: 28px;
                    height: 28px;
                    font-size: 0.85rem;
                }

                .tip-content {
                    text-align: left;
                }

                .tip-content h6 {
                    font-size: 0.9rem;
                    margin-bottom: 0.15rem;
                }

                .tip-content p {
                    font-size: 0.8rem;
                    line-height: 1.4;
                }

                /* Disable complex 3D transforms on mobile for better performance */
                .choice-card:hover,
                .stat-card:hover {
                    transform: translateY(-4px);
                }

                .choice-icon,
                .stat-icon {
                    transform-style: flat;
                }
            }

            /* Extra small devices */
            @media (max-width: 375px) {
                .container {
                    padding-left: 1rem;
                    padding-right: 1rem;
                }

                .page-header h1 {
                    font-size: 1.4rem;
                }

                .page-header .lead {
                    font-size: 0.875rem;
                }

                .choice-card {
                    margin-left: 0.25rem;
                    margin-right: 0.25rem;
                }

                .choice-card .card-body {
                    padding: 1.25rem 0.875rem;
                }

                .card-title {
                    font-size: 1.15rem;
                }

                .btn-lg {
                    padding: 0.65rem 0.875rem;
                    font-size: 0.9rem;
                }

                .stats-section .row {
                    margin-left: 0.25rem;
                    margin-right: 0.25rem;
                }
            }

            /* Performance optimization */
            .choice-card,
            .stat-card,
            .tip-item,
            .btn-primary {
                will-change: transform;
            }
        </style>
    @endsection
