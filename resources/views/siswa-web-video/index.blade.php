    @extends('layouts.layouts')

@section('title', 'Jelajahi Video - SIPENA')
@section('body_class', 'artikel-page')

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
        <div class="d-flex justify-content-center mb-4">
            <a href="{{ route('video.tiktok') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-mobile-alt me-2"></i> Tonton dalam Mode Scroll
            </a>
        </div>
        
        <div class="articles-container" id="articlesContainer">
            <div class="row g-4" id="articlesGrid">
                @forelse ($videos as $video)
                    <div class="col-6 col-md-4 col-lg-3 article-item animate-ready">
                        <a href="{{ route('video.tiktok') }}#video-{{ $video->id }}" class="content-card">
                            <div class="card-img-top-wrapper">
                                <video muted preload="metadata" class="card-img-top">
                                    <source src="{{ asset('storage/' . $video->video_path) }}#t=0.5" type="video/mp4">
                                </video>
                                <div class="card-overlay">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $video->judul }}</h5>
                                <p class="card-author">
                                    <i class="fas fa-user-edit me-1"></i>
                                    {{ $video->siswa->nama ?? 'Admin' }}
                                </p>
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
        
        @if($videos->hasPages())
        <div class="pagination-wrapper animate-ready">
            <div class="d-flex justify-content-center mt-5">
                {{ $videos->links() }}
            </div>
        </div>
        @endif
    </section>
</div>
@endsection
