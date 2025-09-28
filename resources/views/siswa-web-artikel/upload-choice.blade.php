@extends('layouts.layouts')

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
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Kategori Fleksibel</span>
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

            <!-- Statistics Section -->
            <div class="stats-section mt-5">
                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="stat-card animate-ready">
                            <div class="stat-icon">
                                <i class="fas fa-users text-primary"></i>
                            </div>
                            <div class="stat-number">150+</div>
                            <div class="stat-label">Penulis Aktif</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card animate-ready">
                            <div class="stat-icon">
                                <i class="fas fa-newspaper text-success"></i>
                            </div>
                            <div class="stat-number">500+</div>
                            <div class="stat-label">Artikel Published</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card animate-ready">
                            <div class="stat-icon">
                                <i class="fas fa-eye text-info"></i>
                            </div>
                            <div class="stat-number">10K+</div>
                            <div class="stat-label">Total Views</div>
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
            /* Additional styles specific to upload choice page */
            .upload-choice-page {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            }

            .page-header {
                position: relative;
                padding: 2rem 0;
            }

            .header-icon {
                animation: float 3s ease-in-out infinite;
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-10px);
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
                background: var(--gradient-blue-enhanced);
            }

            .decoration-icon {
                color: var(--primary);
                animation: pulse 2s infinite;
            }

            .choice-card {
                position: relative;
                min-height: 450px;
            }

            .choice-card-disabled {
                opacity: 0.7;
                position: relative;
            }

            .choice-icon {
                position: relative;
                display: inline-block;
            }

            .icon-glow {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 100px;
                height: 100px;
                background: radial-gradient(circle, rgba(0, 115, 230, 0.2), transparent);
                border-radius: 50%;
                animation: glow 2s ease-in-out infinite alternate;
            }

            .icon-glow.disabled {
                background: radial-gradient(circle, rgba(108, 117, 125, 0.2), transparent);
            }

            @keyframes glow {
                from {
                    transform: translate(-50%, -50%) scale(0.8);
                    opacity: 0.7;
                }

                to {
                    transform: translate(-50%, -50%) scale(1.2);
                    opacity: 0.3;
                }
            }

            .choice-features {
                text-align: left;
                background: rgba(0, 115, 230, 0.05);
                border-radius: 8px;
                padding: 1rem;
            }

            .feature-item {
                margin-bottom: 0.5rem;
                font-size: 0.9rem;
            }

            .coming-soon-badge {
                position: absolute;
                top: 15px;
                right: 15px;
            }

            .stats-section {
                padding: 3rem 0;
            }

            .stat-card {
                background: white;
                border-radius: 16px;
                padding: 2rem 1rem;
                box-shadow: var(--shadow-md);
                transition: var(--transition-smooth);
                border: 2px solid transparent;
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: var(--shadow-lg);
                border-color: var(--primary);
            }

            .stat-icon {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: 800;
                color: var(--text-primary);
                margin-bottom: 0.5rem;
            }

            .stat-label {
                color: var(--text-secondary);
                font-weight: 500;
            }

            .tips-section {
                padding: 3rem 0;
            }

            .tips-card {
                background: white;
                border-radius: 20px;
                padding: 3rem;
                box-shadow: var(--shadow-lg);
                border: 1px solid var(--border);
            }

            .tip-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem;
                background: rgba(0, 115, 230, 0.05);
                border-radius: 12px;
                margin-bottom: 1rem;
                transition: var(--transition-smooth);
            }

            .tip-item:hover {
                background: rgba(0, 115, 230, 0.1);
                transform: translateX(5px);
            }

            .tip-number {
                background: var(--gradient-blue-enhanced);
                color: white;
                width: 30px;
                height: 30px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                font-size: 0.9rem;
                flex-shrink: 0;
            }

            .tip-content h6 {
                margin-bottom: 0.25rem;
                color: var(--text-primary);
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .choice-card {
                    min-height: auto;
                }

                .choice-card .card-body {
                    padding: 2rem 1.5rem;
                }

                .tips-card {
                    padding: 2rem 1.5rem;
                }

                .stat-card {
                    margin-bottom: 1rem;
                }

                .header-decoration {
                    margin-top: 1.5rem;
                }

                .decoration-line {
                    width: 30px;
                }
            }

            @media (max-width: 576px) {
                .page-header {
                    padding: 1rem 0;
                }

                .tips-card {
                    padding: 1.5rem 1rem;
                }

                .choice-features {
                    text-align: center;
                }

                .tip-item {
                    flex-direction: column;
                    text-align: center;
                    gap: 0.5rem;
                }

                .tip-content {
                    text-align: center;
                }
            }
        </style>
    @endsection
