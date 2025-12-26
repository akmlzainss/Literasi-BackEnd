@extends('layouts.siswa')

@section('title', 'Video Siswa - SIPENA')
@section('meta')
    <meta name="description" content="Jelajahi video kreatif dari siswa SMKN 11 Bandung di platform SIPENA.">
    <meta name="keywords" content="video siswa, SIPENA, video edukasi, video kreatif, SMKN 11 Bandung">
@endsection
@section('body_class', 'video-gallery-page')

@section('additional_css')
<style>
    :root {
        --primary-blue: #3b82f6;
        --primary-dark: #1d4ed8;
    }

    .video-gallery-page {
        background: #f5f7fa;
        min-height: 100vh;
    }

    /* Hero Banner */
    .video-hero {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
        padding: 2.5rem 0;
        margin-bottom: 0;
    }

    .video-hero h1 {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .video-hero p {
        color: rgba(255,255,255,0.85);
        margin: 0.5rem 0 0;
    }

    /* Filter Bar */
    .filter-bar {
        background: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin: -1.5rem auto 1.5rem;
        max-width: 1200px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .filter-bar .form-control,
    .filter-bar .form-select {
        background: #f8f9fa;
        border: 1px solid #e2e8f0;
        color: #333;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .filter-bar .form-control:focus,
    .filter-bar .form-select:focus {
        background: #fff;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(59,130,246,0.15);
    }

    .filter-bar .btn-search {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        color: white;
    }

    .filter-bar .btn-search:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
    }

    /* Video Grid - Instagram Style 4 columns */
    .video-grid-container {
        background: #f5f7fa;
        padding: 20px;
    }

    .video-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        max-width: 1200px;
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .video-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        .video-grid-container {
            padding: 12px;
        }
    }

    /* Video Card - Instagram style 4:5 */
    .video-card {
        position: relative;
        aspect-ratio: 4/5;
        overflow: hidden;
        background: #e5e7eb;
        cursor: pointer;
        border-radius: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
    }

    .video-card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    .video-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Video Overlay */
    .video-card .overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2.5rem 0.75rem 0.75rem;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        color: #fff;
    }

    .video-card .overlay .author {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .video-card .overlay .author-avatar {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6rem;
        font-weight: 600;
        color: white;
    }

    /* Stats on hover */
    .video-card .stats {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        gap: 1rem;
        color: #fff;
        font-size: 0.85rem;
        font-weight: 600;
        opacity: 0;
        transition: opacity 0.2s;
        text-shadow: 0 2px 4px rgba(0,0,0,0.8);
    }

    .video-card:hover .stats {
        opacity: 1;
    }

    .video-card .stats span {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Play Icon */
    .video-card .play-icon {
        position: absolute;
        top: 0.6rem;
        right: 0.6rem;
        background: rgba(255,255,255,0.95);
        width: 26px;
        height: 26px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-blue);
        font-size: 0.65rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    /* New Badge */
    .video-card .new-badge {
        position: absolute;
        top: 0.6rem;
        left: 0.6rem;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        font-size: 0.55rem;
        font-weight: 700;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        text-transform: uppercase;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        color: #64748b;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        max-width: 1200px;
        margin: 2rem auto;
    }

    .empty-state .empty-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        color: #94a3b8;
        display: block;
    }

    .empty-state h4 {
        color: #1e293b;
        margin-bottom: 0.75rem;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .empty-state p {
        color: #64748b;
        margin-bottom: 1.5rem;
    }

    .empty-state .btn {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border: none;
        border-radius: 6px;
        padding: 0.6rem 1.25rem;
        color: white;
        font-weight: 500;
        font-size: 0.9rem;
        transition: transform 0.2s, box-shadow 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .empty-state .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59,130,246,0.4);
    }

    .empty-state .btn i {
        font-size: 0.8em;
        margin: 0;
        position: relative;
        top: 1px; /* Fine tune vertical alignment */
    }

    /* Results Count */
    .results-count {
        color: #64748b;
        font-size: 0.85rem;
        padding: 1rem 15px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Pagination Light Theme */
    .pagination-dark {
        padding: 1.5rem;
        display: flex;
        justify-content: center;
    }

    .pagination-dark .page-link {
        background: white;
        border: 1px solid #e2e8f0;
        color: #334155;
        margin: 0 0.15rem;
        border-radius: 8px;
    }

    .pagination-dark .page-link:hover {
        background: #f1f5f9;
        border-color: var(--primary-blue);
        color: var(--primary-blue);
    }

    .pagination-dark .page-item.active .page-link {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-color: transparent;
        color: white;
    }

    /* Upload FAB */
    .upload-fab {
        position: fixed;
        bottom: 2rem;
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
    }

    .upload-fab:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 30px rgba(59,130,246,0.6);
        color: #fff;
    }
</style>
@endsection

@section('content')
    <!-- Hero Banner -->
    <div class="video-hero">
        <div class="container text-center">
            <h1><i class="fas fa-play-circle me-2"></i>Video Siswa</h1>
            <p>Jelajahi video kreatif dari siswa SMKN 11 Bandung</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="container-fluid px-3 px-md-4">
        <div class="filter-bar">
            <form action="{{ route('video.index') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-4">
                        <input type="text" name="search" class="form-control" 
                            placeholder="Cari video..." value="{{ request('search') }}">
                    </div>
                    <div class="col-6 col-md-3">
                        <select class="form-select" name="kategori">
                            <option value="">Semua Kategori</option>
                            @foreach (\App\Models\Kategori::orderBy('nama', 'asc')->get() as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <select class="form-select" name="sort">
                            <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="populer" {{ request('sort') == 'populer' ? 'selected' : '' }}>Populer</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-search flex-grow-1">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                        @if(request()->hasAny(['search', 'kategori', 'sort']))
                            <a href="{{ route('video.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Count -->
    <div class="results-count container-fluid">
        {{ $videos->total() }} video ditemukan
    </div>

    <!-- Video Grid -->
    @if($videos->count() > 0)
    <div class="video-grid-container">
        <div class="video-grid">
            @foreach ($videos as $video)
                <a href="{{ route('video.tiktok') }}?start={{ $video->id }}" class="video-card" 
                   aria-label="Tonton video {{ $video->judul }}">
                    <img src="{{ $video->thumbnail_path ? asset('storage/' . $video->thumbnail_path) : asset('images/default-thumbnail.jpg') }}"
                         alt="{{ $video->judul }}" loading="lazy">
                    
                    <div class="play-icon">
                        <i class="fas fa-play"></i>
                    </div>

                    @if ($video->created_at->diffInDays() < 7)
                        <div class="new-badge">Baru</div>
                    @endif

                    <!-- Stats on hover -->
                    <div class="stats">
                        <span><i class="fas fa-heart"></i> {{ $video->interaksi()->where('jenis', 'suka')->count() }}</span>
                        <span><i class="fas fa-comment"></i> {{ $video->komentar()->count() }}</span>
                    </div>

                    <div class="overlay">
                        <div class="author">
                            <span class="author-avatar">{{ strtoupper(substr($video->siswa->nama ?? 'A', 0, 1)) }}</span>
                            <span>{{ Str::limit($video->siswa->nama ?? 'Admin', 12) }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-video empty-icon"></i>
        <h4>Belum Ada Video</h4>
        <p>Jadilah yang pertama mengupload video kreatifmu!</p>
        @auth('siswa')
            <a href="{{ route('video.create') }}" class="btn">
                <i class="fas fa-plus me-2"></i>Upload Video
            </a>
        @else
            <a href="{{ route('siswa.login') }}" class="btn">
                <i class="fas fa-sign-in-alt me-2"></i>Login untuk Upload
            </a>
        @endauth
    </div>
    @endif

    <!-- Pagination -->
    @if ($videos->hasPages())
        <div class="pagination-dark">
            {{ $videos->appends(request()->query())->links() }}
        </div>
    @endif

    <!-- Upload FAB (Floating Action Button) -->
    @auth('siswa')
        <a href="{{ route('video.create') }}" class="upload-fab" title="Upload Video">
            <i class="fas fa-plus"></i>
        </a>
    @endauth
@endsection
