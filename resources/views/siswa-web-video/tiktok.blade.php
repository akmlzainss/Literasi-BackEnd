@extends('layouts.layouts')

@section('title', 'Video Feed - SIPENA')
@section('meta')
    <meta name="description"
        content="Nikmati video dalam mode scroll ala TikTok di platform SIPENA. Tonton karya kreatif siswa dengan pengalaman interaktif.">
    <meta name="keywords" content="video TikTok, SIPENA, video siswa, scroll video">
@endsection
<link rel="stylesheet" href="{{ asset('css/tiktok.css') }}">
@section('additional_css')
@endsection

@section('content')
    <a href="{{ route('video.index') }}" class="back-button" aria-label="Kembali ke halaman utama">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="tiktok-container" id="tiktok-container">
        @forelse($videos as $video)
            <div class="video-slide" id="video-{{ $video->id }}" data-video-id="{{ $video->id }}">
                <!-- Video Progress Bar -->
                <div class="video-progress">
                    <div class="video-progress-bar"></div>
                </div>

                <!-- Loading Overlay -->
                <div class="loading-overlay" style="display: none;">
                    <div class="loading-spinner"></div>
                </div>

                <!-- Video Player -->
                <video class="video-player" loop muted playsinline preload="metadata"
                    aria-label="Video berjudul {{ $video->judul }}">
                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>

                <!-- Video Overlay -->
                <div class="video-overlay">
                    <div class="video-info">
                        <div class="video-author">
                            <span class="author-avatar">
                                {{ Str::substr($video->siswa->nama ?? 'A', 0, 1) }}
                            </span>
                            <span>{{ $video->siswa->nama ?? 'Admin' }}</span>
                        </div>
                        <h5 class="video-title">{{ $video->judul }}</h5>
                        <div class="video-stats">
                            <span>
                                <i class="fas fa-eye"></i>
                                {{ $video->jumlah_view ?? 0 }}
                            </span>
                            <span>
                                <i class="fas fa-calendar"></i>
                                {{ $video->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Interaction Buttons -->
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

                <!-- Comment Section -->
                <div class="comment-section" id="comment-section-{{ $video->id }}">
                    <div class="comment-header">
                        <h5><i class="fas fa-comments me-2"></i>Komentar</h5>
                        <button class="close-comments" aria-label="Tutup komentar">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="comment-list" id="comment-list-{{ $video->id }}">
                        @forelse($video->komentar()->whereNull('id_komentar_parent')->latest()->get() as $komentar)
                            <div class="comment-item" data-comment-id="{{ $komentar->id }}">
                                <div class="comment-author">
                                    <span class="comment-author-avatar">
                                        {{ Str::substr($komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'U'), 0, 1) }}
                                    </span>
                                    <span>{{ $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'Unknown') }}</span>
                                </div>
                                <p class="comment-text">{{ $komentar->komentar }}</p>
                                <div class="comment-meta">
                                    <span>{{ $komentar->created_at->diffForHumans() }}</span>
                                    @if (
                                        (Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id()) ||
                                            Auth::guard('admin')->check() ||
                                            Auth::guard('web')->check())
                                        <button class="delete-comment" data-id="{{ $komentar->id }}">Hapus</button>
                                    @endif
                                </div>
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
                                <div class="input-group mb-2">
                                    <textarea class="form-control" name="komentar" placeholder="Tulis komentar..." rows="2" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-submit w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Komentar
                                </button>
                            </form>
                        @else
                            <p class="text-muted">
                                <i class="fas fa-lock me-2"></i>
                                Login untuk menambahkan komentar.
                            </p>
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
            const videos = document.querySelectorAll('.video-player');
            let currentVideo = null;

            // Intersection Observer untuk auto-play video
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const video = entry.target;
                    const progressBar = video.closest('.video-slide').querySelector(
                        '.video-progress-bar');

                    if (entry.isIntersecting) {
                        // Pause previous video
                        if (currentVideo && currentVideo !== video) {
                            currentVideo.pause();
                            currentVideo.currentTime = 0;
                        }

                        // Play current video
                        video.play().catch(e => console.log('Autoplay prevented:', e));
                        currentVideo = video;

                        // Update progress bar
                        video.addEventListener('timeupdate', () => {
                            const progress = (video.currentTime / video.duration) * 100;
                            progressBar.style.width = progress + '%';
                        });
                    } else {
                        video.pause();
                        progressBar.style.width = '0%';
                    }
                });
            }, {
                threshold: 0.5
            });

            videos.forEach(video => {
                observer.observe(video);

                // Click to pause/play
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
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
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
                            console.error('Error:', error);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        });
                });
            });

            // Toggle comment section
            document.querySelectorAll('.comment-toggle').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const videoId = this.dataset.id;
                    const commentSection = document.getElementById(`comment-section-${videoId}`);

                    // Close other open comment sections
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
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';

                    fetch(`/video/${videoId}/komentar`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
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

                                // Remove empty state if exists
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
                            <button class="delete-comment" data-id="${data.komentar.id}">Hapus</button>
                        </div>
                    `;
                                commentList.insertBefore(commentItem, commentList.firstChild);

                                // Update comment count
                                const countElement = this.closest('.video-slide').querySelector(
                                    '.comment-toggle .count');
                                countElement.textContent = parseInt(countElement.textContent) +
                                    1;

                                // Clear textarea
                                textarea.value = '';
                            } else {
                                alert(data.error || 'Gagal mengirim komentar');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                });
            });

            // Delete comment
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-comment') || e.target.closest('.delete-comment')) {
                    const button = e.target.closest('.delete-comment');
                    const commentId = button.dataset.id;

                    if (!confirm('Yakin ingin menghapus komentar ini?')) return;

                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                    fetch(`/video/komentar/${commentId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const commentItem = button.closest('.comment-item');
                                const videoSlide = commentItem.closest('.video-slide');

                                // Animate and remove
                                commentItem.style.opacity = '0';
                                commentItem.style.transform = 'translateX(20px)';
                                setTimeout(() => commentItem.remove(), 300);

                                // Update comment count
                                const countElement = videoSlide.querySelector('.comment-toggle .count');
                                const newCount = parseInt(countElement.textContent) - 1;
                                countElement.textContent = newCount;

                                // Show empty state if no comments left
                                const commentList = commentItem.closest('.comment-list');
                                setTimeout(() => {
                                    if (commentList.querySelectorAll('.comment-item').length ===
                                        0) {
                                        commentList.innerHTML = `
                                <div class="empty-comments">
                                    <i class="fas fa-comment-slash"></i>
                                    <p>Belum ada komentar. Jadilah yang pertama!</p>
                                </div>
                            `;
                                    }
                                }, 350);
                            } else {
                                alert(data.error || 'Gagal menghapus komentar');
                                button.disabled = false;
                                button.textContent = 'Hapus';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                            button.disabled = false;
                            button.textContent = 'Hapus';
                        });
                }
            });

            // Prevent comment section from closing when clicking inside
            document.querySelectorAll('.comment-section').forEach(section => {
                section.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });

            // Close comment section when clicking outside
            container.addEventListener('click', function(e) {
                if (!e.target.closest('.comment-section') && !e.target.closest('.comment-toggle')) {
                    document.querySelectorAll('.comment-section.active').forEach(section => {
                        section.classList.remove('active');
                    });
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                // Close comment section with Escape key
                if (e.key === 'Escape') {
                    document.querySelectorAll('.comment-section.active').forEach(section => {
                        section.classList.remove('active');
                    });
                }

                // Navigate videos with arrow keys
                if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    const slides = Array.from(document.querySelectorAll('.video-slide'));
                    const currentIndex = slides.findIndex(slide => {
                        const rect = slide.getBoundingClientRect();
                        return rect.top >= 0 && rect.top < window.innerHeight / 2;
                    });

                    if (e.key === 'ArrowDown' && currentIndex < slides.length - 1) {
                        slides[currentIndex + 1].scrollIntoView({
                            behavior: 'smooth'
                        });
                    } else if (e.key === 'ArrowUp' && currentIndex > 0) {
                        slides[currentIndex - 1].scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });

            // Performance optimization: Lazy load videos
            const videoObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const video = entry.target;
                    if (entry.isIntersecting && !video.src) {
                        const source = video.querySelector('source');
                        if (source && source.dataset.src) {
                            source.src = source.dataset.src;
                            video.load();
                        }
                    }
                });
            }, {
                rootMargin: '100px'
            });

            videos.forEach(video => {
                videoObserver.observe(video);
            });

            // Add smooth scroll behavior
            container.style.scrollBehavior = 'smooth';

            // Prevent video controls on mobile
            videos.forEach(video => {
                video.setAttribute('playsinline', '');
                video.setAttribute('webkit-playsinline', '');
            });

            console.log('TikTok-style video feed initialized with', videos.length, 'videos');
        });

        // Service Worker for offline support (optional)
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {
                    console.log('Service Worker registration failed');
                });
            });
        }
    </script>
@endsection
