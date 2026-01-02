@extends('layouts.siswa')

@section('title', 'Jelajahi Video - SIPENA')

@section('body_class', 'video-page')

@section('content')
    <div class="hero-banner">
        <div class="container">
            <div class="hero-content text-center text-white">
                <div class="hero-icon mb-3">
                    <i class="fas fa-play-circle fa-3x"></i>
                </div>
                <h1 class="hero-title">Jelajahi Semua Video</h1>
                <p class="hero-subtitle">Temukan video kreatif dari teman-temanmu di SMKN 11 Bandung</p>
            </div>
        </div>
        <div class="hero-wave"></div>
    </div>

    <div class="container py-5">
        <section class="content-section">
            <div class="search-panel-card animate-ready">
                <div class="search-panel-header text-center mb-4">
                    <h3 class="search-panel-title">
                        <i class="fas fa-filter me-2 text-primary"></i>
                        Filter & Pencarian
                    </h3>
                    <p class="text-muted small">Gunakan filter di bawah untuk menemukan video yang kamu cari</p>
                </div>

                <form action="{{ route('video.index') }}" method="GET" class="search-form">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-4 col-md-12">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-search me-2"></i>Kata Kunci
                            </label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari judul video..." value="{{ request('search') }}">
                                <span class="input-group-text">
                                    <i class="fas fa-keyboard"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-tags me-2"></i>Kategori
                            </label>
                            <select class="form-select" name="kategori">
                                <option value="">Semua Kategori</option>
                                @foreach (\App\Models\Kategori::orderBy('nama', 'asc')->get() as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-sort me-2"></i>Urutkan
                            </label>
                            <select class="form-select" name="sort">
                                <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>
                                    Terbaru</option>
                                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama
                                </option>
                                <option value="populer" {{ request('sort') == 'populer' ? 'selected' : '' }}>Paling Populer
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-12">
                            <button type="submit" class="btn btn-primary w-100 btn-search">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                        </div>
                    </div>

                    @if (request()->hasAny(['search', 'kategori', 'sort']))
                        <div class="active-filters mt-3">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <span class="text-muted small me-2">Filter aktif:</span>
                                @if (request('search'))
                                    <span class="badge bg-primary">
                                        <i class="fas fa-search me-1"></i>
                                        "{{ request('search') }}"
                                        <a href="{{ route('video.index', request()->except('search')) }}"
                                            class="text-white ms-1">×</a>
                                    </span>
                                @endif
                                @if (request('kategori'))
                                    @php
                                        $kategoriNama = \App\Models\Kategori::find(request('kategori'))?->nama ?? 'Unknown';
                                    @endphp
                                    <span class="badge bg-success">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ $kategoriNama }}
                                        <a href="{{ route('video.index', request()->except('kategori')) }}"
                                            class="text-white ms-1">×</a>
                                    </span>
                                @endif
                                @if (request('sort') && request('sort') != 'terbaru')
                                    <span class="badge bg-info">
                                        <i class="fas fa-sort me-1"></i>
                                        {{ ucfirst(request('sort')) }}
                                        <a href="{{ route('video.index', request()->except('sort')) }}"
                                            class="text-white ms-1">×</a>
                                    </span>
                                @endif
                                <a href="{{ route('video.index') }}" class="btn btn-link btn-sm text-danger p-0">
                                    <i class="fas fa-times me-1"></i>Reset semua
                                </a>
                            </div>
                        </div>
                    @endif
                </form>
            </div>

            <div class="results-summary animate-ready">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="results-info">
                        <h5 class="mb-1">
                            <i class="fas fa-video me-2 text-primary"></i>
                            Hasil Pencarian
                        </h5>
                        <p class="text-muted mb-0 small">
                            Ditemukan {{ $videos->total() }} video
                            @if (request()->hasAny(['search', 'kategori', 'sort']))
                                dengan filter yang dipilih
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="ig-video-grid-container">
                <div class="ig-video-grid">
                    @forelse ($videos as $video)
                        <a href="{{ route('video.tiktok') }}?start={{ $video->id }}" class="ig-video-item"
                           aria-label="Tonton video {{ $video->judul }}">
                            <img src="{{ $video->thumbnail_path ? asset('storage/' . $video->thumbnail_path) : asset('images/default-thumbnail.jpg') }}"
                                 alt="{{ $video->judul }}" loading="lazy">
                            
                            {{-- Video/Reels Icon --}}
                            <div class="ig-video-icon">
                                <i class="fas fa-play"></i>
                            </div>

                            {{-- Stats on Hover --}}
                            <div class="ig-video-overlay">
                                <div class="ig-video-stats">
                                    <span><i class="fas fa-heart"></i> {{ $video->interaksi()->where('jenis', 'suka')->count() }}</span>
                                    <span><i class="fas fa-comment"></i> {{ $video->komentar()->count() }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="ig-empty-state">
                            <i class="fas fa-video"></i>
                            <h4>Belum Ada Video</h4>
                            <p>Jadilah yang pertama mengupload video kreatifmu!</p>
                            @auth('siswa')
                            <a href="{{ route('video.create') }}" class="btn btn-empty-action">
                                <i class="fas fa-plus me-2"></i>Upload Video
                            </a>
                            @else
                            <a href="{{ route('siswa.login') }}" class="btn btn-empty-action">
                                <i class="fas fa-sign-in-alt me-2"></i>Login untuk Upload
                            </a>
                            @endauth
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($videos->hasPages())
                <div class="pagination-wrapper animate-ready">
                    <div class="pagination-info text-center mt-4">
                        <small class="text-muted">
                            Menampilkan {{ $videos->firstItem() }}-{{ $videos->lastItem() }}
                            dari {{ $videos->total() }} video
                        </small>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <nav aria-label="Pagination Navigation" class="pagination-enhanced">
                            {{ $videos->appends(request()->query())->links('vendor.pagination.custom-pagination') }}
                        </nav>
                    </div>
                </div>
            @endif
        </section>
    </div>

@endsection

@section('additional_css')
<style>
    /* =============================================
       TIKTOK/REELS STYLE VIDEO GRID - PORTRAIT
       ============================================= */
    
    .ig-video-grid-container {
        background: #f5f7fa;
        padding: 24px;
    }
    
    .ig-video-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    /* Responsive grid */
    @media (max-width: 1200px) {
        .ig-video-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
    }
    
    @media (max-width: 992px) {
        .ig-video-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }
    }
    
    @media (max-width: 576px) {
        .ig-video-grid-container {
            padding: 12px;
        }
        .ig-video-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }
    }
    
    /* Video Item - Portrait 9:16 (like TikTok/Reels) */
    .ig-video-item {
        position: relative;
        aspect-ratio: 9/16;
        overflow: hidden;
        background: #262626;
        cursor: pointer;
        display: block;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .ig-video-item:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 12px 30px rgba(0,0,0,0.2);
    }
    
    .ig-video-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    
    .ig-video-item:hover img {
        transform: scale(1.05);
    }
    
    /* Video/Reels Icon (top right corner) */
    .ig-video-icon {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(0,0,0,0.5);
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        backdrop-filter: blur(4px);
        z-index: 2;
    }
    
    @media (max-width: 576px) {
        .ig-video-icon {
            top: 8px;
            right: 8px;
            width: 26px;
            height: 26px;
            font-size: 0.7rem;
        }
    }
    
    /* Overlay with stats on hover */
    .ig-video-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to top,
            rgba(0, 0, 0, 0.7) 0%,
            rgba(0, 0, 0, 0.3) 40%,
            rgba(0, 0, 0, 0) 100%
        );
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding-bottom: 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .ig-video-item:hover .ig-video-overlay {
        opacity: 1;
    }
    
    .ig-video-stats {
        display: flex;
        gap: 1.25rem;
        color: white;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .ig-video-stats span {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    
    .ig-video-stats i {
        font-size: 1rem;
    }
    
    @media (max-width: 576px) {
        .ig-video-overlay {
            padding-bottom: 12px;
        }
        .ig-video-stats {
            gap: 0.75rem;
            font-size: 0.75rem;
        }
        .ig-video-stats i {
            font-size: 0.8rem;
        }
    }
    
    /* Empty State */
    .ig-empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 5rem 2rem;
        color: #8e8e8e;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    
    .ig-empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #c7c7c7;
        display: block;
    }
    
    .ig-empty-state h4 {
        color: #262626;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .ig-empty-state p {
        color: #8e8e8e;
        margin-bottom: 1.5rem;
    }
    
    .ig-empty-state .btn-empty-action {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important;
        border: none !important;
        border-radius: 6px !important;
        padding: 0.6rem 1.25rem !important;
        color: white !important;
        font-weight: 500 !important;
        font-size: 0.9rem !important;
        transition: transform 0.2s, box-shadow 0.2s !important;
        display: inline-flex !important;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(59,130,246,0.3);
    }
    
    .ig-empty-state .btn-empty-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59,130,246,0.4) !important;
        color: white;
    }
    
    .ig-empty-state .btn-empty-action i {
        font-size: 0.8em !important;
        margin: 0 !important;
        position: relative !important;
        top: 1px !important;
        color: white !important;
    }

    /* Upload FAB */
    .upload-fab {
        position: fixed;
        bottom: 6rem;
        right: 2rem;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: #fff;
        border: none;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(59,130,246,0.4);
        z-index: 100;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
    }

    .upload-fab:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 30px rgba(59,130,246,0.6);
        color: #fff;
    }
</style>
@endsection

