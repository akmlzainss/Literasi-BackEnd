@extends('layouts.layouts')

@section('title', 'Video Feed - SIPENA')
@section('meta')
    <meta name="description"
        content="Nikmati video dalam mode scroll ala TikTok di platform SIPENA. Tonton karya kreatif siswa dengan pengalaman interaktif.">
    <meta name="keywords" content="video TikTok, SIPENA, video siswa, scroll video">
@endsection
<link rel="stylesheet" href="{{ asset('css/tiktok.css') }}">

@section('additional_css')
    <style>
        /* ... CSS Anda yang sudah ada ... */
        
        .comment-replies { margin-left: 2rem; margin-top: 0.5rem; padding-left: 1rem; border-left: 2px solid #e9ecef; position: relative; }
        .comment-replies:before { content: ''; position: absolute; left: -2px; top: 0; width: 2px; height: 100%; background: linear-gradient(180deg, #3b82f6 0%, transparent 100%); opacity: 0.5; }
        .reply-form { margin-left: 1rem; margin-top: 0.5rem; padding: 0.75rem; background: #f8fafc; border-radius: 8px; border: 1px dashed #d1d5db; display: none; animation: slideDown 0.3s ease; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .btn-reply { font-size: 0.875rem; padding: 0.25rem 0.75rem; border-radius: 6px; transition: all 0.3s ease; font-weight: 500; border: 1px solid #d1d5db; background: #ffffff; color: #1f2937; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-reply:hover { transform: translateX(3px); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border-color: #3b82f6; background: #f8fafc; }
        .btn-reply.btn-secondary { background: #3b82f6; color: #ffffff; border-color: #3b82f6; }
        .btn-cancel-reply { font-size: 0.875rem; padding: 0.25rem 0.75rem; border-radius: 6px; transition: all 0.3s ease; font-weight: 500; margin-left: 0.5rem; }

        /* UNTUK MENYEMBUNYIKAN BALASAN SECARA DEFAULT */
        .reply-item.hidden-reply {
            display: none;
        }

        /* GAYA UNTUK TOMBOL "LIHAT BALASAN" DAN "SEMBUNYIKAN" */
        .view-replies-wrapper {
            margin-top: 0.75rem;
            display: flex;
            justify-content: flex-start;
            gap: 1rem; /* Jarak antar tombol */
        }
        .btn-view-replies, .btn-hide-replies {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280; /* Abu-abu */
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-view-replies .line, .btn-hide-replies .line {
            width: 20px;
            height: 1px;
            background-color: #d1d5db;
        }
        .btn-view-replies:hover, .btn-hide-replies:hover {
            color: #1f2937; /* Hitam */
        }

        /* CLASS UNTUK MENYEMBUNYIKAN TOMBOL */
        .hide-button {
            display: none !important;
        }

        /* ANIMASI SAAT BALASAN MUNCUL */
        @keyframes reveal {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .reveal-reply {
            animation: reveal 0.4s ease forwards;
        /* Tambahan gaya untuk balasan komentar */
        .comment-replies {
            margin-left: 2rem;
            margin-top: 0.5rem;
            padding-left: 1rem;
            border-left: 2px solid #e9ecef;
            position: relative;
        }

        .comment-replies:before {
            content: '';
            position: absolute;
            left: -2px;
            top: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(180deg, #3b82f6 0%, transparent 100%);
            opacity: 0.5;
        }

        .reply-form {
            margin-left: 1rem;
            margin-top: 0.5rem;
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px dashed #d1d5db;
            display: none;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-reply {
            font-size: 0.875rem;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-weight: 500;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #1f2937;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-reply:hover {
            transform: translateX(3px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
            background: #f8fafc;
        }

        .btn-reply.btn-secondary {
            background: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }

        .btn-cancel-reply {
            font-size: 0.875rem;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-weight: 500;
            margin-left: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <a href="{{ route('video.index') }}" class="back-button" aria-label="Kembali ke halaman utama">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="tiktok-container" id="tiktok-container">
        @forelse($videos as $video)
            <div class="video-slide" id="video-{{ $video->id }}" data-video-id="{{ $video->id }}">
                <div class="video-progress"><div class="video-progress-bar"></div></div>
                <video class="video-player" loop muted playsinline preload="metadata" aria-label="Video berjudul {{ $video->judul }}">
                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
                <div class="video-overlay">
                    <div class="video-info">
                        <div class="video-author">
                            <span class="author-avatar">{{ Str::substr($video->siswa->nama ?? 'A', 0, 1) }}</span>
                            <span>{{ $video->siswa->nama ?? 'Admin' }}</span>
                        </div>
                        <h5 class="video-title">{{ $video->judul }}</h5>
                        <div class="video-stats">
                            <span><i class="fas fa-eye"></i> {{ $video->jumlah_view ?? 0 }}</span>
                            <span><i class="fas fa-calendar"></i> {{ $video->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <div class="interaction-buttons">
                    <button class="btn-action like-btn {{ Auth::guard('siswa')->check() && $video->interaksi()->where('id_siswa', Auth::guard('siswa')->id())->where('jenis', 'suka')->exists() ? 'active' : '' }}" data-action="suka" data-id="{{ $video->id }}" title="Suka video ini">
                        <i class="fas fa-heart"></i>
                        <span class="count">{{ $video->interaksi()->where('jenis', 'suka')->count() }}</span>
                    </button>
                    <button class="btn-action bookmark-btn {{ Auth::guard('siswa')->check() && $video->interaksi()->where('id_siswa', Auth::guard('siswa')->id())->where('jenis', 'bookmark')->exists() ? 'active' : '' }}" data-action="bookmark" data-id="{{ $video->id }}" title="Simpan video">
                        <i class="fas fa-bookmark"></i>
                        <span class="count">{{ $video->interaksi()->where('jenis', 'bookmark')->count() }}</span>
                    </button>
                    <button class="btn-action comment-btn comment-toggle" data-id="{{ $video->id }}" title="Lihat komentar">
                        <i class="fas fa-comment"></i>
                        <span class="count">{{ $video->komentar()->count() }}</span>
                    </button>
                </div>

                <div class="comment-section" id="comment-section-{{ $video->id }}">
                    <div class="comment-header">
                        <h5><i class="fas fa-comments me-2"></i>Komentar</h5>
                        <button class="close-comments" aria-label="Tutup komentar"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="comment-list" id="comment-list-{{ $video->id }}">
                        @forelse($video->komentar()->whereNull('id_komentar_parent')->latest()->get() as $komentar)
                            <div class="comment-item" data-comment-id="{{ $komentar->id }}">
                                <div class="comment-author">
                                    <span class="comment-author-avatar">{{ Str::substr($komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'U'), 0, 1) }}</span>
                                    <span>{{ $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'Unknown') }}</span>
                                </div>
                                <p class="comment-text">{{ $komentar->komentar }}</p>
                                <div class="comment-meta">
                                    <span>{{ $komentar->created_at->diffForHumans() }}</span>
                                    @auth('siswa')
                                        <button class="btn btn-outline-secondary btn-sm btn-reply" data-id="{{ $komentar->id }}"><i class="fas fa-reply"></i> Balas</button>
                                        @if ((Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id()) || Auth::guard('admin')->check() || Auth::guard('web')->check())
                                            <button class="btn btn-outline-secondary btn-sm delete-comment" data-id="{{ $komentar->id }}"><i class="fas fa-trash"></i> Hapus</button>
                                        @endif
                                    @endauth
                                </div>
                                @auth('siswa')
                                    <form action="{{ route('video.komentar.store', $video->id) }}" method="POST" class="reply-form" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="id_komentar_parent" value="{{ $komentar->id }}">
                                        <div class="input-group mb-2"><textarea class="form-control" name="komentar" placeholder="Tulis balasan..." rows="2" required></textarea></div>
                                        <button class="btn btn-outline-secondary btn-sm btn-reply"
                                            data-id="{{ $komentar->id }}">
                                            <i class="fas fa-reply"></i> Balas
                                        </button>
                                        @if (
                                            (Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id()) ||
                                                Auth::guard('admin')->check() ||
                                                Auth::guard('web')->check())
                                            <button class="btn btn-outline-secondary btn-sm delete-comment"
                                                data-id="{{ $komentar->id }}">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        @endif
                                    @endauth
                                </div>

                                <!-- Reply Form -->
                                @auth('siswa')
                                    <form
                                        action="{{ route('video.komentar.store', ['id' => $video->id, 'parentId' => $komentar->id]) }}"
                                        method="POST" class="reply-form" data-parent-id="{{ $komentar->id }}"
                                        style="display: none;">
                                        @csrf
                                        <div class="input-group mb-2">
                                            <textarea class="form-control" name="komentar" placeholder="Tulis balasan..." rows="2" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Kirim Balasan</button>
                                        <button type="button" class="btn btn-secondary btn-sm btn-cancel-reply">Batal</button>
                                    </form>
                                @endauth

                                @php
                                    $replies = $komentar->replies;
                                    $replyCount = $replies->count();
                                    $visibleThreshold = 3; // Number of replies to show per click
                                @endphp
                                @if ($replyCount > 0)
                                    <div class="comment-replies-container">
                                        <div class="comment-replies">
                                            @foreach($replies as $index => $balasan)
                                                <div class="comment-item reply-item hidden-reply" data-comment-id="{{ $balasan->id }}">
                                                    @include('partials.video_comment_item', ['komentar' => $balasan])
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="view-replies-wrapper">
                                            <button class="btn-view-replies">
                                                <span class="line"></span>
                                                Lihat {{ $replyCount }} balasan
                                            </button>
                                            <button class="btn-hide-replies hide-button">
                                                <span class="line"></span>
                                                Sembunyikan
                                            </button>
                                        </div>
                                <!-- Replies -->
                                @if ($komentar->replies->isNotEmpty())
                                    <div class="comment-replies">
                                        @foreach ($komentar->replies as $balasan)
                                            <div class="comment-item" data-comment-id="{{ $balasan->id }}">
                                                <div class="comment-author">
                                                    <span class="comment-author-avatar">
                                                        {{ Str::substr($balasan->siswa ? $balasan->siswa->nama : ($balasan->admin ? $balasan->admin->nama : 'U'), 0, 1) }}
                                                    </span>
                                                    <span>{{ $balasan->siswa ? $balasan->siswa->nama : ($balasan->admin ? $balasan->admin->nama : 'Unknown') }}</span>
                                                </div>
                                                <p class="comment-text">{{ $balasan->komentar }}</p>
                                                <div class="comment-meta">
                                                    <span>{{ $balasan->created_at->diffForHumans() }}</span>
                                                    @auth('siswa')
                                                        @if (
                                                            (Auth::guard('siswa')->check() && $balasan->id_siswa == Auth::guard('siswa')->id()) ||
                                                                Auth::guard('admin')->check() ||
                                                                Auth::guard('web')->check())
                                                            <button class="btn btn-outline-secondary btn-sm delete-comment"
                                                                data-id="{{ $balasan->id }}">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        @endif
                                                    @endauth
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="empty-comments">
                                <i class="fas fa-comment-slash"></i>
                                <p>Belum ada komentar. Jadilah yang pertama!</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="comment-form">
                        @auth('siswa')
                            <form class="form-comment" data-id="{{ $video->id }}">
                                @csrf
                                <div class="input-group mb-2"><textarea class="form-control" name="komentar" placeholder="Tulis komentar..." rows="2" required></textarea></div>
                                <button type="submit" class="btn btn-submit w-100"><i class="fas fa-paper-plane me-2"></i>Kirim Komentar</button>
                            </form>
                        @else
                            <p class="text-muted"><i class="fas fa-lock me-2"></i> Login untuk menambahkan komentar.</p>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="video-slide">
                <div class="empty-comments">
                    <i class="fas fa-video-slash"></i>
                    <p>Tidak ada video tersedia</p>
                </div>
            </div>
        @endforelse
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('tiktok-container');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

    // =============================================================
    // KODE YANG SUDAH BERFUNGSI (PLAYER, LIKE, KOMENTAR UTAMA, DSB)
    // =============================================================
    const videos = document.querySelectorAll('.video-player');
    let currentVideo = null;
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const video = entry.target;
            const progressBar = video.closest('.video-slide').querySelector('.video-progress-bar');
            if (entry.isIntersecting) {
                if (currentVideo && currentVideo !== video) { currentVideo.pause(); currentVideo.currentTime = 0; }
                video.play().catch(e => {});
                currentVideo = video;
                video.addEventListener('timeupdate', () => {
                    const progress = (video.currentTime / video.duration) * 100;
                    progressBar.style.width = `${progress}%`;
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('tiktok-container');
            const videos = document.querySelectorAll('.video-player');
            let currentVideo = null;
            const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector(
                'meta[name="csrf-token"]').content : '';

            if (!csrfToken) {
                console.error(
                    'CSRF token not found! Add <meta name="csrf-token" content="{{ csrf_token() }}"> to your layout.'
                    );
            }

            // Intersection Observer untuk auto-play video
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const video = entry.target;
                    const progressBar = video.closest('.video-slide').querySelector(
                        '.video-progress-bar');

                    if (entry.isIntersecting) {
                        if (currentVideo && currentVideo !== video) {
                            currentVideo.pause();
                            currentVideo.currentTime = 0;
                        }
                        video.play().catch(e => console.log('Autoplay prevented:', e));
                        currentVideo = video;
                        video.addEventListener('timeupdate', () => {
                            const progress = (video.currentTime / video.duration) * 100;
                            progressBar.style.width = progress + '%';
                        });
                    } else {
                        video.pause();
                        progressBar.style.width = '0%';
                    }
                });
            } else { video.pause(); progressBar.style.width = '0%'; }
        });
    }, { threshold: 0.5 });
    videos.forEach(video => {
        observer.observe(video);
        video.addEventListener('click', function() { this.paused ? this.play() : this.pause(); });
    });

    document.querySelectorAll('.btn-action[data-action]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            fetch(`/video/${this.dataset.id}/interaksi`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ jenis: this.dataset.action })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.querySelector('.count').textContent = data.count;
                    this.classList.toggle('active', data.action === 'added');
                } else { alert(data.error || 'Silakan login.'); }
            }).catch(err => console.error(err));
        });
    });

    document.querySelectorAll('.comment-toggle').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const commentSection = document.getElementById(`comment-section-${this.dataset.id}`);
            document.querySelectorAll('.comment-section.active').forEach(s => {
                if (s !== commentSection) s.classList.remove('active');
            });
            commentSection.classList.toggle('active');
        });
    });

    document.querySelectorAll('.close-comments').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            this.closest('.comment-section').classList.remove('active');
        });
    });
    
    document.querySelectorAll('.form-comment').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const videoId = this.dataset.id;
            const textarea = this.querySelector('textarea');
            if (!textarea.value.trim()) return;
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';

            fetch(`/video/${videoId}/komentar`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ komentar: textarea.value.trim() })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && !data.is_reply) {
                    const commentList = document.getElementById(`comment-list-${videoId}`);
                    commentList.querySelector('.empty-comments')?.remove();
                    const avatar_char = data.komentar.avatar_char || data.komentar.nama.charAt(0);
                    const newCommentHtml = `
                        <div class="comment-item" data-comment-id="${data.komentar.id}">
                            <div class="comment-author"><span class="comment-author-avatar">${avatar_char}</span><span>${data.komentar.nama}</span></div>
                            <p class="comment-text">${data.komentar.komentar}</p>
                            <div class="comment-meta">
                                <span>Baru saja</span>
                                <button class="btn btn-outline-secondary btn-sm btn-reply" data-id="${data.komentar.id}"><i class="fas fa-reply"></i> Balas</button>
                                <button class="btn btn-outline-secondary btn-sm delete-comment" data-id="${data.komentar.id}"><i class="fas fa-trash"></i> Hapus</button>
                            </div>
                            <form action="/video/${videoId}/komentar" method="POST" class="reply-form" style="display: none;">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="id_komentar_parent" value="${data.komentar.id}">
                                <div class="input-group mb-2"><textarea class="form-control" name="komentar" placeholder="Tulis balasan..." rows="2" required></textarea></div>
                                <button type="submit" class="btn btn-primary btn-sm">Kirim Balasan</button>
                                <button type="button" class="btn btn-secondary btn-sm btn-cancel-reply">Batal</button>
                            </form>
                        </div>`;
                    commentList.insertAdjacentHTML('afterbegin', newCommentHtml);
                    const countEl = this.closest('.video-slide').querySelector('.comment-toggle .count');
                    countEl.textContent = parseInt(countEl.textContent) + 1;
                    textarea.value = '';
                } else if (!data.success) { alert(data.message || 'Gagal mengirim komentar'); }
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    });

    // ======================================================================
    // EVENT LISTENER TERPUSAT UNTUK SEMUA AKSI KOMENTAR
    // ======================================================================
    container.addEventListener('click', function(e) {
        const replyBtn = e.target.closest('.btn-reply');
        const cancelBtn = e.target.closest('.btn-cancel-reply');
        const deleteBtn = e.target.closest('.delete-comment');
        const viewRepliesBtn = e.target.closest('.btn-view-replies');
        const hideRepliesBtn = e.target.closest('.btn-hide-replies');

        if (replyBtn) {
            e.preventDefault();
            const parentComment = replyBtn.closest('.comment-item');
            const form = parentComment.querySelector('.reply-form');
            if (!form) return;
            const isVisible = form.style.display === 'block';
            document.querySelectorAll('.reply-form').forEach(f => f.style.display = 'none');
            document.querySelectorAll('.btn-reply').forEach(b => {
                b.innerHTML = '<i class="fas fa-reply"></i> Balas';
                b.classList.remove('btn-secondary');
            videos.forEach(video => {
                observer.observe(video);
                video.addEventListener('click', function() {
                    if (this.paused) {
                        this.play();
                    } else {
                        this.pause();
                    }
                });
            });

            // Navigate to specific video from URL hash
            const hash = window.location.hash;
            if (hash) {
                setTimeout(() => {
                    const targetVideo = document.querySelector(hash);
                    if (targetVideo) {
                        targetVideo.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }, 100);
            }

            // Like/Bookmark interactions
            document.querySelectorAll('.btn-action[data-action]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const videoId = this.dataset.id;
                    const action = this.dataset.action;
                    
                    fetch(`/video/${videoId}/interaksi`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                jenis: action
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const countSpan = this.querySelector('.count');
                                countSpan.textContent = data.count;

                                if (data.action === 'added') {
                                    this.classList.add('active');
                                } else {
                                    this.classList.remove('active');
                                }
                            } else {
                                alert(data.error || 'Silakan login terlebih dahulu');
                            }
                        })
                        .catch(error => {
                            console.error('Error in like/bookmark:', error);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        });
                });
            });
            if (!isVisible) {
                form.style.display = 'block';
                replyBtn.innerHTML = '<i class="fas fa-times"></i> Batal';
                replyBtn.classList.add('btn-secondary');
            }
        }

        if (cancelBtn) {
            e.preventDefault();
            const form = cancelBtn.closest('.reply-form');
            form.style.display = 'none';
            const replyBtn = form.closest('.comment-item').querySelector('.btn-reply');
            if(replyBtn) {
                replyBtn.innerHTML = '<i class="fas fa-reply"></i> Balas';
                replyBtn.classList.remove('btn-secondary');
            }
        }
        
        if (deleteBtn) {
            e.preventDefault();
            if (confirm('Yakin ingin menghapus komentar ini?')) {
                const commentId = deleteBtn.dataset.id;
                fetch(`/video/komentar/${commentId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const commentItem = deleteBtn.closest('.comment-item');
                        const videoSlide = deleteBtn.closest('.video-slide');
                        const replyCount = commentItem.querySelectorAll('.comment-item').length;
                        const totalToDelete = 1 + replyCount;
                        commentItem.remove();
                        if (videoSlide) {
                            const countEl = videoSlide.querySelector('.comment-toggle .count');
                            countEl.textContent = Math.max(0, parseInt(countEl.textContent) - totalToDelete);
                        }
                    } else { alert(data.message || 'Gagal menghapus komentar.'); }
                })
                .catch(error => console.error('Error saat menghapus:', error));
            }
        }
        
        if (viewRepliesBtn) {
            e.preventDefault();
            const wrapper = viewRepliesBtn.closest('.view-replies-wrapper');
            const container = viewRepliesBtn.closest('.comment-replies-container');
            const hiddenReplies = container.querySelectorAll('.reply-item.hidden-reply');
            const visibleThreshold = 3;
            let shownReplies = 0;

            // Show up to 3 hidden replies
            for (let i = 0; i < hiddenReplies.length && shownReplies < visibleThreshold; i++) {
                hiddenReplies[i].classList.remove('hidden-reply');
                hiddenReplies[i].classList.add('reveal-reply');
                hiddenReplies[i].style.animationDelay = `${shownReplies * 0.05}s`;
                shownReplies++;
            }

            // Update button text based on remaining hidden replies
            const remainingHiddenReplies = container.querySelectorAll('.reply-item.hidden-reply').length;
            if (remainingHiddenReplies > 0) {
                viewRepliesBtn.querySelector('span').nextSibling.textContent = `Lihat ${remainingHiddenReplies} balasan lainnya`;
            } else {
                viewRepliesBtn.classList.add('hide-button');
            }

            // Show "Hide" button
            wrapper.querySelector('.btn-hide-replies').classList.remove('hide-button');
        }
        
        if (hideRepliesBtn) {
            e.preventDefault();
            const wrapper = hideRepliesBtn.closest('.view-replies-wrapper');
            const container = hideRepliesBtn.closest('.comment-replies-container');
            const allReplies = container.querySelectorAll('.reply-item');

            // Hide all replies
            allReplies.forEach(reply => {
                reply.classList.add('hidden-reply');
                reply.classList.remove('reveal-reply');
            });

            // Reset "View" button text and show it
            const totalReplies = allReplies.length;
            wrapper.querySelector('.btn-view-replies').querySelector('span').nextSibling.textContent = `Lihat ${totalReplies} balasan`;
            hideRepliesBtn.classList.add('hide-button');
            wrapper.querySelector('.btn-view-replies').classList.remove('hide-button');
        }
    });

    container.addEventListener('submit', function(e) {
        const form = e.target.closest('.reply-form');
        if (!form) return;
        e.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;

        fetch(form.action, { method: 'POST', body: new FormData(form), headers: {'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json'} })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.is_reply) {
                const parentComment = form.closest('.comment-item');
                let repliesContainer = parentComment.querySelector('.comment-replies');
                if (!repliesContainer) {
                    repliesContainer = document.createElement('div');
                    repliesContainer.className = 'comment-replies';
                    const wrapper = document.createElement('div');
                    wrapper.className = 'view-replies-wrapper';
                    wrapper.innerHTML = `
                        <button class="btn-view-replies">
                            <span class="line"></span>
                            Lihat 1 balasan
                        </button>
                        <button class="btn-hide-replies hide-button">
                            <span class="line"></span>
                            Sembunyikan balasan
                        </button>`;
                    parentComment.appendChild(wrapper);
                    parentComment.appendChild(repliesContainer);
                }
                repliesContainer.insertAdjacentHTML('beforeend', `<div class="comment-item reply-item hidden-reply" data-comment-id="${data.komentar.id}">${data.new_comment_html}</div>`);
                const countEl = form.closest('.video-slide').querySelector('.comment-toggle .count');
                countEl.textContent = parseInt(countEl.textContent) + 1;
                form.style.display = 'none';
                form.querySelector('textarea').value = '';
                const replyBtn = parentComment.querySelector('.btn-reply');
                if (replyBtn) {
                    replyBtn.innerHTML = '<i class="fas fa-reply"></i> Balas';
                    replyBtn.classList.remove('btn-secondary');
                }
                // Update "View" button text
                const wrapper = parentComment.querySelector('.view-replies-wrapper');
                if (wrapper) {
                    const totalHiddenReplies = parentComment.querySelectorAll('.reply-item.hidden-reply').length;
                    wrapper.querySelector('.btn-view-replies').querySelector('span').nextSibling.textContent = `Lihat ${totalHiddenReplies} balasan`;
                }
            } else {
                alert(data.message || 'Gagal mengirim balasan.');
            }
        })
        .finally(() => submitBtn.disabled = false);
    });
});
</script>
@endsection
            // Toggle comment section
            document.querySelectorAll('.comment-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const videoId = this.dataset.id;
                    const commentSection = document.getElementById(`comment-section-${videoId}`);
                    document.querySelectorAll('.comment-section.active').forEach(section => {
                        if (section.id !== `comment-section-${videoId}`) {
                            section.classList.remove('active');
                        }
                    });
                    commentSection.classList.toggle('active');
                });
            });

            // Close comments button
            document.querySelectorAll('.close-comments').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    this.closest('.comment-section').classList.remove('active');
                });
            });

            // Submit comment
            document.querySelectorAll('.form-comment').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const videoId = this.dataset.id;
                    const textarea = this.querySelector('textarea');
                    const komentar = textarea.value.trim();
                    if (!komentar) return;

                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';

                    fetch(`/video/${videoId}/komentar`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                komentar: komentar
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const commentList = document.getElementById(
                                    `comment-list-${videoId}`);
                                const emptyState = commentList.querySelector('.empty-comments');
                                if (emptyState) emptyState.remove();

                                const commentItem = document.createElement('div');
                                commentItem.className = 'comment-item';
                                commentItem.setAttribute('data-comment-id', data.komentar.id);
                                commentItem.innerHTML = `
                                <div class="comment-author">
                                    <span class="comment-author-avatar">${data.komentar.nama.charAt(0)}</span>
                                    <span>${data.komentar.nama}</span>
                                </div>
                                <p class="comment-text">${data.komentar.komentar}</p>
                                <div class="comment-meta">
                                    <span>Baru saja</span>
                                    <button class="btn btn-outline-secondary btn-sm btn-reply" data-id="${data.komentar.id}">
                                        <i class="fas fa-reply"></i> Balas
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm delete-comment" data-id="${data.komentar.id}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                                <form action="/video/${videoId}/komentar" method="POST" class="reply-form" data-parent-id="${data.komentar.id}" style="display: none;">
                                     @csrf
                                     <input type="hidden" name="id_komentar_parent" value="${data.komentar.id}">
                                     <div class="input-group mb-2">
                                        <textarea class="form-control" name="komentar" placeholder="Tulis balasan..." rows="2" required></textarea>
                                     </div>
                                     <button type="submit" class="btn btn-primary btn-sm">Kirim Balasan</button>
                                     <button type="button" class="btn btn-secondary btn-sm btn-cancel-reply">Batal</button>
                                </form>
                                `;
                                commentList.insertBefore(commentItem, commentList
                                    .firstChild);
                                const countElement = this.closest('.video-slide').querySelector(
                                    '.comment-toggle .count');
                                countElement.textContent = parseInt(countElement.textContent) + 1;
                                textarea.value = '';
                                initializeReplyButtons(); // Re-initialize all buttons
                            } else {
                                alert(data.error || 'Gagal mengirim komentar');
                            }
                        })
                        .catch(error => console.error('Error submitting comment:', error))
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                });
            });

            // --- PERBAIKAN FUNGSI DELETE KOMENTAR ---
            // Menggunakan event delegation pada container utama agar tombol hapus
            // pada komentar yang baru ditambahkan juga berfungsi.
            document.getElementById('tiktok-container').addEventListener('click', function(e) {
                const button = e.target.closest('.delete-comment');
                if (!button) return; // Jika yang diklik bukan tombol hapus, abaikan

                e.preventDefault();
                e.stopPropagation();

                const commentId = button.dataset.id;

                if (!confirm('Yakin ingin menghapus komentar ini?')) {
                    return;
                }

                const originalButtonHtml = button.innerHTML;
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch(`/video/komentar/${commentId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            // Coba parse error dari body jika ada
                            return response.json().then(err => {
                                throw new Error(err.message || `HTTP error! status: ${response.status}`)
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const commentItem = button.closest('.comment-item');
                            const videoSlide = button.closest('.video-slide');
                            const commentList = button.closest('.comment-list, .comment-replies');

                            // Animate out and remove
                            commentItem.style.transition = 'opacity 0.3s, transform 0.3s';
                            commentItem.style.opacity = '0';
                            commentItem.style.transform = 'translateX(20px)';
                            setTimeout(() => {
                                commentItem.remove();
                                // Cek apakah list komentar jadi kosong
                                if (commentList && commentList.querySelectorAll('.comment-item').length === 0 && commentList.classList.contains('comment-list')) {
                                    commentList.innerHTML = `
                                    <div class="empty-comments">
                                        <i class="fas fa-comment-slash"></i>
                                        <p>Belum ada komentar. Jadilah yang pertama!</p>
                                    </div>`;
                                }
                            }, 300);


                            // Update comment count
                            const countElement = videoSlide.querySelector('.comment-toggle .count');
                            if (countElement) {
                                const newCount = Math.max(0, parseInt(countElement.textContent) - 1);
                                countElement.textContent = newCount;
                            }

                        } else {
                            alert(data.message || 'Gagal menghapus komentar.');
                            button.disabled = false;
                            button.innerHTML = originalButtonHtml;
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting comment:', error);
                        alert('Terjadi kesalahan: ' + error.message);
                        button.disabled = false;
                        button.innerHTML = originalButtonHtml;
                    });
            });


            function initializeReplyButtons() {
                // Event delegation untuk semua tombol di dalam container
                const container = document.getElementById('tiktok-container');
                
                // --- Menggunakan satu event listener untuk efisiensi ---
                container.addEventListener('click', function(e) {
                    const replyBtn = e.target.closest('.btn-reply');
                    const cancelBtn = e.target.closest('.btn-cancel-reply');

                    if (replyBtn) {
                         e.preventDefault();
                         e.stopPropagation();
                         const parentComment = replyBtn.closest('.comment-item');
                         const form = parentComment.querySelector('.reply-form');
                         
                         // Toggle form yang diklik
                         const isFormVisible = form.style.display === 'block';
                         
                         // Tutup semua form lain dulu
                         document.querySelectorAll('.reply-form').forEach(f => f.style.display = 'none');
                         document.querySelectorAll('.btn-reply').forEach(b => {
                            b.innerHTML = '<i class="fas fa-reply"></i> Balas';
                            b.classList.remove('btn-secondary');
                         });

                         if (!isFormVisible) {
                            form.style.display = 'block';
                            form.querySelector('textarea').focus();
                            replyBtn.innerHTML = '<i class="fas fa-times"></i> Batal';
                            replyBtn.classList.add('btn-secondary');
                         }
                    }

                    if (cancelBtn) {
                        e.preventDefault();
                        e.stopPropagation();
                        const form = cancelBtn.closest('.reply-form');
                        const parentComment = cancelBtn.closest('.comment-item');
                        const replyBtn = parentComment.querySelector('.btn-reply');

                        form.style.display = 'none';
                        if (replyBtn) {
                            replyBtn.innerHTML = '<i class="fas fa-reply"></i> Balas';
                            replyBtn.classList.remove('btn-secondary');
                        }
                    }
                });
                
                // Submit reply form
                container.addEventListener('submit', function(e){
                    const form = e.target.closest('.reply-form');
                    if(!form) return;

                    e.preventDefault();
                    e.stopPropagation();

                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                           'X-Requested-With': 'XMLHttpRequest',
                           'X-CSRF-TOKEN': csrfToken,
                           'Accept': 'application/json',
                        },
                        body: new FormData(form)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success && data.new_comment_html){
                            const parentComment = form.closest('.comment-item');
                            let repliesContainer = parentComment.querySelector('.comment-replies');
                            if (!repliesContainer) {
                                repliesContainer = document.createElement('div');
                                repliesContainer.className = 'comment-replies';
                                parentComment.appendChild(repliesContainer);
                            }
                            repliesContainer.insertAdjacentHTML('beforeend', data.new_comment_html);
                            
                            // Update total comment count
                            const videoSlide = form.closest('.video-slide');
                            const countElement = videoSlide.querySelector('.comment-toggle .count');
                             if (countElement) {
                                countElement.textContent = parseInt(countElement.textContent) + 1;
                            }

                            // Hide form and reset button
                            form.style.display = 'none';
                            form.querySelector('textarea').value = '';
                            const replyBtn = parentComment.querySelector('.btn-reply');
                            if(replyBtn){
                                replyBtn.innerHTML = '<i class="fas fa-reply"></i> Balas';
                                replyBtn.classList.remove('btn-secondary');
                            }
                        } else {
                            alert(data.message || 'Gagal mengirim balasan.');
                        }
                    })
                    .catch(err => {
                        console.error('Reply submission error:', err);
                        alert('Terjadi kesalahan saat mengirim balasan.');
                    })
                    .finally(() => {
                         submitBtn.disabled = false;
                         submitBtn.innerHTML = originalText;
                    });
                });
            }

            initializeReplyButtons();

            console.log('TikTok-style video feed initialized.');
        });
    </script>
@endsection
