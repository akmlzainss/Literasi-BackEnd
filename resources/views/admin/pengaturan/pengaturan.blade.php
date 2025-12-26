@extends('layouts.admin')

@section('title', 'Pengaturan Admin')
@section('page-title', 'Pengaturan Admin & Profil')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/pengaturan.css') }}">

    <div class="page-header">
        <div class="header-content">
            <div class="profile-section">
                <div class="avatar-container">
                    <img src="{{ auth()->guard('admin')->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->guard('admin')->user()->nama_pengguna ?? 'Admin') . '&background=2563eb&color=fff&size=80' }}"
                        alt="Profile" class="profile-avatar">
                    <div class="avatar-overlay">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
                <div class="profile-info">
                    <h1 class="page-title">{{ auth()->guard('admin')->user()->nama_pengguna ?? 'Admin' }}</h1>
                    <p class="page-subtitle">
                        {{ auth()->guard('admin')->check() ? 'Administrator Sistem Literasi Akhlak' : 'Silakan login' }}</p>
                    <div class="status-badge">
                        <i class="fas fa-circle"></i>
                        <span>{{ auth()->guard('admin')->user()->status_aktif == 1 ? 'Online' : 'Offline' }}</span>
                    </div>
                </div>
            </div>
            <div class="action-buttons">
                <button type="button" class="btn btn-sm btn-primary-custom" data-bs-toggle="modal"
                    data-bs-target="#modalEditProfile">
                    <i class="fas fa-edit me-2"></i> Edit Profil
                </button>
                <a href="{{ route('admin.pengaturan.trash') }}" class="btn btn-sm btn-primary-custom">
                    <i class="bi bi-trash me-2"></i> Trash
                </a>
                <a href="{{ route('admin.backup.all') }}" class="btn btn-sm btn-primary-custom">
                    <i class="fas fa-download me-2"></i> Backup Data
                </a>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <h2 class="mb-4 text-primary fw-semibold">Panduan & Alur Kerja Sistem</h2>

        <div class="accordion" id="alurSistemAccordion">
            <div class="accordion-item border-0 shadow-sm">
                <h2 class="accordion-header" id="headingArtikel">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseArtikel" aria-expanded="true" aria-controls="collapseArtikel">
                        <i class="bi bi-file-earmark-text me-2"></i> Modul Artikel
                    </button>
                </h2>
                <div id="collapseArtikel" class="accordion-collapse collapse show" aria-labelledby="headingArtikel"
                    data-bs-parent="#alurSistemAccordion">
                    <div class="accordion-body">
                        <ol class="mb-0">
                            <li>Masuk ke menu Artikel untuk melihat daftar semua artikel.</li>
                            <li>Klik <strong>Tambah Artikel</strong> untuk membuat artikel baru.</li>
                            <li>Isi field: Judul, Isi, Kategori, Status.</li>
                            <li>Klik <strong>Simpan</strong>, artikel akan tersimpan dan muncul di daftar.</li>
                            <li>Dapat melakukan <strong>Edit</strong> atau <strong>Hapus</strong> untuk setiap artikel.</li>
                            <li>Gunakan tombol <strong>Export</strong> untuk mengekspor data artikel ke Excel.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0 shadow-sm">
                <h2 class="accordion-header" id="headingSiswa">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSiswa" aria-expanded="false" aria-controls="collapseSiswa">
                        <i class="bi bi-people me-2"></i> Modul Siswa
                    </button>
                </h2>
                <div id="collapseSiswa" class="accordion-collapse collapse" aria-labelledby="headingSiswa"
                    data-bs-parent="#alurSistemAccordion">
                    <div class="accordion-body">
                        <ol class="mb-0">
                            <li>Masuk ke menu Siswa untuk melihat daftar semua siswa.</li>
                            <li>Dapat menambahkan siswa baru melalui tombol <strong>Tambah Siswa</strong>.</li>
                            <li>Isi data siswa lengkap, termasuk NIS, Nama, Kelas, dan Email.</li>
                            <li>Gunakan fitur filter dan pencarian untuk menemukan siswa dengan cepat.</li>
                            <li>Dapat melakukan <strong>Edit</strong> atau <strong>Hapus</strong> untuk setiap siswa.</li>
                            <li>Gunakan tombol <strong>Export</strong> untuk mengekspor data siswa ke Excel atau PDF.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0 shadow-sm">
                <h2 class="accordion-header" id="headingPenghargaan">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePenghargaan" aria-expanded="false" aria-controls="collapsePenghargaan">
                        <i class="bi bi-award me-2"></i> Modul Penghargaan
                    </button>
                </h2>
                <div id="collapsePenghargaan" class="accordion-collapse collapse" aria-labelledby="headingPenghargaan"
                    data-bs-parent="#alurSistemAccordion">
                    <div class="accordion-body">
                        <ol class="mb-0">
                            <li>Masuk ke menu Penghargaan untuk melihat daftar penghargaan siswa.</li>
                            <li>Klik <strong>Tambah Penghargaan</strong> untuk menambahkan penghargaan baru.</li>
                            <li>Pilih siswa dan jenis penghargaan, kemudian klik <strong>Simpan</strong>.</li>
                            <li>Dapat melakukan <strong>Edit</strong> atau <strong>Hapus</strong> penghargaan jika
                                diperlukan.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0 shadow-sm">
                <h2 class="accordion-header" id="headingLaporan">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseLaporan" aria-expanded="false" aria-controls="collapseLaporan">
                        <i class="bi bi-file-earmark-text me-2"></i> Modul Laporan
                    </button>
                </h2>
                <div id="collapseLaporan" class="accordion-collapse collapse" aria-labelledby="headingLaporan"
                    data-bs-parent="#alurSistemAccordion">
                    <div class="accordion-body">
                        <ol class="mb-0">
                            <li>Masuk ke menu Laporan untuk melihat laporan aktivitas sistem.</li>
                            <li>Pilih jenis laporan: Artikel, Siswa, Penghargaan, atau Aktivitas Admin.</li>
                            <li>Klik <strong>Generate</strong> untuk menampilkan laporan.</li>
                            <li>Dapat mengekspor laporan ke PDF atau Excel.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4 mb-4">
        <div class="col-lg-4">
            <div class="info-card shadow-sm border-0">
                <div class="card-header-info">
                    <div class="card-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="card-content">
                        <h5 class="fw-semibold">Informasi Akun</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="info-items-container">
                        <div class="info-item">
                            <span class="label">Email:</span>
                            <span class="value">{{ auth()->guard('admin')->user()->email ?? 'Tidak ada email' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Role:</span>
                            <span
                                class="value">{{ auth()->guard('admin')->user()->nama_pengguna ?? 'Tidak ada nama' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="label">Status:</span>
                            <span class="value status-active">
                                <i class="fas fa-circle me-1"></i>
                                {{ auth()->guard('admin')->user()->status_aktif == 1 ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="label">Bergabung:</span>
                            <span class="value">
                                {{ auth()->guard('admin')->user()->created_at ? \Carbon\Carbon::parse(auth()->guard('admin')->user()->created_at)->translatedFormat('d F Y') : 'Tidak ada data' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="info-card shadow-sm border-0">
                <div class="card-header-info">
                    <div class="card-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="card-content">
                        <h5 class="fw-semibold">Keamanan</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="security-items-container">
                        <div class="security-item">
                            <i class="fas fa-key text-success me-2"></i>
                            <div class="security-info">
                                <div class="security-label">Password terakhir diubah:</div>
                                <div class="security-value">
                                    {{ $admin->last_password_changed_at ? \Carbon\Carbon::parse($admin->last_password_changed_at)->diffForHumans() : 'Tidak diketahui' }}
                                </div>
                            </div>
                        </div>
                        <div class="security-item">
                            <i class="fas fa-clock text-warning me-2"></i>
                            <div class="security-info">
                                <div class="security-label">Login terakhir:</div>
                                <div class="security-value">
                                    {{ $admin->last_login_at ? \Carbon\Carbon::parse($admin->last_login_at)->translatedFormat('d M Y, H:i') . ' WIB' : 'Belum pernah login' }}
                                </div>
                            </div>
                        </div>
                        <div class="security-item">
                            <i class="fas fa-desktop text-info me-2"></i>
                            <div class="security-info">
                                <div class="security-label">Perangkat:</div>
                                <div class="security-value">{{ $perangkat ?? 'Perangkat Tidak Dikenali' }}</div>
                            </div>
                        </div>
                        <div class="security-item">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <div class="security-info">
                                <div class="security-label">IP Address:</div>
                                <div class="security-value">{{ $ipAddress ?? 'Tidak diketahui' }}</div>
                            </div>
                        </div>
                        <div class="security-item">
                            <i class="fas fa-wifi text-secondary me-2"></i>
                            <div class="security-info">
                                <div class="security-label">Status Koneksi:</div>
                                <div class="security-value">
                                    <span class="connection-status {{ $isOnline ?? false ? 'online' : 'offline' }}">
                                        <i class="fas fa-circle me-1"></i> {{ $isOnline ?? false ? 'Online' : 'Offline' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Application Settings Section --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="info-card shadow-sm border-0">
                <div class="card-header-info">
                    <div class="card-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="card-content">
                        <h5 class="fw-semibold">Pengaturan Aplikasi</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        {{-- File Upload Settings --}}
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-upload me-2"></i>Pengaturan Upload File</h6>
                            
                            <div class="mb-3">
                                <label for="max_image_size" class="form-label">
                                    Ukuran Maksimal Gambar (MB)
                                </label>
                                <input type="number" class="form-control" id="max_image_size" name="max_image_size" 
                                       value="2" min="1" max="10">
                                <small class="text-muted">Ukuran maksimal file gambar yang dapat diupload (1-10 MB)</small>
                            </div>

                            <div class="mb-3">
                                <label for="max_video_size" class="form-label">
                                    Ukuran Maksimal Video (MB)
                                </label>
                                <input type="number" class="form-control" id="max_video_size" name="max_video_size" 
                                       value="100" min="10" max="500">
                                <small class="text-muted">Ukuran maksimal file video yang dapat diupload (10-500 MB)</small>
                            </div>

                            <div class="mb-3">
                                <label for="allowed_extensions" class="form-label">
                                    Ekstensi File yang Diizinkan
                                </label>
                                <input type="text" class="form-control" id="allowed_extensions" name="allowed_extensions" 
                                       value="jpg, jpeg, png, gif, mp4, mov, avi" readonly>
                                <small class="text-muted">Format file yang diizinkan untuk upload</small>
                            </div>
                        </div>

                        {{-- Security Settings --}}
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3"><i class="fas fa-shield-alt me-2"></i>Pengaturan Keamanan</h6>
                            
                            <div class="mb-3">
                                <label for="max_login_attempts" class="form-label">
                                    Maksimal Percobaan Login
                                </label>
                                <input type="number" class="form-control" id="max_login_attempts" name="max_login_attempts" 
                                       value="5" min="3" max="10">
                                <small class="text-muted">Jumlah percobaan login sebelum akun dikunci sementara</small>
                            </div>

                            <div class="mb-3">
                                <label for="lockout_duration" class="form-label">
                                    Durasi Penguncian Akun (menit)
                                </label>
                                <input type="number" class="form-control" id="lockout_duration" name="lockout_duration" 
                                       value="15" min="5" max="60">
                                <small class="text-muted">Durasi penguncian akun setelah gagal login berulang</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label d-block">Proteksi Keamanan</label>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="csrf_protection" checked disabled>
                                    <label class="form-check-label" for="csrf_protection">
                                        <i class="fas fa-check-circle text-success me-1"></i> CSRF Protection (Aktif)
                                    </label>
                                </div>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="xss_protection" checked disabled>
                                    <label class="form-check-label" for="xss_protection">
                                        <i class="fas fa-check-circle text-success me-1"></i> XSS Protection (Aktif)
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="sql_injection_protection" checked disabled>
                                    <label class="form-check-label" for="sql_injection_protection">
                                        <i class="fas fa-check-circle text-success me-1"></i> SQL Injection Protection (Aktif)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-primary-custom" id="saveSettingsBtn">
                            <i class="fas fa-save me-2"></i>Simpan Pengaturan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditProfile" tabindex="-1" aria-labelledby="modalEditProfileLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editProfileForm" action="{{ route('admin.pengaturan.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditProfileLabel">
                            <i class="fas fa-user-edit me-2"></i> Edit Profil & Ubah Password
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="text-center mb-4">
                            <div class="avatar-upload">
                                <img src="{{ auth()->guard('admin')->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->guard('admin')->user()->nama_pengguna ?? 'Admin') . '&background=2563eb&color=fff&size=120' }}"
                                    alt="Profile" class="profile-preview">
                                <label for="profile_photo" class="upload-overlay">
                                    <i class="fas fa-camera"></i>
                                    <span>Ubah Foto</span>
                                </label>
                                <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                                    style="display: none;">
                            </div>
                            @error('profile_photo')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nama_pengguna" class="form-label"><i class="fas fa-user me-2"></i> Nama
                                Pengguna</label>
                            <input type="text" name="nama_pengguna" id="nama_pengguna" class="form-control"
                                value="{{ old('nama_pengguna', auth()->guard('admin')->user()->nama_pengguna ?? '') }}"
                                required>
                            @error('nama_pengguna')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i> Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ old('email', auth()->guard('admin')->user()->email ?? '') }}" required>
                            @error('email')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr class="my-4">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                <i class="fas fa-lock me-2"></i> Password Saat Ini <span
                                    class="text-muted">(opsional)</span>
                            </label>
                            <div class="password-input-container">
                                <input type="password" name="current_password" id="current_password"
                                    class="form-control">
                                <button type="button" class="password-toggle"
                                    onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">
                                <i class="fas fa-key me-2"></i> Password Baru <span class="text-muted">(opsional)</span>
                            </label>
                            <div class="password-input-container">
                                <input type="password" name="new_password" id="new_password" class="form-control">
                                <button type="button" class="password-toggle" onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength mt-2" style="display: none;">
                                <div class="strength-bar">
                                    <div class="strength-progress"></div>
                                </div>
                                <div class="strength-text"></div>
                            </div>
                            @error('new_password')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">
                                <i class="fas fa-check-circle me-2"></i> Konfirmasi Password Baru
                            </label>
                            <div class="password-input-container">
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control">
                                <button type="button" class="password-toggle"
                                    onclick="togglePassword('new_password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('new_password_confirmation')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="password-requirements">
                            <h6>Persyaratan Password:</h6>
                            <ul class="mb-0">
                                <li>Minimal 8 karakter</li>
                                <li>Mengandung huruf besar dan kecil</li>
                                <li>Mengandung angka</li>
                                <li>Mengandung karakter khusus (!@#$%^&*)</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div id="notif-success" class="custom-alert alert-success">
            {{ session('success') }}
            <span id="notif-success-time"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div id="notif-error" class="custom-alert alert-danger">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @push('styles')
        <style>
            .custom-alert {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                padding: 10px 20px;
            }

            .accordion-button {
                background-color: var(--primary-blue);
                color: white !important;
                border-radius: 0.25rem;
                font-weight: 500;
                transition: background-color 0.3s ease;
            }

            .accordion-button:not(.collapsed) {
                background-color: var(--light-blue);
                color: white !important;
            }

            .accordion-button:focus {
                box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
            }

            .accordion-item {
                border-radius: 0.5rem;
                margin-bottom: 1rem;
                background-color: var(--card-bg, #fff);
            }

            .accordion-body {
                font-size: 0.95rem;
                color: var(--text-primary, #333);
            }

            body.dark-mode .accordion-body {
                color: var(--text-light, #e0e0e0);
            }

            body.dark-mode .form-label {
                color: var(--text-dark, #e0e0e0);
            }

            body.dark-mode .text-muted {
                color: var(--text-light, #a0a0a0) !important;
            }

            body.dark-mode .modal-backdrop {
                background-color: rgba(0, 0, 0, 0.8);
            }

            body.dark-mode hr {
                border-color: var(--border-light, #444);
            }

            body.dark-mode *,
            body.light-mode * {
                transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            }

            .btn-primary-custom {
                background-color: var(--primary-blue, #2563eb);
                border-color: var(--primary-blue, #2563eb);
                color: white;
                border-radius: 0.25rem;
                transition: background-color 0.3s ease;
            }

            .btn-primary-custom:hover {
                background-color: var(--light-blue, #60a5fa);
                border-color: var(--light-blue, #60a5fa);
            }

            .strength-progress {
                height: 5px;
                background-color: #e0e0e0;
                border-radius: 3px;
                overflow: hidden;
            }

            .strength-progress.weak {
                background-color: #ff4d4d;
            }

            .strength-progress.medium {
                background-color: #ffcc00;
            }

            .strength-progress.good {
                background-color: #00cc00;
            }

            .strength-progress.strong {
                background-color: #0066cc;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('js/theme-manager.js') }}"></script>
        <script>
            function togglePassword(inputId) {
                const input = document.getElementById(inputId);
                const icon = input.nextElementSibling.querySelector('i');
                input.type = input.type === 'password' ? 'text' : 'password';
                icon.classList.toggle('fa-eye', input.type === 'password');
                icon.classList.toggle('fa-eye-slash', input.type === 'text');
            }

            function timeAgo(seconds) {
                if (seconds < 60) return `${seconds} detik yang lalu`;
                const minutes = Math.floor(seconds / 60);
                if (minutes < 60) return `${minutes} menit yang lalu`;
                const hours = Math.floor(minutes / 60);
                if (hours < 24) return `${hours} jam yang lalu`;
                return `${Math.floor(hours / 24)} hari yang lalu`;
            }

            document.addEventListener('DOMContentLoaded', () => {
                // Success Notification
                @if (session('success'))
                    const notifSuccess = document.getElementById('notif-success');
                    const timeSpan = document.getElementById('notif-success-time');
                    let start = Date.now();

                    function updateTime() {
                        const elapsed = Math.floor((Date.now() - start) / 1000);
                        timeSpan.textContent = ` (${timeAgo(elapsed)})`;
                    }
                    updateTime();
                    const interval = setInterval(updateTime, 1000);
                    setTimeout(() => {
                        notifSuccess.style.transition = 'opacity 0.5s ease';
                        notifSuccess.style.opacity = '0';
                        setTimeout(() => notifSuccess.remove(), 500);
                        clearInterval(interval);
                    }, 6000);
                @endif

                // Error Notification
                @if (session('error'))
                    const notifError = document.getElementById('notif-error');
                    setTimeout(() => {
                        notifError.style.transition = 'opacity 0.5s ease';
                        notifError.style.opacity = '0';
                        setTimeout(() => notifError.remove(), 500);
                    }, 6000);
                @endif

                // Password Strength Checker
                const newPasswordInput = document.getElementById('new_password');
                if (newPasswordInput) {
                    newPasswordInput.addEventListener('input', function() {
                        const password = this.value;
                        const strengthContainer = document.querySelector('.password-strength');
                        const strengthBar = document.querySelector('.strength-progress');
                        const strengthText = document.querySelector('.strength-text');
                        strengthContainer.style.display = password.length > 0 ? 'block' : 'none';
                        if (password.length === 0) return;

                        let strength = 0;
                        const feedback = [];
                        if (password.length >= 8) strength++;
                        else feedback.push('minimal 8 karakter');
                        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
                        else feedback.push('huruf besar dan kecil');
                        if (/\d/.test(password)) strength++;
                        else feedback.push('angka');
                        if (/[!@#$%^&*]/.test(password)) strength++;
                        else feedback.push('karakter khusus');

                        const strengthPercentage = (strength / 4) * 100;
                        strengthBar.style.width = `${strengthPercentage}%`;
                        strengthBar.className =
                            `strength-progress ${strength <= 1 ? 'weak' : strength <= 2 ? 'medium' : strength <= 3 ? 'good' : 'strong'}`;
                        strengthText.textContent = strength === 4 ? 'Password sangat kuat!' :
                            `Password ${strength <= 1 ? 'lemah' : strength <= 2 ? 'sedang' : 'baik'} - perlu ${feedback.join(', ')}`;
                    });
                }

                // Profile Photo Preview
                const profilePhotoInput = document.getElementById('profile_photo');
                if (profilePhotoInput) {
                    profilePhotoInput.addEventListener('change', (event) => {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => document.querySelector('.profile-preview').src = e.target
                                .result;
                            reader.readAsDataURL(file);
                        }
                    });
                }

                // Form Submit AJAX
                const editProfileForm = document.getElementById('editProfileForm');
                if (editProfileForm) {
                    editProfileForm.addEventListener('submit', async (e) => {
                        e.preventDefault();
                        const formData = new FormData(editProfileForm);
                        const submitButton = editProfileForm.querySelector('button[type="submit"]');
                        const originalText = submitButton.innerHTML;
                        submitButton.disabled = true;
                        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';

                        try {
                            const response = await fetch(editProfileForm.action, {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json'
                                },
                                body: formData
                            });
                            const result = await response.json();
                            if (response.ok) {
                                showAlert('success', 'Profil berhasil diperbarui!');
                                if (result.profile_photo_url) {
                                    document.querySelector('.profile-avatar').src = result
                                    .profile_photo_url;
                                    document.querySelector('.profile-preview').src = result
                                        .profile_photo_url;
                                }
                                bootstrap.Modal.getInstance(document.getElementById('modalEditProfile'))
                                    .hide();
                                setTimeout(() => location.reload(), 2000);
                            } else {
                                showAlert('error', result.message || 'Gagal memperbarui profil.');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            showAlert('error', 'Terjadi kesalahan saat memperbarui profil.');
                        } finally {
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalText;
                        }
                    });
                }

                // Theme Manager
                const body = document.body;
                const themeRadios = document.querySelectorAll('input[name="tema_sistem"]');
                const savedTheme = localStorage.getItem('tema_sistem') || 'light';
                setTheme(savedTheme);
                themeRadios.forEach(radio => {
                    radio.addEventListener('change', () => {
                        setTheme(radio.value);
                        localStorage.setItem('tema_sistem', radio.value);
                    });
                });

                function setTheme(theme) {
                    body.classList.toggle('dark-mode', theme === 'dark');
                    body.classList.toggle('light-mode', theme !== 'dark');
                    document.getElementById(`tema_${theme}`).checked = true;
                }

                // Alert Function
                function showAlert(type, message) {
                    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                    const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                    const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show custom-alert" role="alert">
                        <i class="fas ${iconClass} me-2"></i>${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                    document.querySelectorAll('.custom-alert').forEach(alert => alert.remove());
                    document.body.insertAdjacentHTML('beforeend', alertHtml);
                    setTimeout(() => {
                        const alert = document.querySelector('.custom-alert');
                        if (alert) new bootstrap.Alert(alert).close();
                    }, 5000);
                }
            });
        </script>
    @endpush
@endsection
