@extends('layouts.siswa')

@section('title', 'Upload Karya - SIPENA')

@section('body_class', 'upload-choice-page')

@section('content')
    <!-- Hero Banner - Same as artikel/video -->
    <div class="hero-banner">
        <div class="container">
            <div class="hero-content text-center text-white">
                <div class="hero-icon mb-3">
                    <i class="fas fa-cloud-upload-alt fa-3x"></i>
                </div>
                <h1 class="hero-title">Mulai Berbagi Karyamu!</h1>
                <p class="hero-subtitle">Pilih jenis konten yang ingin kamu buat dan bagikan kepada teman-temanmu di SIPENA.</p>
            </div>
        </div>
        <div class="hero-wave"></div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <section class="content-section">
            <!-- Choice Cards -->
            <div class="row g-4 justify-content-center">
                <!-- Artikel Card -->
                <div class="col-md-6 col-lg-5">
                    <div class="choice-card">
                        <div class="choice-icon">
                            <i class="fas fa-pencil-alt"></i>
                        </div>
                        <h4 class="choice-title">Tulis Artikel Baru</h4>
                        <p class="choice-description">
                            Bagikan cerita inspiratif, ulasan buku/film, atau tulisan bebas lainnya.
                        </p>
                        <p class="user-count">
                            <i class="fas fa-file-alt"></i>
                            Kamu sudah menulis {{ $userArticles }} artikel
                        </p>
                        <a href="{{ route('artikel-siswa.create') }}" class="btn-choice">
                            <i class="fas fa-pen-fancy"></i>
                            Mulai Menulis
                        </a>
                    </div>
                </div>

                <!-- Video Card -->
                <div class="col-md-6 col-lg-5">
                    <div class="choice-card">
                        <div class="choice-icon">
                            <i class="fas fa-video"></i>
                        </div>
                        <h4 class="choice-title">Upload Video Baru</h4>
                        <p class="choice-description">
                            Punya karya dalam bentuk video? Bagikan dan tunjukkan kreativitasmu!
                        </p>
                        <p class="user-count">
                            <i class="fas fa-film"></i>
                            Kamu sudah upload {{ $userVideos }} video
                        </p>
                        <a href="{{ route('video.create') }}" class="btn-choice">
                            <i class="fas fa-video"></i>
                            Mulai Upload
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="stats-section">
                <div class="stats-container">
                    <div class="row g-0">
                        <div class="col-4">
                            <div class="stat-item">
                                <div class="stat-icon blue">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-number">{{ $activeWriters }}</div>
                                <div class="stat-label">Penulis Aktif</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <div class="stat-icon green">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                                <div class="stat-number">{{ $publishedArticles }}</div>
                                <div class="stat-label">Total Artikel</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-item">
                                <div class="stat-icon purple">
                                    <i class="fas fa-video"></i>
                                </div>
                                <div class="stat-number">{{ $publishedVideos }}</div>
                                <div class="stat-label">Total Video</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('additional_css')
<style>
    /* ========================================
       CHOICE CARDS
    ======================================== */
    .choice-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
        text-align: center;
        height: 100%;
    }
    
    .choice-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(59, 130, 246, 0.15);
        border-color: rgba(59, 130, 246, 0.3);
    }
    
    .choice-icon {
        width: 70px;
        height: 70px;
        background: var(--gradient-blue-enhanced);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        transition: all 0.3s ease;
    }
    
    .choice-card:hover .choice-icon {
        transform: scale(1.05);
    }
    
    .choice-icon i {
        font-size: 1.75rem;
        color: white;
    }
    
    .choice-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 0.75rem;
    }
    
    .choice-description {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1.25rem;
    }
    
    .user-count {
        font-size: 0.875rem;
        color: var(--primary);
        margin-bottom: 1.5rem;
    }
    
    .user-count i {
        margin-right: 0.25rem;
    }
    
    .btn-choice {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.875rem 1.5rem;
        background: var(--gradient-blue-enhanced);
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .btn-choice:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        color: white;
    }
    
    /* ========================================
       STATISTICS SECTION
    ======================================== */
    .stats-section {
        margin-top: 2rem;
    }
    
    .stats-container {
        background: white;
        border-radius: 20px;
        padding: 1.5rem 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
    }
    
    .stat-item {
        text-align: center;
        padding: 1rem 0.5rem;
    }
    
    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 1.25rem;
    }
    
    .stat-icon.blue {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: var(--primary);
    }
    
    .stat-icon.green {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        color: #16a34a;
    }
    
    .stat-icon.purple {
        background: linear-gradient(135deg, #f3e8ff 0%, #e9d5ff 100%);
        color: #7c3aed;
    }
    
    .stat-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 500;
    }
    
    /* ========================================
       RESPONSIVE
    ======================================== */
    @media (max-width: 768px) {
        .choice-card {
            padding: 1.5rem;
            border-radius: 16px;
        }
        
        .choice-icon {
            width: 60px;
            height: 60px;
        }
        
        .choice-icon i {
            font-size: 1.5rem;
        }
        
        .choice-title {
            font-size: 1.1rem;
        }
        
        .stats-container {
            padding: 1rem 1.25rem;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
        }
        
        .stat-number {
            font-size: 1.25rem;
        }
        
        .stat-label {
            font-size: 0.75rem;
        }
    }
    
    @media (max-width: 576px) {
        .choice-card {
            padding: 1.25rem;
        }
        
        .choice-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
        }
        
        .choice-icon i {
            font-size: 1.4rem;
        }
        
        .choice-title {
            font-size: 1rem;
        }
        
        .choice-description {
            font-size: 0.875rem;
        }
        
        .btn-choice {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
        
        .stats-container {
            padding: 0.75rem 1rem;
            border-radius: 16px;
        }
        
        .stat-item {
            padding: 0.5rem 0.25rem;
        }
        
        .stat-icon {
            width: 35px;
            height: 35px;
            font-size: 1rem;
            border-radius: 10px;
        }
        
        .stat-number {
            font-size: 1.1rem;
        }
        
        .stat-label {
            font-size: 0.7rem;
        }
    }
</style>
@endsection
