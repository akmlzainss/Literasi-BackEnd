@extends('layouts.siswa')

@section('title', 'Video Feed - SIPENA')
@section('meta')
    <meta name="description"
        content="Nikmati video dalam mode scroll ala TikTok di platform SIPENA. Tonton karya kreatif siswa dengan pengalaman interaktif.">
    <meta name="keywords" content="video TikTok, SIPENA, video siswa, scroll video">
@endsection
<link rel="stylesheet" href="{{ asset('css/tiktok.css') }}">

@section('additional_css')
    <style>
        /* TikTok-style flat comments */
        .comment-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .comment-item:last-child {
            border-bottom: none;
        }

        .comment-author {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .comment-author-info {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .comment-author-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .comment-author-avatar-img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        .reply-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            color: #6b7280;
            font-size: 0.85rem;
        }

        .reply-to-name {
            color: #3b82f6;
            font-weight: 500;
        }

        .comment-text {
            margin: 0.25rem 0;
            font-size: 0.9rem;
            padding-left: 2.25rem;
        }

        .comment-meta {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-left: 2.25rem;
            font-size: 0.8rem;
            color: #6b7280;
        }

        .btn-reply-video,
        .btn-delete-video-comment {
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
            transition: color 0.2s;
        }

        .btn-reply-video:hover {
            color: #3b82f6;
        }

        .btn-delete-video-comment:hover {
            color: #ef4444;
        }

        .replying-to-video {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(59, 130, 246, 0.1);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }

        .cancel-reply-video {
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            padding: 0.25rem;
        }

        .comment-form .input-group {
            display: flex;
            gap: 0.5rem;
        }

        .comment-form .form-control {
            flex: 1;
            border-radius: 20px;
            padding: 0.5rem 1rem;
        }

        .comment-form .btn-primary {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
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

        .reply-item.hidden-reply {
            display: none;
        }

        .view-replies-wrapper {
            margin-top: 0.75rem;
            display: flex;
            justify-content: flex-start;
            gap: 1rem;
        }

        .btn-view-replies,
        .btn-hide-replies {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-view-replies .line,
        .btn-hide-replies .line {
            width: 20px;
            height: 1px;
            background-color: #d1d5db;
        }

        .btn-view-replies:hover,
        .btn-hide-replies:hover {
            color: #1f2937;
        }

        .hide-button {
            display: none !important;
        }

        @keyframes reveal {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reveal-reply {
            animation: reveal 0.4s ease forwards;
        }

        /* CSS untuk tombol dan progress bar waktu */
        .btn-action {
            font-size: 0.875rem;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            opacity: 0.7;
        }

        .btn-action:hover {
            opacity: 1;
            transform: scale(1.1);
        }

        .btn-action.active {
            opacity: 1;
        }

        .btn-action .count {
            display: none;
        }

        /* Tombol unmute di kanan atas, ukuran kecil */
        .mute-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 0.3rem;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
        }

        .mute-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .mute-btn.active {
            background: #3b82f6;
        }

        /* Tombol play/pause di sebelah kiri progress bar */
        .play-pause-btn {
            position: absolute;
            bottom: 20px;
            left: 10px;
            padding: 0.5rem;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
        }

        .play-pause-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .play-pause-btn.active {
            background: #3b82f6;
        }

        /* Progress bar waktu di tengah, selalu tampil, warna putih */
        .video-progress-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            max-width: 300px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 20px;
            padding: 4px;
            display: block;
            /* Selalu tampil di awal */
            z-index: 10;
        }

        .video-progress-bar-custom {
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.5);
            /* Warna putih transparan */
            border-radius: 2px;
            overflow: hidden;
            position: relative;
        }

        .video-progress-fill {
            height: 100%;
            background: #ffffff;
            /* Warna putih untuk garis berjalan */
            border-radius: 2px;
            width: 0%;
            transition: width 0.1s linear;
        }

        .video-time-display {
            display: flex;
            justify-content: space-between;
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 4px;
            padding: 0 8px;
        }

        .video-time-current {
            color: #ffffff;
            /* Warna putih untuk waktu saat ini */
        }

        /* Fix mobile comment section */
        @media (max-width: 768px) {
            .comment-section {
                position: fixed !important;
                bottom: 0;
                left: 0;
                right: 0;
                max-height: 70vh;
                z-index: 1000;
                background: white;
                border-radius: 20px 20px 0 0;
                transform: translateY(100%);
                transition: transform 0.3s ease;
                overflow-y: auto;
            }

            .comment-section.active {
                transform: translateY(0);
            }

            .comment-section::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: -1;
            }

            .close-comments {
                position: sticky;
                top: 0;
                background: white;
                z-index: 10;
            }

            .video-progress-container {
                width: 90%;
            }

            .mute-btn {
                top: 5px;
                right: 5px;
                padding: 0.25rem;
            }

            .play-pause-btn {
                bottom: 20px;
                left: 5px;
                padding: 0.4rem;
            }
        }

        /* Pastikan tombol interaction selalu visible saat hover/focus */
        .interaction-buttons {
            pointer-events: auto;
        }

        .interaction-buttons button {
            pointer-events: auto;
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
                <div class="video-progress">
                    <div class="video-progress-bar"></div>
                </div>
                <video class="video-player" loop playsinline preload="metadata"
                    aria-label="Video berjudul {{ $video->judul }}">
                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>

                <!-- Progress bar waktu di tengah -->
                <div class="video-progress-container" id="progress-container-{{ $video->id }}">
                    <div class="video-progress-bar-custom">
                        <div class="video-progress-fill" id="progress-fill-{{ $video->id }}"></div>
                    </div>
                    <div class="video-time-display">
                        <span class="video-time-current" id="time-current-{{ $video->id }}">00:00</span>
                        <span id="time-duration-{{ $video->id }}">00:00</span>
                    </div>
                </div>

                <div class="video-overlay">
                    <div class="video-info">
                        <div class="video-author">
                            <span class="author-avatar">{{ Str::substr($video->siswa->nama ?? 'A', 0, 1) }}</span>
                            <span>{{ $video->siswa->nama ?? 'Admin' }}</span>
                        </div>
                        <h5 class="video-title">{{ $video->judul }}</h5>
                        <div class="video-stats">
                            <span><i class="fas fa-eye"></i> {{ $video->jumlah_dilihat ?? 0 }}</span>
                            <span><i class="fas fa-calendar"></i> {{ $video->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <div class="interaction-buttons">
                    <button
                        class="btn-action like-btn {{ Auth::guard('siswa')->check() &&$video->interaksi()->where('id_siswa', Auth::guard('siswa')->id())->where('jenis', 'suka')->exists()? 'active': '' }}"
                        data-action="suka" data-id="{{ $video->id }}" title="Suka video ini">
                        <i class="fas fa-heart"></i>
                        <span class="count">{{ $video->interaksi()->where('jenis', 'suka')->count() }}</span>
                    </button>
                    <button
                        class="btn-action bookmark-btn {{ Auth::guard('siswa')->check() &&$video->interaksi()->where('id_siswa', Auth::guard('siswa')->id())->where('jenis', 'bookmark')->exists()? 'active': '' }}"
                        data-action="bookmark" data-id="{{ $video->id }}" title="Simpan video">
                        <i class="fas fa-bookmark"></i>
                        <span class="count">{{ $video->interaksi()->where('jenis', 'bookmark')->count() }}</span>
                    </button>
                    <button class="btn-action comment-btn comment-toggle" data-id="{{ $video->id }}"
                        title="Lihat komentar">
                        <i class="fas fa-comment"></i>
                        <span class="count">{{ $video->komentar()->count() }}</span>
                    </button>
                </div>

                <!-- Tombol unmute di kanan atas -->
                <button class="btn-action mute-btn" data-id="{{ $video->id }}" title="Nonaktifkan/Aktifkan suara">
                    <i class="fas fa-volume-up"></i>
                </button>

                <!-- Tombol play/pause di sebelah kiri progress bar -->
                <button class="btn-action play-pause-btn" data-id="{{ $video->id }}" title="Putar/Jeda video">
                    <i class="fas fa-play"></i>
                </button>

                <!-- Comment section (TikTok-style flat) -->
                <div class="comment-section" id="comment-section-{{ $video->id }}">
                    <div class="comment-header">
                        <h5><i class="fas fa-comments me-2"></i>Komentar</h5>
                        <button class="close-comments" data-video-id="{{ $video->id }}" aria-label="Tutup komentar"><i
                                class="fas fa-times"></i></button>
                    </div>
                    <div class="comment-list" id="comment-list-{{ $video->id }}">
                        {{-- TikTok-style: Load ALL comments flat --}}
                        @php
                            $allKomentar = $video->komentar()->with(['siswa', 'admin', 'parent.siswa', 'parent.admin'])->latest()->get();
                        @endphp
                        @forelse($allKomentar as $komentar)
                            @php
                                $komentarAuthorName = $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'U');
                                $komentarAuthorPhoto = $komentar->siswa->foto_profil ?? null;
                            @endphp
                            <div class="comment-item" data-comment-id="{{ $komentar->id }}">
                                <div class="comment-author">
                                    @if($komentarAuthorPhoto)
                                        <img src="{{ asset('storage/' . $komentarAuthorPhoto) }}" alt="{{ $komentarAuthorName }}" class="comment-author-avatar-img">
                                    @else
                                        <span class="comment-author-avatar">{{ Str::substr($komentarAuthorName, 0, 1) }}</span>
                                    @endif
                                    <div class="comment-author-info">
                                        <span class="comment-author-name">{{ $komentarAuthorName }}</span>
                                        {{-- TikTok-style: Show "replying to @username" --}}
                                        @if ($komentar->id_komentar_parent && $komentar->parent)
                                            <span class="reply-indicator">
                                                <i class="fas fa-caret-right"></i>
                                                <span class="reply-to-name">@{{ $komentar->parent->siswa->nama ?? ($komentar->parent->admin->nama ?? 'User') }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <p class="comment-text">{{ $komentar->komentar }}</p>
                                <div class="comment-meta">
                                    <span>{{ $komentar->created_at->diffForHumans() }}</span>
                                    @auth('siswa')
                                        <button class="btn-reply-video" data-id="{{ $komentar->id }}" data-name="{{ $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'User') }}" data-video-id="{{ $video->id }}">
                                            <i class="fas fa-reply"></i>
                                        </button>
                                        @if ((Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id()) || Auth::guard('admin')->check())
                                            <button class="btn-delete-video-comment" data-id="{{ $komentar->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <div class="empty-comments">
                                <i class="fas fa-comment-slash"></i>
                                <p>Belum ada komentar. Jadilah yang pertama!</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Floating comment form (TikTok-style) --}}
                    <div class="comment-form">
                        @auth('siswa')
                            <div class="replying-to-video" id="replying-to-{{ $video->id }}" style="display: none;">
                                <span><i class="fas fa-reply"></i> Membalas <strong id="replying-name-{{ $video->id }}">@user</strong></span>
                                <button type="button" class="cancel-reply-video" data-video-id="{{ $video->id }}"><i class="fas fa-times"></i></button>
                            </div>
                            <form class="form-comment" data-id="{{ $video->id }}">
                                @csrf
                                <input type="hidden" name="id_komentar_parent" id="parent-id-{{ $video->id }}" value="">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="komentar" id="komentar-input-{{ $video->id }}" placeholder="Tulis komentar..." required>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
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
    <!-- Modal Konfirmasi Hapus Komentar -->
    <div class="modal fade" id="deleteCommentModal" tabindex="-1" aria-labelledby="deleteCommentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteCommentModalLabel"><i
                            class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah kamu yakin ingin menghapus komentar ini? Tindakan ini tidak bisa dibatalkan.</p>
                    <input type="hidden" id="deleteCommentId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn"><i
                            class="fas fa-trash me-1"></i> Hapus</button>
                </div>
            </div>
        </div>
    </div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('tiktok-container');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

            if (!csrfToken) {
                console.error(
                    'CSRF token not found! Add <meta name="csrf-token" content="{{ csrf_token() }}"> to your layout.'
                    );
            }

            // Fungsi format waktu
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }

            // Intersection Observer untuk auto-play video (tidak trigger komentar)
            const videos = document.querySelectorAll('.video-player');
            let currentVideo = null;
            let currentVideoId = null;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const video = entry.target;
                    const videoSlide = video.closest('.video-slide');
                    const videoId = videoSlide.dataset.videoId;
                    const progressBar = videoSlide.querySelector('.video-progress-bar');

                    if (entry.isIntersecting && parseFloat(entry.intersectionRatio) > 0.7) {
                        if (currentVideoId !== videoId) {
                            if (currentVideo && currentVideo !== video) {
                                currentVideo.pause();
                                currentVideo.currentTime = 0;
                            }
                            video.play().catch(e => console.log('Autoplay prevented:', e));
                            currentVideo = video;
                            currentVideoId = videoId;
                        }

                        const timeupdateHandler = () => {
                            const progress = (video.currentTime / video.duration) * 100;
                            progressBar.style.width = `${progress}%`;
                        };
                        video.addEventListener('timeupdate', timeupdateHandler);

                        const cleanup = () => {
                            video.removeEventListener('timeupdate', timeupdateHandler);
                            observer.unobserve(video);
                        };
                        video.addEventListener('pause', cleanup, {
                            once: true
                        });
                    } else if (!entry.isIntersecting) {
                        video.pause();
                        progressBar.style.width = '0%';
                    }
                });
            }, {
                threshold: [0.7, 0.8, 0.9]
            });

            videos.forEach(video => {
                observer.observe(video);

                video.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const videoSlide = this.closest('.video-slide');
                    const videoId = videoSlide.dataset.videoId;

                    if (this.paused) {
                        this.play().catch(e => console.log('Play prevented:', e));
                    } else {
                        this.pause();
                    }
                });

                const videoId = video.closest('.video-slide').dataset.videoId;
                const progressContainer = document.getElementById(`progress-container-${videoId}`);
                const progressFill = document.getElementById(`progress-fill-${videoId}`);
                const timeCurrent = document.getElementById(`time-current-${videoId}`);
                const timeDuration = document.getElementById(`time-duration-${videoId}`);
                const playPauseBtn = document.querySelector(`.play-pause-btn[data-id="${videoId}"]`);
                const muteBtn = document.querySelector(`.mute-btn[data-id="${videoId}"]`);

                video.addEventListener('loadedmetadata', () => {
                    timeDuration.textContent = formatTime(video.duration);
                });

                video.addEventListener('timeupdate', () => {
                    const progress = (video.currentTime / video.duration) * 100;
                    if (progressFill) {
                        progressFill.style.width = `${progress}%`;
                    }
                    if (timeCurrent) {
                        timeCurrent.textContent = formatTime(video.currentTime);
                    }
                });

                if (playPauseBtn) {
                    playPauseBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const icon = playPauseBtn.querySelector('i');
                        if (video.paused) {
                            video.play().catch(e => console.log('Play prevented:', e));
                            icon.classList.remove('fa-play');
                            icon.classList.add('fa-pause');
                            playPauseBtn.classList.add('active');
                        } else {
                            video.pause();
                            icon.classList.remove('fa-pause');
                            icon.classList.add('fa-play');
                            playPauseBtn.classList.remove('active');
                        }
                    });
                }

                if (muteBtn) {
                    muteBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const icon = muteBtn.querySelector('i');
                        video.muted = !video.muted;
                        if (video.muted) {
                            icon.classList.remove('fa-volume-up');
                            icon.classList.add('fa-volume-mute');
                            muteBtn.classList.add('active');
                        } else {
                            icon.classList.remove('fa-volume-mute');
                            icon.classList.add('fa-volume-up');
                            muteBtn.classList.remove('active');
                        }
                    });
                }

                video.addEventListener('play', () => {
                    if (playPauseBtn) {
                        const icon = playPauseBtn.querySelector('i');
                        icon.classList.remove('fa-play');
                        icon.classList.add('fa-pause');
                        playPauseBtn.classList.add('active');
                    }
                });
                video.addEventListener('pause', () => {
                    if (playPauseBtn) {
                        const icon = playPauseBtn.querySelector('i');
                        icon.classList.remove('fa-pause');
                        icon.classList.add('fa-play');
                        playPauseBtn.classList.remove('active');
                    }
                });
            });

            document.querySelectorAll('.btn-action[data-action]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    fetch(`/video/${this.dataset.id}/interaksi`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                jenis: this.dataset.action
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.querySelector('.count').textContent = data.count;
                                this.classList.toggle('active', data.action === 'added');
                            } else {
                                alert(data.error || 'Silakan login.');
                            }
                        })
                        .catch(err => console.error(err));
                });
            });

            document.querySelectorAll('.comment-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const videoId = this.dataset.id;
                    const commentSection = document.getElementById(`comment-section-${videoId}`);

                    document.querySelectorAll('.comment-section').forEach(section => {
                        if (section.id !== `comment-section-${videoId}`) {
                            section.classList.remove('active');
                        }
                    });

                    commentSection.classList.toggle('active');

                    const videoSlide = document.getElementById(`video-${videoId}`);
                    if (videoSlide) {
                        currentVideoId = videoId;
                    }
                });
            });

            document.addEventListener('click', function(e) {
                const closeBtn = e.target.closest('.close-comments');
                if (closeBtn) {
                    e.stopPropagation();
                    const videoId = closeBtn.dataset.videoId;
                    const commentSection = document.getElementById(`comment-section-${videoId}`);
                    if (commentSection) {
                        commentSection.classList.remove('active');
                    }
                }
            });

            document.addEventListener('click', function(e) {
                const commentSection = e.target.closest('.comment-section');
                const isOverlayClick = e.target.classList.contains('comment-section');
                if (isOverlayClick && commentSection) {
                    commentSection.classList.remove('active');
                }
            });

            document.querySelectorAll('.form-comment').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const videoId = this.dataset.id;
                    const komentarInput = document.getElementById(`komentar-input-${videoId}`);
                    const parentIdInput = document.getElementById(`parent-id-${videoId}`);
                    const replyingTo = document.getElementById(`replying-to-${videoId}`);
                    
                    if (!komentarInput || !komentarInput.value.trim()) return;
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                    const bodyData = {
                        komentar: komentarInput.value.trim()
                    };
                    if (parentIdInput && parentIdInput.value) {
                        bodyData.id_komentar_parent = parentIdInput.value;
                    }

                    fetch(`/video/${videoId}/komentar`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify(bodyData)
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                const commentList = document.getElementById(`comment-list-${videoId}`);
                                commentList.querySelector('.empty-comments')?.remove();
                                const avatar_char = data.komentar.nama.charAt(0);
                                
                                // Build reply indicator if this is a reply
                                const replyingName = document.getElementById(`replying-name-${videoId}`);
                                const replyIndicatorHtml = parentIdInput && parentIdInput.value && replyingName
                                    ? `<span class="reply-indicator"><i class="fas fa-caret-right"></i><span class="reply-to-name">${replyingName.textContent}</span></span>`
                                    : '';

                                const newCommentHtml = `
                                <div class="comment-item" data-comment-id="${data.komentar.id}">
                                    <div class="comment-author">
                                        <span class="comment-author-avatar">${avatar_char}</span>
                                        <div class="comment-author-info">
                                            <span class="comment-author-name">${data.komentar.nama}</span>
                                            ${replyIndicatorHtml}
                                        </div>
                                    </div>
                                    <p class="comment-text">${data.komentar.komentar}</p>
                                    <div class="comment-meta">
                                        <span>Baru saja</span>
                                        <button class="btn-reply-video" data-id="${data.komentar.id}" data-name="${data.komentar.nama}" data-video-id="${videoId}">
                                            <i class="fas fa-reply"></i>
                                        </button>
                                        <button class="btn-delete-video-comment" data-id="${data.komentar.id}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>`;
                                commentList.insertAdjacentHTML('afterbegin', newCommentHtml);
                                const countEl = document.querySelector(`.comment-toggle[data-id="${videoId}"] .count`);
                                if (countEl) {
                                    countEl.textContent = parseInt(countEl.textContent) + 1;
                                }
                                komentarInput.value = '';
                                
                                // Reset reply mode
                                if (parentIdInput) parentIdInput.value = '';
                                if (replyingTo) replyingTo.style.display = 'none';
                                komentarInput.placeholder = 'Tulis komentar...';
                            } else {
                                alert(data.message || 'Gagal mengirim komentar');
                            }
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                });
            });

            container.addEventListener('click', function(e) {
                const replyBtn = e.target.closest('.btn-reply-video');
                const cancelBtn = e.target.closest('.cancel-reply-video');
                const deleteBtn = e.target.closest('.btn-delete-video-comment');

                // TikTok-style reply handler
                if (replyBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    const commentId = replyBtn.dataset.id;
                    const userName = replyBtn.dataset.name;
                    const videoId = replyBtn.dataset.videoId;
                    
                    // Update form for reply
                    const parentIdInput = document.getElementById(`parent-id-${videoId}`);
                    const replyingTo = document.getElementById(`replying-to-${videoId}`);
                    const replyingName = document.getElementById(`replying-name-${videoId}`);
                    const komentarInput = document.getElementById(`komentar-input-${videoId}`);
                    
                    if (parentIdInput) parentIdInput.value = commentId;
                    if (replyingTo) replyingTo.style.display = 'flex';
                    if (replyingName) replyingName.textContent = '@' + userName;
                    if (komentarInput) {
                        komentarInput.placeholder = `Balas ke ${userName}...`;
                        komentarInput.focus();
                    }
                }

                // Cancel reply handler
                if (cancelBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    const videoId = cancelBtn.dataset.videoId;
                    const parentIdInput = document.getElementById(`parent-id-${videoId}`);
                    const replyingTo = document.getElementById(`replying-to-${videoId}`);
                    const komentarInput = document.getElementById(`komentar-input-${videoId}`);
                    
                    if (parentIdInput) parentIdInput.value = '';
                    if (replyingTo) replyingTo.style.display = 'none';
                    if (komentarInput) komentarInput.placeholder = 'Tulis komentar...';
                }

                // Delete button handler
                if (deleteBtn) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (confirm('Yakin ingin menghapus komentar ini?')) {
                        const commentId = deleteBtn.dataset.id;
                        fetch(`/video/komentar/${commentId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    const commentItem = deleteBtn.closest('.comment-item');
                                    const videoSlide = commentItem.closest('.video-slide');
                                    commentItem.remove();
                                    const countEl = videoSlide.querySelector('.comment-toggle .count');
                                    if (countEl) {
                                        countEl.textContent = Math.max(0, parseInt(countEl.textContent) - 1);
                                    }
                                } else {
                                    alert(data.message || 'Gagal menghapus komentar.');
                                }
                            })
                            .catch(error => console.error('Error saat menghapus:', error));
                    }
                }
            });


            let touchStartY = 0;
            document.addEventListener('touchstart', (e) => {
                if (e.target.closest('.comment-section.active')) {
                    touchStartY = e.touches[0].clientY;
                }
            }, {
                passive: true
            });

            document.addEventListener('touchmove', (e) => {
                if (touchStartY && e.touches[0].clientY - touchStartY > 50) {
                    document.querySelectorAll('.comment-section.active').forEach(section => {
                        section.classList.remove('active');
                    });
                    touchStartY = 0;
                }
            }, {
                passive: true
            });
        });
    </script>
@endsection
