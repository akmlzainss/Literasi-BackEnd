@extends('layouts.layouts')

@section('title', 'Video Feed - SIPENA')
@section('meta')
    <meta name="description" content="Nikmati video dalam mode scroll ala TikTok di platform SIPENA. Tonton karya kreatif siswa dengan pengalaman interaktif.">
    <meta name="keywords" content="video TikTok, SIPENA, video siswa, scroll video">
@endsection

@section('additional_css')
<style>
    .tiktok-container {
        height: calc(100vh - 80px);
        width: 100%;
        scroll-snap-type: y mandatory;
        overflow-y: scroll;
        overflow-x: hidden;
        margin-top: 80px;
    }
    .video-slide {
        height: calc(100vh - 80px);
        width: 100%;
        scroll-snap-align: start;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .video-player {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #000;
    }
    .video-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 20px;
        color: white;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        z-index: 10;
    }
    .video-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .video-author {
        font-size: 0.9rem;
        font-weight: 500;
    }
    .back-button {
        position: fixed;
        top: 90px;
        left: 20px;
        z-index: 20;
        color: white;
        font-size: 1.5rem;
        text-decoration: none;
        background: rgba(0,0,0,0.5);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .footer-sekolah {
        display: none;
    }
    .main-wrapper {
        padding-top: 0;
    }
    .interaction-buttons {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        gap: 15px;
        z-index: 15;
    }
    .interaction-buttons .btn-action {
        background: rgba(255, 255, 255, 0.9);
        color: var(--text-primary);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .interaction-buttons .btn-action.active {
        background: #fff1f2;
        color: #e11d48;
    }
    .interaction-buttons .btn-action.bookmark.active {
        background: #eff6ff;
        color: #2563eb;
    }
    .comment-section {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 350px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 20px;
        overflow-y: auto;
        z-index: 10;
        display: none;
    }
    .comment-section.active {
        display: block;
    }
    .comment-form {
        margin-bottom: 20px;
    }
    .comment-list .comment-item {
        border-bottom: 1px solid var(--border);
        padding: 10px 0;
    }
    .comment-item .comment-author {
        font-weight: 600;
        font-size: 0.9rem;
    }
    .comment-item .comment-text {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }
    .comment-item .comment-meta {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }
    @media (max-width: 768px) {
        .comment-section {
            width: 100%;
            right: 0;
            bottom: 0;
            top: auto;
            height: 50%;
        }
    }
</style>
@endsection

@section('content')
<a href="{{ route('video.index') }}" class="back-button"><i class="fas fa-arrow-left"></i></a>

<div class="tiktok-container" id="tiktok-container">
    @foreach($videos as $video)
    <div class="video-slide" id="video-{{ $video->id }}">
        <video class="video-player" loop muted playsinline aria-label="Video berjudul {{ $video->judul }}">
            <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
            Browser Anda tidak mendukung tag video.
        </video>
        <div class="video-overlay">
            <h5 class="video-title">{{ $video->judul }}</h5>
            <p class="video-author"><i class="fas fa-user-circle me-2"></i>{{ $video->siswa->nama ?? 'Admin' }}</p>
        </div>
        <div class="interaction-buttons">
            <button class="btn-action {{ Auth::guard('siswa')->check() && $video->interaksi()->where('id_siswa', Auth::guard('siswa')->id())->where('jenis', 'suka')->exists() ? 'active' : '' }}"
                    data-action="suka" data-id="{{ $video->id }}">
                <i class="fas fa-heart"></i>
                <span class="count">{{ $video->interaksi()->where('jenis', 'suka')->count() }}</span>
            </button>
            <button class="btn-action {{ Auth::guard('siswa')->check() && $video->interaksi()->where('id_siswa', Auth::guard('siswa')->id())->where('jenis', 'bookmark')->exists() ? 'active bookmark' : '' }}"
                    data-action="bookmark" data-id="{{ $video->id }}">
                <i class="fas fa-bookmark"></i>
                <span class="count">{{ $video->interaksi()->where('jenis', 'bookmark')->count() }}</span>
            </button>
            <button class="btn-action comment-toggle" data-id="{{ $video->id }}">
                <i class="fas fa-comment"></i>
                <span class="count">{{ $video->komentar()->count() }}</span>
            </button>
        </div>
        <div class="comment-section" id="comment-section-{{ $video->id }}">
            <div class="comment-form">
                @auth('siswa')
                <form class="form-comment" data-id="{{ $video->id }}">
                    @csrf
                    <div class="input-group">
                        <textarea class="form-control" name="komentar" placeholder="Tulis komentar..." rows="2"></textarea>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </form>
                @else
                <p class="text-muted">Login untuk menambahkan komentar.</p>
                @endauth
            </div>
            <div class="comment-list">
                @foreach($video->komentar()->whereNull('id_komentar_parent')->get() as $komentar)
                <div class="comment-item">
                    <p class="comment-author">{{ $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'Unknown') }}</p>
                    <p class="comment-text">{{ $komentar->komentar }}</p>
                    <p class="comment-meta">{{ $komentar->created_at->diffForHumans() }}
                        @if(Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id() || Auth::guard('admin')->check() || Auth::guard('web')->check())
                        <button class="btn btn-link text-danger btn-sm delete-comment" data-id="{{ $komentar->id }}">Hapus</button>
                        @endif
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const videos = document.querySelectorAll('.video-player');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.play();
            } else {
                entry.target.pause();
            }
        });
    }, { threshold: 0.5 });

    videos.forEach(video => {
        observer.observe(video);
    });

    const hash = window.location.hash;
    if (hash) {
        const targetVideo = document.querySelector(hash);
        if (targetVideo) {
            targetVideo.scrollIntoView();
        }
    }

    // Interaksi tombol like/bookmark
    document.querySelectorAll('.btn-action[data-action]').forEach(button => {
        button.addEventListener('click', function() {
            const videoId = this.dataset.id;
            const action = this.dataset.action;

            fetch(`/video/${videoId}/interaksi`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ jenis: action })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const countSpan = this.querySelector('.count');
                    countSpan.textContent = data.count;
                    if (data.action === 'added') {
                        this.classList.add('active');
                        if (action === 'bookmark') this.classList.add('bookmark');
                    } else {
                        this.classList.remove('active', 'bookmark');
                    }
                } else {
                    alert(data.error);
                }
            });
        });
    });

    // Toggle comment section
    document.querySelectorAll('.comment-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const videoId = this.dataset.id;
            const commentSection = document.getElementById(`comment-section-${videoId}`);
            commentSection.classList.toggle('active');
        });
    });

    // Submit komentar
    document.querySelectorAll('.form-comment').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const videoId = this.dataset.id;
            const komentar = this.querySelector('textarea').value;

            fetch(`/video/${videoId}/komentar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ komentar: komentar })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const commentList = this.closest('.comment-section').querySelector('.comment-list');
                    const commentItem = document.createElement('div');
                    commentItem.className = 'comment-item';
                    commentItem.innerHTML = `
                        <p class="comment-author">${data.komentar.nama}</p>
                        <p class="comment-text">${data.komentar.komentar}</p>
                        <p class="comment-meta">${data.komentar.created_at}
                            <button class="btn btn-link text-danger btn-sm delete-comment" data-id="${data.komentar.id}">Hapus</button>
                        </p>
                    `;
                    commentList.prepend(commentItem);
                    this.querySelector('textarea').value = '';
                    this.closest('.video-slide').querySelector('.comment-toggle .count').textContent = 
                        parseInt(this.closest('.video-slide').querySelector('.comment-toggle .count').textContent) + 1;
                } else {
                    alert(data.error);
                }
            });
        });
    });

    // Hapus komentar
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-comment')) {
            const commentId = e.target.dataset.id;
            fetch(`/video/komentar/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    e.target.closest('.comment-item').remove();
                    const commentToggle = e.target.closest('.video-slide').querySelector('.comment-toggle .count');
                    commentToggle.textContent = parseInt(commentToggle.textContent) - 1;
                } else {
                    alert(data.error);
                }
            });
        }
    });
});
</script>
@endsection