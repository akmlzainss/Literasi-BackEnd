@extends('layouts.layouts')

@section('title', 'Video Feed - SIPENA')
@section('meta')
    <meta name="description" content="Nikmati video dalam mode scroll ala TikTok di platform SIPENA. Tonton karya kreatif siswa dengan pengalaman interaktif.">
    <meta name="keywords" content="video TikTok, SIPENA, video siswa, scroll video">
@endsection
<link rel="stylesheet" href="{{ asset('css/tiktok.css') }}">

@section('additional_css')
    <style>
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
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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
        .btn-view-replies, .btn-hide-replies {
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
        .btn-view-replies .line, .btn-hide-replies .line {
            width: 20px;
            height: 1px;
            background-color: #d1d5db;
        }
        .btn-view-replies:hover, .btn-hide-replies:hover {
            color: #1f2937;
        }
        .hide-button {
            display: none !important;
        }
        @keyframes reveal {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .reveal-reply {
            animation: reveal 0.4s ease forwards;
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
                                <!-- Reply Form -->
                                @auth('siswa')
                                    <form action="{{ route('video.komentar.store', $video->id) }}" method="POST" class="reply-form" data-parent-id="{{ $komentar->id }}" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="id_komentar_parent" value="{{ $komentar->id }}">
                                        <div class="input-group mb-2">
                                            <textarea class="form-control" name="komentar" placeholder="Tulis balasan..." rows="2" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Kirim Balasan</button>
                                        <button type="button" class="btn btn-secondary btn-sm btn-cancel-reply">Batal</button>
                                    </form>
                                @endauth
                                <!-- Replies -->
                                @php
                                    $replies = $komentar->replies;
                                    $replyCount = $replies->count();
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
                                <div class="input-group mb-2">
                                    <textarea class="form-control" name="komentar" placeholder="Tulis komentar..." rows="2" required></textarea>
                                </div>
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
    <!-- Modal Konfirmasi Hapus Komentar -->
<div class="modal fade" id="deleteCommentModal" tabindex="-1" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteCommentModalLabel"><i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Apakah kamu yakin ingin menghapus komentar ini? Tindakan ini tidak bisa dibatalkan.</p>
        <input type="hidden" id="deleteCommentId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn"><i class="fas fa-trash me-1"></i> Hapus</button>
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
                console.error('CSRF token not found! Add <meta name="csrf-token" content="{{ csrf_token() }}"> to your layout.');
            }

            // Intersection Observer untuk auto-play video
            const videos = document.querySelectorAll('.video-player');
            let currentVideo = null;
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const video = entry.target;
                    const progressBar = video.closest('.video-slide').querySelector('.video-progress-bar');
                    if (entry.isIntersecting) {
                        if (currentVideo && currentVideo !== video) {
                            currentVideo.pause();
                            currentVideo.currentTime = 0;
                        }
                        video.play().catch(e => console.log('Autoplay prevented:', e));
                        currentVideo = video;
                        video.addEventListener('timeupdate', () => {
                            const progress = (video.currentTime / video.duration) * 100;
                            progressBar.style.width = `${progress}%`;
                        });
                    } else {
                        video.pause();
                        progressBar.style.width = '0%';
                    }
                });
            }, { threshold: 0.5 });

            videos.forEach(video => {
                observer.observe(video);
                video.addEventListener('click', function() {
                    this.paused ? this.play() : this.pause();
                });
            });

            // Like/Bookmark interactions
            document.querySelectorAll('.btn-action[data-action]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    fetch(`/video/${this.dataset.id}/interaksi`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ jenis: this.dataset.action })
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

            // Toggle comment section
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

            // Close comments
            document.querySelectorAll('.close-comments').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    this.closest('.comment-section').classList.remove('active');
                });
            });

            // Submit main comment
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
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ komentar: textarea.value.trim() })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && !data.is_reply) {
                            const commentList = document.getElementById(`comment-list-${videoId}`);
                            commentList.querySelector('.empty-comments')?.remove();
                            const avatar_char = data.komentar.nama.charAt(0);
                            const newCommentHtml = `
                                <div class="comment-item" data-comment-id="${data.komentar.id}">
                                    <div class="comment-author">
                                        <span class="comment-author-avatar">${avatar_char}</span>
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
                                        <form action="/video/${videoId}/komentar" method="POST" class="reply-form" style="display: none;">
                                            <input type="hidden" name="_token" value="${csrfToken}">
                                            <input type="hidden" name="id_komentar_parent" value="${data.komentar.id}">
                                            <div class="input-group mb-2">
                                                <textarea class="form-control" name="komentar" placeholder="Tulis balasan..." rows="2" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">Kirim Balasan</button>
                                            <button type="button" class="btn btn-secondary btn-sm btn-cancel-reply">Batal</button>
                                        </form>
                                    </div>
                                </div>`;
                            commentList.insertAdjacentHTML('afterbegin', newCommentHtml);
                            const countEl = this.closest('.video-slide').querySelector('.comment-toggle .count');
                            countEl.textContent = parseInt(countEl.textContent) + 1;
                            textarea.value = '';
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

            // Event listener terpusat untuk aksi komentar
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
                    });
                    if (!isVisible) {
                        form.style.display = 'block';
                        form.querySelector('textarea').focus();
                        replyBtn.innerHTML = '<i class="fas fa-times"></i> Batal';
                        replyBtn.classList.add('btn-secondary');
                    }
                }

                if (cancelBtn) {
                    e.preventDefault();
                    const form = cancelBtn.closest('.reply-form');
                    form.style.display = 'none';
                    const replyBtn = form.closest('.comment-item').querySelector('.btn-reply');
                    if (replyBtn) {
                        replyBtn.innerHTML = '<i class="fas fa-reply"></i> Balas';
                        replyBtn.classList.remove('btn-secondary');
                    }
                }

               if (deleteBtn) {
    e.preventDefault();

    // Ambil ID komentar dan simpan di modal
    const commentId = deleteBtn.dataset.id;
    document.getElementById('deleteCommentId').value = commentId;

    // Simpan referensi elemen tombol hapus agar bisa digunakan nanti
    const commentItem = deleteBtn.closest('.comment-item');
    const videoSlide = deleteBtn.closest('.video-slide');

    // Tampilkan modal
    const modal = new bootstrap.Modal(document.getElementById('deleteCommentModal'));
    modal.show();

    // Event listener tombol konfirmasi
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    confirmBtn.onclick = () => {
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menghapus...';

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
                commentItem.remove();
                const countEl = videoSlide.querySelector('.comment-toggle .count');
                countEl.textContent = Math.max(0, parseInt(countEl.textContent) - 1);
                modal.hide();
            } else {
                alert(data.message || 'Gagal menghapus komentar.');
            }
        })
        .catch(error => console.error('Error saat menghapus:', error))
        .finally(() => {
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="fas fa-trash me-1"></i> Hapus';
        });
    };
}


                if (viewRepliesBtn) {
                    e.preventDefault();
                    const wrapper = viewRepliesBtn.closest('.view-replies-wrapper');
                    const container = viewRepliesBtn.closest('.comment-replies-container');
                    const hiddenReplies = container.querySelectorAll('.reply-item.hidden-reply');
                    const visibleThreshold = 3;
                    let shownReplies = 0;

                    for (let i = 0; i < hiddenReplies.length && shownReplies < visibleThreshold; i++) {
                        hiddenReplies[i].classList.remove('hidden-reply');
                        hiddenReplies[i].classList.add('reveal-reply');
                        hiddenReplies[i].style.animationDelay = `${shownReplies * 0.05}s`;
                        shownReplies++;
                    }

                    const remainingHiddenReplies = container.querySelectorAll('.reply-item.hidden-reply').length;
                    if (remainingHiddenReplies > 0) {
                        viewRepliesBtn.querySelector('span').nextSibling.textContent = `Lihat ${remainingHiddenReplies} balasan lainnya`;
                    } else {
                        viewRepliesBtn.classList.add('hide-button');
                    }
                    wrapper.querySelector('.btn-hide-replies').classList.remove('hide-button');
                }

                if (hideRepliesBtn) {
                    e.preventDefault();
                    const wrapper = hideRepliesBtn.closest('.view-replies-wrapper');
                    const container = hideRepliesBtn.closest('.comment-replies-container');
                    const allReplies = container.querySelectorAll('.reply-item');

                    allReplies.forEach(reply => {
                        reply.classList.add('hidden-reply');
                        reply.classList.remove('reveal-reply');
                    });

                    const totalReplies = allReplies.length;
                    wrapper.querySelector('.btn-view-replies').querySelector('span').nextSibling.textContent = `Lihat ${totalReplies} balasan`;
                    hideRepliesBtn.classList.add('hide-button');
                    wrapper.querySelector('.btn-view-replies').classList.remove('hide-button');
                }
            });

            // Submit reply form
            container.addEventListener('submit', function(e) {
                const form = e.target.closest('.reply-form');
                if (!form) return;
                e.preventDefault();

                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
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
                                    Sembunyikan
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
                        const wrapper = parentComment.querySelector('.view-replies-wrapper');
                        if (wrapper) {
                            const totalHiddenReplies = parentComment.querySelectorAll('.reply-item.hidden-reply').length;
                            wrapper.querySelector('.btn-view-replies').querySelector('span').nextSibling.textContent = `Lihat ${totalHiddenReplies} balasan`;
                        }
                    } else {
                        alert(data.message || 'Gagal mengirim balasan.');
                    }
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });
        });
    </script>
@endsection