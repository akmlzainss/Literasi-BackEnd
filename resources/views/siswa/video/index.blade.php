@extends('layouts.siswa')

@section('title', 'Jelajahi Video - SIPENA')
@section('meta')
    <meta name="description"
        content="Jelajahi koleksi video kreatif dari siswa di platform SIPENA. Temukan inspirasi melalui video pendidikan, seni, dan lainnya.">
    <meta name="keywords" content="video siswa, SIPENA, video edukasi, video kreatif">
@endsection
@section('body_class', 'video-page')

@section('content')
    <div class="hero-banner">
        <div class="container">
            <div class="hero-content text-center text-white">
                <div class="hero-icon mb-3">
                    <i class="fas fa-play-circle fa-3x"></i>
                </div>
                <h1 class="hero-title">Jelajahi Semua Video</h1>
                <p class="hero-subtitle">Temukan inspirasi dari berbagai video kreatif teman-temanmu</p>
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
                                <input type="text" name="search" class="form-control" placeholder="Cari judul video..."
                                    value="{{ request('search') }}">
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
                                    <span class="badge bg-success">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ \App\Models\Kategori::find(request('kategori'))->nama ?? 'Kategori' }}
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
                            <i class="fas fa-list-ul me-2 text-primary"></i>
                            Hasil Pencarian
                        </h5>
                        <p class="text-muted mb-0 small">
                            Ditemukan {{ $videos->total() }} video
                            @if (request()->hasAny(['search', 'kategori', 'sort']))
                                dengan filter yang dipilih
                            @endif
                        </p>
                    </div>
                    <div class="d-flex justify-content-center mb-4">
                        <a href="{{ route('video.tiktok') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-mobile-alt me-2"></i> Tonton dalam Mode Scroll
                        </a>
                    </div>
                </div>
            </div>

            <div class="articles-container" id="articlesContainer">
                <div class="row g-4" id="articlesGrid">
                    @forelse ($videos as $video)
                        <div class="col-6 col-md-4 col-lg-3 article-item animate-ready">
                            <a href="{{ route('video.tiktok') }}#video-{{ $video->id }}" class="content-card"
                                aria-label="Lihat video {{ $video->judul }}">
                                <div class="card-img-top-wrapper">
                                    <img src="{{ $video->thumbnail_path ? asset('storage/' . $video->thumbnail_path) : asset('images/default-thumbnail.jpg') }}"
                                        alt="Thumbnail untuk {{ $video->judul }}" class="card-img-top">
                                    <div class="card-overlay">
                                        <i class="fas fa-play" aria-hidden="true"></i>
                                    </div>
                                    @if ($video->kategori)
                                        <div class="category-badge">
                                            <span class="badge"
                                                aria-label="Kategori {{ $video->kategori->nama }}">{{ $video->kategori->nama }}</span>
                                        </div>
                                    @endif
                                    @if ($video->created_at->diffInDays() < 7)
                                        <div class="new-badge">
                                            <span class="badge" aria-label="Video baru">Baru</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $video->judul }}</h5>
                                    <p class="card-author">
                                        <i class="fas fa-user-edit me-1"></i>
                                        {{ $video->siswa->nama ?? 'Admin' }}
                                    </p>
                                    <div class="card-meta">
                                        <small class="text-muted d-block">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $video->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                    <div class="card-stats">
                                        <span><i class="fas fa-eye fa-xs"></i> {{ $video->komentar()->count() }}</span>
                                        <span><i class="fas fa-heart fa-xs"></i>
                                            {{ $video->interaksi()->where('jenis', 'suka')->count() }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <h4>Belum Ada Video</h4>
                                <p>Jadilah yang pertama mengupload video kreatifmu!</p>
                                <a href="{{ route('video.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Upload Video Pertama
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($videos->hasPages())
                <div class="pagination-wrapper animate-ready">
                    <div class="d-flex justify-content-center mt-5">
                        {{ $videos->appends(request()->query())->links() }}
                    </div>
                    <div class="pagination-info text-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $videos->firstItem() }}-{{ $videos->lastItem() }}
                            dari {{ $videos->total() }} video
                        </small>
                    </div>
                </div>
            @endif
        </section>
    </div>
@endsection
