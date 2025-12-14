@extends('layouts.admin')

@section('title', 'Detail Siswa')
@section('page-title', 'Detail Siswa')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/siswa.css') }}">

    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Kelola Siswa</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Siswa</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Kolom Kiri: Info Siswa -->
            <div class="col-lg-4 mb-4">
                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            <div class="avatar-circle">
                                {{ strtoupper(substr($siswa->nama, 0, 2)) }}
                            </div>
                        </div>
                        <h4 class="profile-name">{{ $siswa->nama }}</h4>
                        <p class="profile-nis">NIS: {{ $siswa->nis }}</p>
                        <span class="profile-badge">{{ $siswa->kelas }}</span>
                    </div>

                    <div class="profile-body">
                        <div class="info-item">
                            <i class="fas fa-envelope info-icon"></i>
                            <div class="info-content">
                                <span class="info-label">Email</span>
                                <span class="info-value">{{ $siswa->email ?? 'Tidak tersedia' }}</span>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="fas fa-calendar-alt info-icon"></i>
                            <div class="info-content">
                                <span class="info-label">Terdaftar Sejak</span>
                                <span class="info-value">
                                    {{ $siswa->created_at ? $siswa->created_at->format('d M Y') : 'Tanggal tidak tersedia' }}
                                </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="fas fa-clock info-icon"></i>
                            <div class="info-content">
                                <span class="info-label">Terakhir Diperbarui</span>
                                <span class="info-value">
                                    {{ $siswa->updated_at ? $siswa->updated_at->diffForHumans() ?? 'Baru dibuat' : 'Belum pernah diupdate' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="profile-footer">
                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Statistik & Aktivitas -->
            <div class="col-lg-8">
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="stat-card stat-primary">
                            <div class="stat-icon">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number">
                                    {{ \App\Models\Artikel::where('siswa_id', $siswa->id)->count() }}
                                </h3>
                                <p class="stat-label">Total Artikel</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="stat-card stat-success">
                            <div class="stat-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number">
                                    {{ \App\Models\Artikel::where('siswa_id', $siswa->id)->where('status', 'disetujui')->count() }}
                                </h3>
                                <p class="stat-label">Artikel Disetujui</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="stat-card stat-warning">
                            <div class="stat-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-content">
                                <h3 class="stat-number">
                                    {{ number_format(\App\Models\Artikel::where('siswa_id', $siswa->id)->avg('nilai_rata_rata') ?? 0, 1) }}
                                </h3>
                                <p class="stat-label">Rata-rata Rating</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Articles -->
                <div class="activity-card">
                    <div class="activity-header">
                        <h5 class="activity-title">
                            <i class="fas fa-newspaper me-2"></i>Artikel Terbaru
                        </h5>
                    </div>
                    <div class="activity-body">
                        @forelse($siswa->artikel()->latest()->take(5)->get() as $artikel)
                            <div class="activity-item">
                                <div class="activity-icon-wrapper">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="activity-content">
                                    <h6 class="activity-item-title">{{ $artikel->judul }}</h6>
                                    <p class="activity-item-meta">
                                        <span
                                            class="badge badge-{{ $artikel->status == 'disetujui' ? 'success' : ($artikel->status == 'ditolak' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($artikel->status) }}
                                        </span>
                                        <span class="text-muted">
                                            •
                                            {{ $artikel->created_at ? $artikel->created_at->diffForHumans() : 'Tanggal tidak tersedia' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="activity-action">
                                    <a href="{{ route('admin.artikel.show', $artikel->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada artikel yang dibuat</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons-container mt-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editStudentModal"
            onclick="editStudent('{{ $siswa->nis }}', '{{ addslashes($siswa->nama) }}', '{{ addslashes($siswa->email ?? '') }}', '{{ addslashes($siswa->kelas) }}')">
            <i class="fas fa-edit me-2"></i>Edit Data Siswa
        </button>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStudentModal"
            onclick="prepareDelete('{{ $siswa->nis }}', '{{ $siswa->nama }}')">
            <i class="fas fa-trash me-2"></i>Hapus Siswa
        </button>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-3">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="editStudentModalLabel">
                        <i class="fas fa-user-edit me-2"></i>Edit Data Siswa
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>

                <form id="editStudentForm" method="POST" action="{{ route('admin.siswa.update', ':nis') }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-body p-4">
                        <input type="hidden" id="edit_original_nis" name="original_nis">

                        <div class="row g-3">
                            <!-- NIS -->
                            <div class="col-md-6">
                                <label for="edit_nis" class="form-label fw-semibold">
                                    <i class="fas fa-id-card me-2 text-primary"></i>NIS <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="edit_nis" name="nis"
                                    placeholder="Masukkan NIS" required>
                                <div class="invalid-feedback">NIS wajib diisi</div>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="col-md-6">
                                <label for="edit_nama" class="form-label fw-semibold">
                                    <i class="fas fa-user me-2 text-primary"></i>Nama Lengkap <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="edit_nama" name="nama"
                                    placeholder="Masukkan nama lengkap" required>
                                <div class="invalid-feedback">Nama lengkap wajib diisi</div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="edit_email" class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-2 text-primary"></i>Email <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" id="edit_email" name="email"
                                    placeholder="Masukkan email" required>
                                <div class="invalid-feedback">Email valid wajib diisi</div>
                            </div>

                            <!-- Kelas -->
                            <div class="col-md-6">
                                <label for="edit_kelas" class="form-label fw-semibold">
                                    <i class="fas fa-school me-2 text-primary"></i>Kelas <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="edit_kelas" name="kelas"
                                    placeholder="Masukkan kelas" required>
                                <div class="invalid-feedback">Kelas wajib diisi</div>
                            </div>

                            <!-- Divider -->
                            <div class="col-12">
                                <hr class="my-3">
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Kosongkan password jika tidak ingin mengubahnya
                                </p>
                            </div>

                            <!-- Password Baru -->
                            <div class="col-md-6">
                                <label for="edit_password" class="form-label fw-semibold">
                                    <i class="fas fa-lock me-2 text-primary"></i>Password Baru
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="edit_password" name="password"
                                        placeholder="Kosongkan jika tidak diubah">
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePasswordVisibility('edit_password', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text">Minimal 6 karakter</div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="col-md-6">
                                <label for="edit_password_confirmation" class="form-label fw-semibold">
                                    <i class="fas fa-lock me-2 text-primary"></i>Konfirmasi Password
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="edit_password_confirmation"
                                        name="password_confirmation" placeholder="Ulangi password baru">
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="togglePasswordVisibility('edit_password_confirmation', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">Password tidak cocok</div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="editSubmitBtn">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Student Modal -->
    <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content delete-warning-modal">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteStudentModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Peringatan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <p class="mb-3">Yakin ingin menghapus data siswa ini?</p>
                    <div class="alert alert-warning">
                        <strong id="delete_nis"></strong> - <span id="delete_nama"></span>
                    </div>
                    <p class="text-muted small mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Tindakan ini tidak dapat dibatalkan!
                    </p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <form id="deleteStudentForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">
                            <i class="fas fa-trash me-2"></i>Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- CSS Styles (TIDAK BERUBAH) -->
    <style>
        /* Profile Card Styles */
        .profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .profile-header {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            padding: 2rem;
            text-align: center;
            color: white;
        }

        .profile-avatar {
            margin-bottom: 1rem;
        }

        .avatar-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0 auto;
            border: 4px solid rgba(255, 255, 255, 0.3);
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .profile-nis {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 1rem;
        }

        .profile-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .profile-body {
            padding: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(59, 130, 246, 0.1));
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-right: 1rem;
        }

        .info-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 600;
        }

        .profile-footer {
            padding: 1.5rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        /* Statistics Cards */
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.15);
        }

        .stat-primary {
            border-left: 4px solid #2563eb;
        }

        .stat-success {
            border-left: 4px solid #10b981;
        }

        .stat-warning {
            border-left: 4px solid #f59e0b;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .stat-primary .stat-icon {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(59, 130, 246, 0.1));
            color: #2563eb;
        }

        .stat-success .stat-icon {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
            color: #10b981;
        }

        .stat-warning .stat-icon {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.1));
            color: #f59e0b;
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: #1e293b;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            margin: 0;
            font-weight: 500;
        }

        /* Activity Card */
        .activity-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .activity-header {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .activity-title {
            margin: 0;
            font-weight: 700;
            color: #1e293b;
            font-size: 1.1rem;
        }

        .activity-body {
            padding: 1.5rem 2rem;
            max-height: 500px;
            overflow-y: auto;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .activity-item:last-child {
            margin-bottom: 0;
        }

        .activity-item:hover {
            background: #f8fafc;
            border-color: #e2e8f0;
            transform: translateX(5px);
        }

        .activity-icon-wrapper {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(59, 130, 246, 0.1));
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .activity-content {
            flex: 1;
        }

        .activity-item-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .activity-item-meta {
            font-size: 0.85rem;
            color: #64748b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .activity-action {
            display: flex;
            gap: 0.5rem;
        }

        /* Badge Styles */
        .badge {
            padding: 0.35rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.15);
            color: #f59e0b;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
        }

        .empty-state i {
            opacity: 0.3;
        }

        /* Action Buttons Container */
        .action-buttons-container {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .action-buttons-container .btn {
            flex: 1;
            min-width: 200px;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .action-buttons-container .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Breadcrumb */
        .breadcrumb {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            color: #94a3b8;
        }

        .breadcrumb-item a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-item a:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: #64748b;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-card {
                margin-bottom: 2rem;
            }

            .stat-card {
                margin-bottom: 1rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .action-buttons-container {
                flex-direction: column;
            }

            .action-buttons-container .btn {
                width: 100%;
                min-width: auto;
            }

            .activity-item {
                flex-direction: column;
                text-align: center;
            }

            .activity-action {
                width: 100%;
                justify-content: center;
            }
        }

        /* Scroll Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-card,
        .stat-card,
        .activity-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        /* Modal Styles */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
        }

        .modal-content {
            border: none !important;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem 2rem;
        }

        .modal-body {
            max-height: calc(100vh - 250px);
            overflow-y: auto;
        }

        .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 1rem 2rem;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        .input-group .btn-outline-secondary {
            border-color: #e2e8f0;
        }

        .input-group .btn-outline-secondary:hover {
            background-color: #f8fafc;
            border-color: #2563eb;
            color: #2563eb;
        }

        /* Smooth modal transitions */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: none;
        }
    </style>

    <script>
        // Edit Student Function
        function editStudent(nis, nama, email, kelas) {
            document.getElementById('edit_original_nis').value = nis;
            document.getElementById('edit_nis').value = nis;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_kelas').value = kelas;
            document.getElementById('edit_password').value = '';
            document.getElementById('edit_password_confirmation').value = '';

            let url = "{{ route('admin.siswa.update', ':nis') }}";
            url = url.replace(':nis', nis);
            document.getElementById('editStudentForm').action = url;
        }

        // Prepare Delete Function
        function prepareDelete(nis, nama) {
            document.getElementById('delete_nis').textContent = nis;
            document.getElementById('delete_nama').textContent = nama;

            let url = "{{ route('admin.siswa.destroy', ':nis') }}";
            url = url.replace(':nis', nis);
            document.getElementById('deleteStudentForm').action = url;
        }

        // Toggle Password Visibility
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Fix Modal Backdrop Issue
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editStudentModal');

            if (editModal) {
                // Reset modal state when hidden
                editModal.addEventListener('hidden.bs.modal', function() {
                    // Remove all backdrops
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    // Reset body
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                    // Reset form
                    this.querySelector('form').reset();
                    this.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                });

                // Form validation
                const editForm = document.getElementById('editStudentForm');
                if (editForm) {
                    editForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const password = document.getElementById('edit_password').value;
                        const passwordConfirm = document.getElementById('edit_password_confirmation').value;

                        // Validate password match if password is filled
                        if (password && password !== passwordConfirm) {
                            document.getElementById('edit_password_confirmation').classList.add(
                                'is-invalid');
                            return false;
                        }

                        // Show loading
                        const submitBtn = document.getElementById('editSubmitBtn');
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
                        submitBtn.disabled = true;

                        // Submit form
                        this.submit();
                    });
                }
            }
        });
    </script>

    <!-- Include Modals -->
    @include('siswa.edit')

@endsection
