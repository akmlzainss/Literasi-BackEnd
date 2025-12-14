@extends('layouts.siswa')

@section('title', 'Profil Saya')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/profil.css') }}">
    <!-- Cover Profile -->
    <div class="profile-cover"></div>

    <!-- Profile Content -->
    <div class="container profile-container">
        <div class="profile-info-card">
            <!-- Avatar -->
            <div class="profile-avatar-wrapper">
                <img src="{{ $siswa->foto_profil ? asset('storage/' . $siswa->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama) . '&size=200&background=4285f4&color=fff' }}"
                    alt="Foto Profil" class="rounded-circle profile-avatar">
                <div class="edit-avatar-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil-fill"></i>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="text-center mt-4">
                <h1 class="profile-name">{{ $siswa->nama }}</h1>
                <p class="profile-class">{{ $siswa->kelas }} • {{ $siswa->email }}</p>
            </div>

            <!-- Stats -->
            <div class="stats-wrapper">
                <div class="stat-item">
                    <span class="stat-number">{{ $videoDisukai->count() + $artikelDisukai->count() }}</span>
                    <span class="stat-label">Disukai</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $videoDisimpan->count() + $artikelDisimpan->count() }}</span>
                    <span class="stat-label">Disimpan</span>
                </div>
                <div class="stat-item">
                    <span
                        class="stat-number">{{ $videoDisukai->count() + $videoDisimpan->count() + $artikelDisukai->count() + $artikelDisimpan->count() }}</span>
                    <span class="stat-label">Total Konten</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="btn btn-action" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil-square"></i> Edit Profil
                </button>
                <button class="btn btn-action" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="bi bi-shield-lock"></i> Ubah Password
                </button>
            </div>
        </div>

        <!-- Upload Section - Konten yang Diupload User -->
        <!-- Section ini dihapus karena sudah dipindah ke tab -->

        <!-- Content Tabs -->
        <div class="content-tabs">
            <ul class="nav nav-tabs nav-tabs-custom" id="profilTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="video-upload-tab" data-bs-toggle="tab"
                        data-bs-target="#video-upload" type="button" role="tab">
                        <i class="bi bi-camera-video-fill"></i>
                        <span class="tab-label">Video Saya</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="artikel-upload-tab" data-bs-toggle="tab" data-bs-target="#artikel-upload"
                        type="button" role="tab">
                        <i class="bi bi-journal-text"></i>
                        <span class="tab-label">Artikel Saya</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="video-like-tab" data-bs-toggle="tab" data-bs-target="#video-like"
                        type="button" role="tab">
                        <i class="bi bi-heart-fill"></i>
                        <span class="tab-label">Video Disukai</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="video-bookmark-tab" data-bs-toggle="tab" data-bs-target="#video-bookmark"
                        type="button" role="tab">
                        <i class="bi bi-bookmark-fill"></i>
                        <span class="tab-label">Video Disimpan</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="artikel-like-tab" data-bs-toggle="tab" data-bs-target="#artikel-like"
                        type="button" role="tab">
                        <i class="bi bi-heart-fill"></i>
                        <span class="tab-label">Artikel Disukai</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="artikel-bookmark-tab" data-bs-toggle="tab"
                        data-bs-target="#artikel-bookmark" type="button" role="tab">
                        <i class="bi bi-bookmark-fill"></i>
                        <span class="tab-label">Artikel Disimpan</span>
                    </button>
                </li>
            </ul>

            <div class="tab-content tab-content-wrapper">
                <!-- Video Saya (Upload) -->
                <div class="tab-pane fade show active" id="video-upload" role="tabpanel">
                    @if (isset($videoUpload) && $videoUpload->count() > 0)
                        <div class="content-grid">
                            @foreach ($videoUpload as $video)
                                <div class="content-card">
                                    <img src="{{ $video->thumbnail_path ? asset('storage/' . $video->thumbnail_path) : 'https://via.placeholder.com/300x400/4285f4/ffffff?text=Video' }}"
                                        class="content-thumbnail" alt="{{ $video->judul }}">
                                    <span class="content-badge">Video Saya</span>
                                    <div class="content-details">
                                        <h6 class="content-title">{{ $video->judul }}</h6>
                                        <p class="content-description">{{ Str::limit($video->deskripsi, 60) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-camera-video"></i>
                            <p>Belum ada video yang diupload</p>
                        </div>
                    @endif
                </div>

                <!-- Artikel Saya (Upload) -->
                <div class="tab-pane fade" id="artikel-upload" role="tabpanel">
                    @if (isset($artikelUpload) && $artikelUpload->count() > 0)
                        <div class="content-grid">
                            @foreach ($artikelUpload as $artikel)
                                <div class="content-card">
                                    <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://via.placeholder.com/300x400/1a73e8/ffffff?text=Artikel' }}"
                                        class="content-thumbnail" alt="{{ $artikel->judul }}">
                                    <span class="content-badge">Artikel Saya</span>
                                    <div class="content-details">
                                        <h6 class="content-title">{{ $artikel->judul }}</h6>
                                        <p class="content-description">{{ Str::limit(strip_tags($artikel->konten), 60) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-journal-text"></i>
                            <p>Belum ada artikel yang diupload</p>
                        </div>
                    @endif
                </div>

                <!-- Video Disukai -->
                <div class="tab-pane fade" id="video-like" role="tabpanel">
                    @if ($videoDisukai->count() > 0)
                        <div class="content-grid">
                            @foreach ($videoDisukai as $video)
                                <div class="content-card">
                                    <img src="{{ $video->thumbnail_path ? asset('storage/' . $video->thumbnail_path) : 'https://via.placeholder.com/300x400/4285f4/ffffff?text=Video' }}"
                                        class="content-thumbnail" alt="{{ $video->judul }}">
                                    <span class="content-badge">Video</span>
                                    <div class="content-details">
                                        <h6 class="content-title">{{ $video->judul }}</h6>
                                        <p class="content-description">{{ Str::limit($video->deskripsi, 60) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-heart"></i>
                            <p>Belum ada video yang disukai</p>
                        </div>
                    @endif
                </div>

                <!-- Video Disimpan -->
                <div class="tab-pane fade" id="video-bookmark" role="tabpanel">
                    @if ($videoDisimpan->count() > 0)
                        <div class="content-grid">
                            @foreach ($videoDisimpan as $video)
                                <div class="content-card">
                                    <img src="{{ $video->thumbnail_path ? asset('storage/' . $video->thumbnail_path) : 'https://via.placeholder.com/300x400/4285f4/ffffff?text=Video' }}"
                                        class="content-thumbnail" alt="{{ $video->judul }}">
                                    <span class="content-badge">Video</span>
                                    <div class="content-details">
                                        <h6 class="content-title">{{ $video->judul }}</h6>
                                        <p class="content-description">{{ Str::limit($video->deskripsi, 60) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-bookmark"></i>
                            <p>Belum ada video yang disimpan</p>
                        </div>
                    @endif
                </div>

                <!-- Artikel Disukai -->
                <div class="tab-pane fade" id="artikel-like" role="tabpanel">
                    @if ($artikelDisukai->count() > 0)
                        <div class="content-grid">
                            @foreach ($artikelDisukai as $artikel)
                                <div class="content-card">
                                    <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://via.placeholder.com/300x400/1a73e8/ffffff?text=Artikel' }}"
                                        class="content-thumbnail" alt="{{ $artikel->judul }}">
                                    <span class="content-badge">Artikel</span>
                                    <div class="content-details">
                                        <h6 class="content-title">{{ $artikel->judul }}</h6>
                                        <p class="content-description">{{ Str::limit(strip_tags($artikel->konten), 60) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-heart"></i>
                            <p>Belum ada artikel yang disukai</p>
                        </div>
                    @endif
                </div>

                <!-- Artikel Disimpan -->
                <div class="tab-pane fade" id="artikel-bookmark" role="tabpanel">
                    @if ($artikelDisimpan->count() > 0)
                        <div class="content-grid">
                            @foreach ($artikelDisimpan as $artikel)
                                <div class="content-card">
                                    <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : 'https://via.placeholder.com/300x400/1a73e8/ffffff?text=Artikel' }}"
                                        class="content-thumbnail" alt="{{ $artikel->judul }}">
                                    <span class="content-badge">Artikel</span>
                                    <div class="content-details">
                                        <h6 class="content-title">{{ $artikel->judul }}</h6>
                                        <p class="content-description">{{ Str::limit(strip_tags($artikel->konten), 60) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-bookmark"></i>
                            <p>Belum ada artikel yang disimpan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- Modal edit dan password akan ditambahkan nanti --}}
    <div class="pb-5"></div>
@endsection
