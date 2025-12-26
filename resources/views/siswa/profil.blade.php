@extends('layouts.siswa')

@section('title', 'Profil Saya')

@section('content')
    <style>
        /* ========================================
           PROFILE PAGE - MODERN REDESIGN
        ======================================== */
        
        .profile-page-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding-bottom: 3rem;
        }

        /* Profile Header Card */
        .profile-header-card {
            background: white;
            border-radius: 24px;
            padding: 2.5rem;
            margin: -60px auto 2rem;
            max-width: 800px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 10;
        }

        /* Cover Section */
        .profile-cover-section {
            height: 180px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
            position: relative;
            overflow: hidden;
        }

        .profile-cover-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        /* Avatar */
        .profile-avatar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: -70px;
            position: relative;
            z-index: 20;
        }

        .profile-avatar-ring {
            padding: 4px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 50%;
            box-shadow: 0 8px 30px rgba(59, 130, 246, 0.4);
        }

        .profile-avatar-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
        }

        .edit-avatar-overlay {
            position: absolute;
            bottom: 5px;
            right: calc(50% - 60px);
            width: 32px;
            height: 32px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            cursor: pointer;
            transition: transform 0.2s;
        }

        .edit-avatar-overlay:hover {
            transform: scale(1.1);
        }

        .edit-avatar-overlay i {
            color: #1d4ed8;
            font-size: 0.9rem;
        }

        /* Profile Info */
        .profile-info-center {
            text-align: center;
            margin-top: 1rem;
        }

        .profile-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .profile-details {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        /* Stats Row */
        .profile-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            padding: 1.25rem 0;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            margin: 1.5rem 0;
        }

        .stat-box {
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            display: block;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Action Buttons */
        .profile-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn-profile-action {
            padding: 0.75rem 1.75rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            border: 2px solid transparent;
        }

        .btn-edit-profile {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
        }

        .btn-edit-profile:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
            color: white;
        }

        .btn-change-password {
            background: white;
            color: #64748b;
            border-color: #e2e8f0;
        }

        .btn-change-password:hover {
            border-color: #1d4ed8;
            color: #1d4ed8;
        }

        /* ========================================
           CONTENT TABS - CLEAN DESIGN
        ======================================== */
        .content-section {
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        .tabs-container {
            background: white;
            border-radius: 0;
            overflow: hidden;
            box-shadow: none;
            border-top: 1px solid #dbdbdb;
        }

        .nav-tabs-profile {
            display: flex;
            justify-content: space-around;
            border-bottom: 1px solid #dbdbdb;
            background: white;
        }

        .nav-tabs-profile .nav-link {
            flex: 1;
            text-align: center;
            padding: 1rem 0;
            font-weight: 600;
            font-size: 0.75rem;
            color: #8e8e8e;
            border: none;
            background: transparent;
            position: relative;
            transition: all 0.2s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-tabs-profile .nav-link i {
            display: inline-block;
            font-size: 0.85rem;
            margin-right: 0.35rem;
        }

        .nav-tabs-profile .nav-link.active {
            color: #262626;
            background: white;
        }

        .nav-tabs-profile .nav-link.active::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: #262626;
        }

        .nav-tabs-profile .nav-link:hover:not(.active) {
            color: #262626;
        }

        /* Tab Content */
        .tab-content-profile {
            padding: 15px;
            min-height: 300px;
            background: white;
        }

        /* Content Grid - 4 columns */
        .content-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .content-card {
            position: relative;
            overflow: hidden;
            aspect-ratio: 3/4;
            cursor: pointer;
            border-radius: 8px;
            text-decoration: none;
            background: #f0f0f0;
            display: block;
            border: 1px solid #e0e0e0;
        }

        .content-card:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .content-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Remove overlay - transparent */
        .content-card-overlay {
            display: none;
        }

        /* Type indicator icon (top right) */
        .content-card-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(255,255,255,0.9);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
            color: #333;
            z-index: 10;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .content-card-badge i {
            font-size: 0.8rem;
            margin-right: 2px;
        }

        /* Show badge text */
        .content-card-title {
            display: none;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .content-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
            }
            .tab-content-profile {
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .content-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 6px;
            }
            .tab-content-profile {
                padding: 8px;
            }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        .empty-state p {
            font-size: 0.95rem;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-header-card {
                margin: -40px 1rem 2rem;
                padding: 1.5rem;
            }

            .profile-stats {
                gap: 1.5rem;
            }

            .stat-value {
                font-size: 1.25rem;
            }

            .profile-actions {
                flex-direction: column;
            }

            .btn-profile-action {
                justify-content: center;
            }

            .content-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <div class="profile-page-wrapper">
        <!-- Cover Section -->
        <div class="profile-cover-section"></div>

        <!-- Profile Header Card -->
        <div class="container">
            <div class="profile-header-card">
                <!-- Avatar -->
                <div class="profile-avatar-container">
                    <div class="profile-avatar-ring">
                        <img src="{{ $siswa->foto_profil ? asset('storage/' . $siswa->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama) . '&size=200&background=3b82f6&color=fff' }}"
                            alt="Foto Profil" class="profile-avatar-img">
                    </div>
                    <div class="edit-avatar-overlay" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil-fill"></i>
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="profile-info-center">
                    <h1 class="profile-name">{{ $siswa->nama }}</h1>
                    <p class="profile-details">{{ $siswa->kelas }} • {{ $siswa->email }}</p>
                </div>

                <!-- Stats -->
                <div class="profile-stats">
                    <div class="stat-box">
                        <span class="stat-value">{{ $totalPostingan ?? 0 }}</span>
                        <span class="stat-label">Postingan</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-value">{{ $totalSukaDiterima ?? 0 }}</span>
                        <span class="stat-label">Jumlah Suka</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="profile-actions">
                    <button class="btn btn-profile-action btn-edit-profile" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil-square"></i> Edit Profil
                    </button>
                    <button class="btn btn-profile-action btn-change-password" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="bi bi-shield-lock"></i> Ubah Password
                    </button>
                </div>
            </div>

            <!-- Content Tabs Section -->
            <div class="content-section">
                <div class="tabs-container">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs-profile" id="profilTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="postingan-tab" data-bs-toggle="tab"
                                data-bs-target="#postingan" type="button" role="tab">
                                <i class="bi bi-grid-3x3"></i>
                                Postingan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="disukai-tab" data-bs-toggle="tab"
                                data-bs-target="#disukai" type="button" role="tab">
                                <i class="bi bi-heart"></i>
                                Disukai
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="disimpan-tab" data-bs-toggle="tab"
                                data-bs-target="#disimpan" type="button" role="tab">
                                <i class="bi bi-bookmark"></i>
                                Disimpan
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content tab-content-profile" id="profilTabContent">
                        <!-- Postingan Saya -->
                        <div class="tab-pane fade show active" id="postingan" role="tabpanel">
                            @php
                                $allPostingan = collect();
                                if (isset($videoUpload)) {
                                    foreach ($videoUpload as $video) {
                                        $allPostingan->push([
                                            'type' => 'video',
                                            'item' => $video,
                                            'date' => $video->created_at
                                        ]);
                                    }
                                }
                                if (isset($artikelUpload)) {
                                    foreach ($artikelUpload as $artikel) {
                                        $allPostingan->push([
                                            'type' => 'artikel',
                                            'item' => $artikel,
                                            'date' => $artikel->created_at
                                        ]);
                                    }
                                }
                                $allPostingan = $allPostingan->sortByDesc('date');
                            @endphp

                            @if ($allPostingan->count() > 0)
                                <div class="content-grid">
                                    @foreach ($allPostingan as $post)
                                        @if ($post['type'] === 'video')
                                            <a href="{{ route('video.tiktok', ['start' => $post['item']->id]) }}" class="content-card">
                                                <img src="{{ $post['item']->thumbnail_path ? asset('storage/' . $post['item']->thumbnail_path) : '' }}"
                                                    alt="{{ $post['item']->judul }}">
                                                <div class="content-card-overlay">
                                                    <span class="content-card-badge"><i class="bi bi-play-fill"></i> Video</span>
                                                    <h6 class="content-card-title">{{ Str::limit($post['item']->judul, 40) }}</h6>
                                                </div>
                                            </a>
                                        @else
                                            <a href="{{ route('artikel-siswa.show', $post['item']->id) }}" class="content-card">
                                                <img src="{{ $post['item']->gambar ? asset('storage/' . $post['item']->gambar) : '' }}"
                                                    alt="{{ $post['item']->judul }}">
                                                <div class="content-card-overlay">
                                                    <span class="content-card-badge"><i class="bi bi-file-text"></i> Artikel</span>
                                                    <h6 class="content-card-title">{{ Str::limit($post['item']->judul, 40) }}</h6>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="bi bi-grid-3x3"></i>
                                    <p>Belum ada postingan</p>
                                </div>
                            @endif
                        </div>

                        <!-- Disukai -->
                        <div class="tab-pane fade" id="disukai" role="tabpanel">
                            @php
                                $allDisukai = collect();
                                foreach ($videoDisukai as $video) {
                                    $allDisukai->push(['type' => 'video', 'item' => $video]);
                                }
                                foreach ($artikelDisukai as $artikel) {
                                    $allDisukai->push(['type' => 'artikel', 'item' => $artikel]);
                                }
                            @endphp

                            @if ($allDisukai->count() > 0)
                                <div class="content-grid">
                                    @foreach ($allDisukai as $post)
                                        @if ($post['type'] === 'video')
                                            <a href="{{ route('video.tiktok', ['start' => $post['item']->id]) }}" class="content-card">
                                                <img src="{{ $post['item']->thumbnail_path ? asset('storage/' . $post['item']->thumbnail_path) : '' }}"
                                                    alt="{{ $post['item']->judul }}">
                                                <div class="content-card-overlay">
                                                    <span class="content-card-badge"><i class="bi bi-play-fill"></i> Video</span>
                                                    <h6 class="content-card-title">{{ Str::limit($post['item']->judul, 40) }}</h6>
                                                </div>
                                            </a>
                                        @else
                                            <a href="{{ route('artikel-siswa.show', $post['item']->id) }}" class="content-card">
                                                <img src="{{ $post['item']->gambar ? asset('storage/' . $post['item']->gambar) : '' }}"
                                                    alt="{{ $post['item']->judul }}">
                                                <div class="content-card-overlay">
                                                    <span class="content-card-badge"><i class="bi bi-file-text"></i> Artikel</span>
                                                    <h6 class="content-card-title">{{ Str::limit($post['item']->judul, 40) }}</h6>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="bi bi-heart"></i>
                                    <p>Belum ada konten yang disukai</p>
                                </div>
                            @endif
                        </div>

                        <!-- Disimpan -->
                        <div class="tab-pane fade" id="disimpan" role="tabpanel">
                            @php
                                $allDisimpan = collect();
                                foreach ($videoDisimpan as $video) {
                                    $allDisimpan->push(['type' => 'video', 'item' => $video]);
                                }
                                foreach ($artikelDisimpan as $artikel) {
                                    $allDisimpan->push(['type' => 'artikel', 'item' => $artikel]);
                                }
                            @endphp

                            @if ($allDisimpan->count() > 0)
                                <div class="content-grid">
                                    @foreach ($allDisimpan as $post)
                                        @if ($post['type'] === 'video')
                                            <a href="{{ route('video.tiktok', ['start' => $post['item']->id]) }}" class="content-card">
                                                <img src="{{ $post['item']->thumbnail_path ? asset('storage/' . $post['item']->thumbnail_path) : '' }}"
                                                    alt="{{ $post['item']->judul }}">
                                                <div class="content-card-overlay">
                                                    <span class="content-card-badge"><i class="bi bi-play-fill"></i> Video</span>
                                                    <h6 class="content-card-title">{{ Str::limit($post['item']->judul, 40) }}</h6>
                                                </div>
                                            </a>
                                        @else
                                            <a href="{{ route('artikel-siswa.show', $post['item']->id) }}" class="content-card">
                                                <img src="{{ $post['item']->gambar ? asset('storage/' . $post['item']->gambar) : '' }}"
                                                    alt="{{ $post['item']->judul }}">
                                                <div class="content-card-overlay">
                                                    <span class="content-card-badge"><i class="bi bi-file-text"></i> Artikel</span>
                                                    <h6 class="content-card-title">{{ Str::limit($post['item']->judul, 40) }}</h6>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="bi bi-bookmark"></i>
                                    <p>Belum ada konten yang disimpan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; border: none;">
                    <h5 class="modal-title" id="editProfileModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>Edit Profil
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <img src="{{ $siswa->foto_profil ? asset('storage/' . $siswa->foto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama) . '&size=200&background=3b82f6&color=fff' }}"
                                alt="Foto Profil" class="rounded-circle" id="previewProfileImage" style="width: 100px; height: 100px; object-fit: cover;">
                        </div>
                        <div class="mb-3">
                            <label for="foto_profil" class="form-label">Foto Profil Baru</label>
                            <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted">Format: JPG, PNG, GIF. Maks: 2MB</small>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $siswa->nama }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $siswa->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" value="{{ $siswa->kelas }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border: none;">
                            <i class="bi bi-check-lg me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header bg-warning text-dark" style="border: none;">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        <i class="bi bi-shield-lock me-2"></i>Ubah Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('profil.update-password') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('current_password')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="password" required minlength="8">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new_password')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-lg me-1"></i>Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewProfileImage').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
    </script>
@endsection
