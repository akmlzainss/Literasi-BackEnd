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

        /* Button "Lihat balasan" untuk video comments */
        .btn-lihat-balasan-video {
            background: none;
            border: none;
            color: #8e8e8e;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            padding: 0.5rem 0;
            padding-left: 2.25rem;
            display: block;
        }
        .btn-lihat-balasan-video:hover {
            color: #262626;
        }

        /* Container balasan video */
        .video-replies-container {
            margin-left: 1.5rem;
            padding-left: 0.75rem;
            border-left: 2px solid #e5e7eb;
            margin-top: 0.5rem;
        }
        .video-replies-container .comment-item {
            padding: 0.5rem 0;
        }
        .video-replies-container .comment-author-avatar,
        .video-replies-container .comment-author-avatar-img {
            width: 26px !important;
            height: 26px !important;
            font-size: 0.7rem;
        }
        .video-replies-container .comment-text {
            padding-left: 2rem;
            font-size: 0.85rem;
        }
        .video-replies-container .comment-meta {
            padding-left: 2rem;
            font-size: 0.75rem;
        }

        /* Mention tag (@username) styling */
        .mention-tag {
            color: #3b82f6;
            font-weight: 500;
            margin-right: 0.25rem;
        }

        /* Toast Animation */
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateX(-50%) translateY(20px); }
            15% { opacity: 1; transform: translateX(-50%) translateY(0); }
            85% { opacity: 1; transform: translateX(-50%) translateY(0); }
            100% { opacity: 0; transform: translateX(-50%) translateY(-10px); }
        }
    </style>
@endsection

@section('content')
    {{-- Mobile back button --}}
    <button onclick="history.back()" class="back-button d-lg-none" aria-label="Kembali ke halaman utama">
        <i class="fas fa-arrow-left"></i>
    </button>

    {{-- Desktop close button (X) --}}
    <button onclick="history.back()" class="close-modal d-none d-lg-flex" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>

    {{-- Desktop navigation arrows --}}
    <button class="nav-arrow prev d-none d-lg-flex" id="prevVideo" aria-label="Video sebelumnya">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="nav-arrow next d-none d-lg-flex" id="nextVideo" aria-label="Video selanjutnya">
        <i class="fas fa-chevron-right"></i>
    </button>

    <div class="tiktok-container" id="tiktok-container">
        @forelse($videos as $video)
            <div class="video-slide" id="video-{{ $video->id }}" data-video-id="{{ $video->id }}">
                <div class="video-progress">
                    <div class="video-progress-bar"></div>
                </div>
                
                {{-- Video wrapper for positioning mute button --}}
                <div class="video-wrapper">
                    <video class="video-player" loop playsinline preload="metadata"
                        aria-label="Video berjudul {{ $video->judul }}">
                        <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
                    
                    <!-- Volume/Mute button - inside video wrapper -->
                    <button class="mute-btn" data-id="{{ $video->id }}" title="Nonaktifkan suara" style="position: absolute; bottom: 16px; right: 16px; top: auto; left: auto;">
                        <i class="fas fa-volume-high"></i>
                    </button>
                </div>



                <div class="video-overlay">
                    <div class="video-info">
                        <div class="video-author">
                            @if($video->siswa && $video->siswa->foto_profil)
                                <img src="{{ asset('storage/' . $video->siswa->foto_profil) }}" alt="{{ $video->siswa->nama }}" class="author-avatar-img">
                            @else
                                <span class="author-avatar">{{ Str::substr($video->siswa->nama ?? 'A', 0, 1) }}</span>
                            @endif
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
                    {{-- Like Button --}}
                    <button
                        class="btn-action like-btn {{ Auth::guard('siswa')->check() &&$video->interaksi()->where('id_siswa', Auth::guard('siswa')->id())->where('jenis', 'suka')->exists()? 'active': '' }}"
                        data-action="suka" data-id="{{ $video->id }}" title="Suka video ini">
                        <i class="fas fa-heart"></i>
                        <span class="count">{{ $video->interaksi()->where('jenis', 'suka')->count() }}</span>
                    </button>
                    
                    {{-- Comment Button --}}
                    <button class="btn-action comment-btn comment-toggle" data-id="{{ $video->id }}"
                        title="Lihat komentar">
                        <i class="fas fa-comment"></i>
                        <span class="count">{{ $video->komentar()->count() }}</span>
                    </button>
                    
                    {{-- Bookmark Button --}}
                    <button
                        class="btn-action bookmark-btn {{ Auth::guard('siswa')->check() &&$video->interaksi()->where('id_siswa', Auth::guard('siswa')->id())->where('jenis', 'bookmark')->exists()? 'active': '' }}"
                        data-action="bookmark" data-id="{{ $video->id }}" title="Simpan video">
                        <i class="fas fa-bookmark"></i>
                        <span class="count">{{ $video->interaksi()->where('jenis', 'bookmark')->count() }}</span>
                    </button>
                </div>



                <!-- Comment section - Instagram Style -->
                <div class="comment-section desktop-active" id="comment-section-{{ $video->id }}">
                    {{-- Mobile Header --}}
                    <div class="comment-header d-lg-none">
                        <h5><i class="fas fa-comments me-2"></i>Komentar</h5>
                        <button class="close-comments" data-video-id="{{ $video->id }}" aria-label="Tutup komentar">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    {{-- Desktop: Account Info --}}
                    <div class="ig-account-info d-none d-lg-flex">
                        @if($video->siswa && $video->siswa->foto_profil)
                            <img src="{{ asset('storage/' . $video->siswa->foto_profil) }}" alt="{{ $video->siswa->nama }}" class="ig-account-avatar-img">
                        @else
                            <span class="ig-account-avatar">{{ Str::substr($video->siswa->nama ?? 'A', 0, 1) }}</span>
                        @endif
                        <div>
                            <span class="ig-account-name">{{ $video->siswa->nama ?? 'Admin' }}</span>
                        </div>
                        {{-- Audio asli hidden --}}
                    </div>

                    {{-- Desktop: Caption --}}
                    <div class="ig-caption-section d-none d-lg-block">
                        <div class="ig-caption">
                            <span class="username">{{ $video->siswa->nama ?? 'Admin' }}</span>
                            {{ $video->judul }}
                            @if($video->deskripsi)
                                <br><span class="description">{{ Str::limit($video->deskripsi, 500) }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Comment List --}}
                    <div class="comment-list" id="comment-list-{{ $video->id }}">
                        @php
                            // Hanya ambil komentar PARENT (bukan balasan)
                            $parentKomentar = $video->komentar()
                                ->whereNull('id_komentar_parent')
                                ->with(['siswa', 'admin', 'replies.siswa', 'replies.admin'])
                                ->latest()
                                ->get();
                        @endphp
                        @forelse($parentKomentar as $komentar)
                            @php
                                $komentarAuthorName = $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'U');
                                $komentarAuthorPhoto = $komentar->siswa->foto_profil ?? null;
                                $replies = $komentar->replies ?? collect();
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
                                    </div>
                                </div>
                                <p class="comment-text">{{ $komentar->komentar }}</p>
                                <div class="comment-meta">
                                    <span>{{ $komentar->created_at->diffForHumans() }}</span>
                                    @auth('siswa')
                                        <button class="btn-reply-video" data-id="{{ $komentar->id }}" data-name="{{ $komentarAuthorName }}" data-video-id="{{ $video->id }}">
                                            Balas
                                        </button>
                                        @if ((Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id()) || Auth::guard('admin')->check())
                                            <button class="btn-delete-video-comment" data-id="{{ $komentar->id }}">
                                                Hapus
                                            </button>
                                        @endif
                                    @endauth
                                </div>

                                {{-- REPLIES SECTION --}}
                                @if($replies->count() > 0)
                                    <button class="btn-lihat-balasan-video" data-target="replies-{{ $komentar->id }}">
                                        — Lihat {{ $replies->count() }} balasan
                                    </button>
                                    <div class="video-replies-container" id="replies-{{ $komentar->id }}" style="display: none;">
                                        @foreach($replies as $reply)
                                            @php
                                                $replyAuthorName = $reply->siswa ? $reply->siswa->nama : ($reply->admin ? $reply->admin->nama : 'U');
                                                $replyAuthorPhoto = $reply->siswa->foto_profil ?? null;
                                            @endphp
                                            <div class="comment-item reply-item" data-comment-id="{{ $reply->id }}">
                                                <div class="comment-author">
                                                    @if($replyAuthorPhoto)
                                                        <img src="{{ asset('storage/' . $replyAuthorPhoto) }}" alt="{{ $replyAuthorName }}" class="comment-author-avatar-img">
                                                    @else
                                                        <span class="comment-author-avatar">{{ Str::substr($replyAuthorName, 0, 1) }}</span>
                                                    @endif
                                                    <div class="comment-author-info">
                                                        <span class="comment-author-name">{{ $replyAuthorName }}</span>
                                                        <span class="mention-tag">{{ '@' . $komentarAuthorName }}</span>
                                                    </div>
                                                </div>
                                                <p class="comment-text">{{ $reply->komentar }}</p>
                                                <div class="comment-meta">
                                                    <span>{{ $reply->created_at->diffForHumans() }}</span>
                                                    @auth('siswa')
                                                        <button class="btn-reply-video" data-id="{{ $komentar->id }}" data-name="{{ $replyAuthorName }}" data-video-id="{{ $video->id }}">
                                                            Balas
                                                        </button>
                                                        @if ((Auth::guard('siswa')->check() && $reply->id_siswa == Auth::guard('siswa')->id()) || Auth::guard('admin')->check())
                                                            <button class="btn-delete-video-comment" data-id="{{ $reply->id }}">
                                                                Hapus
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
                            <div class="empty-comments text-center py-5">
                                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" alt="No Comments" style="width: 150px; opacity: 0.5;">
                                <p style="color: #6b7280; font-style: italic; margin-top: 1rem;">Belum ada komentar. Jadilah yang pertama!</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Desktop: Interaction Bar --}}
                    <div class="ig-interaction-bar d-none d-lg-block">
                        <div class="ig-interaction-icons">
                            <button class="like-btn {{ Auth::guard('siswa')->check() && $video->interaksi()->where('id_siswa', Auth::guard('siswa')->id())->where('jenis', 'suka')->exists() ? 'active' : '' }}" 
                                    data-action="suka" data-id="{{ $video->id }}">
                                <i class="far fa-heart"></i>
                            </button>
                            <button class="comment-focus-btn" data-id="{{ $video->id }}">
                                <i class="far fa-comment"></i>
                            </button>
                            <button class="share-btn" onclick="shareVideo('{{ $video->judul }}')">
                                <i class="fas fa-share-alt"></i>
                            </button>
                            <button class="bookmark-btn {{ Auth::guard('siswa')->check() && $video->interaksi()->where('id_siswa', Auth::guard('siswa')->id())->where('jenis', 'bookmark')->exists() ? 'active' : '' }}" 
                                    data-action="bookmark" data-id="{{ $video->id }}">
                                <i class="far fa-bookmark"></i>
                            </button>
                        </div>
                        <div class="ig-likes-count">{{ number_format($video->interaksi()->where('jenis', 'suka')->count()) }} suka</div>
                        @php
                            $daysDiff = $video->created_at->diffInDays(now());
                            if ($daysDiff == 0) {
                                $dateDisplay = 'Hari ini';
                            } elseif ($daysDiff == 1) {
                                $dateDisplay = '1 hari yang lalu';
                            } elseif ($daysDiff >= 2 && $daysDiff <= 6) {
                                $dateDisplay = $daysDiff . ' hari yang lalu';
                            } elseif ($daysDiff == 7) {
                                $dateDisplay = '1 minggu yang lalu';
                            } else {
                                $dateDisplay = $video->created_at->format('j F Y');
                            }
                        @endphp
                        <div class="ig-post-date">{{ $dateDisplay }}</div>
                    </div>

                    {{-- Comment Form --}}
                    <div class="comment-form">
                        @auth('siswa')
                            <div class="replying-to-video" id="replying-to-{{ $video->id }}" style="display: none;">
                                <span><i class="fas fa-reply"></i> Membalas <strong id="replying-name-{{ $video->id }}">@user</strong></span>
                                <button type="button" class="cancel-reply-video" data-video-id="{{ $video->id }}"><i class="fas fa-times"></i></button>
                            </div>
                            <form class="form-comment d-flex align-items-center gap-2" data-id="{{ $video->id }}">
                                @csrf
                                <input type="hidden" name="id_komentar_parent" id="parent-id-{{ $video->id }}" value="">
                                <input type="text" class="form-control" name="komentar" id="komentar-input-{{ $video->id }}" placeholder="Tambahkan komentar..." required>
                                <button type="submit" class="post-btn" style="background: none; border: none; color: #3b82f6; font-size: 1.2rem; padding: 0.5rem; cursor: pointer;"><i class="fas fa-paper-plane"></i></button>
                            </form>
                        @else
                            <p class="text-muted text-center py-2"><a href="{{ route('siswa.login') }}" class="text-decoration-none">Login</a> untuk menambahkan komentar</p>
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
        // --- SHARE VIDEO FUNCTION ---
        function shareVideo(title) {
            const url = window.location.href;
            
            // Coba Web Share API dulu (mobile)
            if (navigator.share) {
                navigator.share({ title, url }).catch(() => {
                    // Jika user cancel, tidak apa-apa
                });
            } else {
                // Fallback: Copy link ke clipboard
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Link berhasil disalin! 📋');
                }).catch(() => {
                    // Fallback untuk browser lama
                    prompt('Salin link video:', url);
                });
            }
        }
        
        // --- TOAST NOTIFICATION ---
        function showToast(message) {
            const toast = document.createElement('div');
            toast.innerText = message;
            toast.style.cssText = `
                position: fixed;
                bottom: 100px;
                left: 50%;
                transform: translateX(-50%);
                background: #333;
                color: white;
                padding: 12px 24px;
                border-radius: 25px;
                font-size: 0.9rem;
                z-index: 9999;
                animation: fadeInOut 2.5s ease;
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2500);
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('tiktok-container');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const videoSlides = document.querySelectorAll('.video-slide');
            const videos = document.querySelectorAll('.video-player');
            let currentIndex = 0;
            let currentVideo = null;
            
            // Find initial video from URL param
            const urlParams = new URLSearchParams(window.location.search);
            const startId = urlParams.get('start');
            if (startId) {
                videoSlides.forEach((slide, index) => {
                    if (slide.dataset.videoId === startId) {
                        currentIndex = index;
                    }
                });
            }

            // Desktop: Show only current video
            function showVideo(index) {
                if (index < 0 || index >= videoSlides.length) return;
                
                // Pause all videos
                videos.forEach(v => {
                    v.pause();
                    v.currentTime = 0;
                });
                
                // Hide all slides on desktop
                if (window.innerWidth >= 992) {
                    videoSlides.forEach((slide, i) => {
                        slide.style.display = i === index ? 'flex' : 'none';
                    });
                }
                
                currentIndex = index;
                const video = videoSlides[index].querySelector('.video-player');
                if (video) {
                    video.play().catch(e => console.log('Autoplay prevented:', e));
                    currentVideo = video;
                }
            }

            // Initial show
            if (window.innerWidth >= 992) {
                showVideo(currentIndex);
            }

            // Navigation arrows
            const prevBtn = document.getElementById('prevVideo');
            const nextBtn = document.getElementById('nextVideo');
            
            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    if (currentIndex > 0) {
                        showVideo(currentIndex - 1);
                    }
                });
            }
            
            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    if (currentIndex < videoSlides.length - 1) {
                        showVideo(currentIndex + 1);
                    }
                });
            }

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft' && currentIndex > 0) {
                    showVideo(currentIndex - 1);
                } else if (e.key === 'ArrowRight' && currentIndex < videoSlides.length - 1) {
                    showVideo(currentIndex + 1);
                } else if (e.key === 'Escape') {
                    history.back();
                }
            });

            // Mobile: Intersection Observer for scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const video = entry.target;
                    const videoSlide = video.closest('.video-slide');

                    if (entry.isIntersecting && entry.intersectionRatio > 0.7) {
                        if (currentVideo && currentVideo !== video) {
                            currentVideo.pause();
                            currentVideo.currentTime = 0;
                        }
                        video.play().catch(e => console.log('Autoplay prevented:', e));
                        currentVideo = video;
                    } else if (!entry.isIntersecting) {
                        video.pause();
                    }
                });
            }, {
                threshold: [0.7, 0.8, 0.9]
            });

            videos.forEach(video => {
                // Only use observer on mobile
                if (window.innerWidth < 992) {
                    observer.observe(video);
                }

                // Click to play/pause
                video.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (this.paused) {
                        this.play().catch(e => console.log('Play prevented:', e));
                    } else {
                        this.pause();
                    }
                });

                const videoId = video.closest('.video-slide').dataset.videoId;
                const muteBtn = document.querySelector(`.mute-btn[data-id="${videoId}"]`);

                // Set video unmuted by default
                video.muted = false;

                // Mute button
                if (muteBtn) {
                    muteBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const icon = muteBtn.querySelector('i');
                        video.muted = !video.muted;
                        if (video.muted) {
                            icon.classList.remove('fa-volume-high');
                            icon.classList.add('fa-volume-xmark');
                            muteBtn.classList.add('muted');
                        } else {
                            icon.classList.remove('fa-volume-xmark');
                            icon.classList.add('fa-volume-high');
                            muteBtn.classList.remove('muted');
                        }
                    });
                }
            });

            document.querySelectorAll('.btn-action[data-action]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                    // Optimistic UI: Update tampilan duluan sebelum request selesai
                    const isLike = this.dataset.action === 'suka';
                    const countSpan = this.querySelector('.count');
                    let currentCount = parseInt(countSpan.textContent.replace(/,/g, '') || '0');
                    const wasActive = this.classList.contains('active');
                    
                    // Toggle state visual
                    this.classList.toggle('active');
                    
                    // Update count sementara
                    if (wasActive) {
                        countSpan.textContent = Math.max(0, currentCount - 1);
                    } else {
                        countSpan.textContent = currentCount + 1;
                    }
                    
                    // Tambahkan animasi klik
                    this.style.transform = 'scale(1.2)';
                    setTimeout(() => this.style.transform = 'scale(1)', 200);

                    // Kirim request ke server
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
                                // Update dengan data akurat dari server (jaga-jaga mismatch)
                                countSpan.textContent = data.count;
                                // Sinkronkan state akhir
                                if (data.action === 'added') {
                                    this.classList.add('active');
                                } else {
                                    this.classList.remove('active');
                                }
                            } else {
                                // Revert jika gagal logic server
                                this.classList.toggle('active');
                                countSpan.textContent = currentCount; // Balikin count
                                alert(data.error || 'Silakan login.');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            // Revert jika error jaringan
                            this.classList.toggle('active');
                            countSpan.textContent = currentCount;
                        });
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

            // --- Toggle Lihat Balasan Video ---
            document.querySelectorAll('.btn-lihat-balasan-video').forEach(btn => {
                btn.addEventListener('click', function() {
                    const targetId = this.dataset.target;
                    const repliesContainer = document.getElementById(targetId);
                    
                    if (repliesContainer) {
                        const isHidden = repliesContainer.style.display === 'none';
                        repliesContainer.style.display = isHidden ? 'block' : 'none';
                        
                        // Update button text
                        const replyCount = repliesContainer.querySelectorAll('.comment-item').length;
                        this.textContent = isHidden 
                            ? `— Sembunyikan balasan` 
                            : `— Lihat ${replyCount} balasan`;
                    }
                });
            });
        });
    </script>
@endsection
