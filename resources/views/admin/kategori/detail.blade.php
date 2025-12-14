@extends('layouts.admin')

@section('title', 'Detail Kategori')
@section('page-title', 'Detail Kategori')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/kategori.css') }}">

    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.kategori.index') }}">Kelola Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Kategori</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Kolom Kiri: Info Kategori -->
            <div class="col-lg-5 mb-4">
                <!-- Category Profile Card -->
                <div class="category-profile-card">
                    <div class="category-header">
                        <div class="category-icon-wrapper">
                            <div class="category-icon">
                                <i class="fas fa-tag"></i>
                            </div>
                        </div>
                        <h3 class="category-name">{{ $kategori->nama }}</h3>
                        <div class="category-badge-wrapper">
                            <span class="category-badge">
                                <i class="fas fa-book-open me-2"></i>
                                {{ $stats['total'] ?? $kategori->artikel->count() }} Artikel
                            </span>
                        </div>
                    </div>

                    <div class="category-body">
                        <!-- Deskripsi -->
                        <div class="info-section">
                            <h6 class="info-section-title">
                                <i class="fas fa-align-left me-2"></i>Deskripsi
                            </h6>
                            <div class="info-section-content">
                                @if ($kategori->deskripsi)
                                    <p class="description-text">{{ $kategori->deskripsi }}</p>
                                @else
                                    <p class="text-muted small">
                                        <i class="fas fa-info-circle me-2"></i>Tidak ada deskripsi
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Metadata -->
                        <div class="info-section">
                            <h6 class="info-section-title">
                                <i class="fas fa-info-circle me-2"></i>Informasi
                            </h6>
                            <div class="metadata-grid">
                                <div class="metadata-item">
                                    <i class="fas fa-calendar-plus metadata-icon"></i>
                                    <div class="metadata-content">
                                        <span class="info-label">Dibuat Pada</span>
                                        <span class="metadata-value">
                                            {{ $kategori->dibuat_pada ? \Carbon\Carbon::parse($kategori->dibuat_pada)->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="metadata-item">
                                    <i class="fas fa-clock metadata-icon"></i>
                                    <div class="metadata-content">
                                        <span class="info-label">Terakhir Diperbarui</span>
                                        <span class="metadata-value">
                                            {{ $kategori->updated_at ? $kategori->updated_at->diffForHumans() : '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="metadata-item">
                                    <i class="fas fa-database metadata-icon"></i>
                                    <div class="metadata-content">
                                        <span class="info-label">ID Kategori</span>
                                        <span class="metadata-value">#{{ $kategori->id }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile-footer">
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Artikel Terkait -->
            <div class="col-lg-7">
                <!-- Statistics Card -->
                <div class="stats-overview mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="stat-card stat-primary">
                                <div class="stat-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="stat-content">
                                    <h4 class="stat-number">{{ $stats['total'] ?? $kategori->artikel->count() }}</h4>
                                    <p class="stat-label">Total Artikel</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="stat-card stat-success">
                                <div class="stat-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-content">
                                    <h4 class="stat-number">
                                        {{ $stats['disetujui'] ?? $kategori->artikel->where('status', 'disetujui')->count() }}
                                    </h4>
                                    <p class="stat-label">Disetujui</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Articles List Card -->
                <div class="articles-card">
                    <div class="articles-header">
                        <h5 class="articles-title">
                            <i class="fas fa-newspaper me-2"></i>Artikel dalam Kategori Ini
                        </h5>
                        <span class="articles-count">{{ $stats['total'] ?? $kategori->artikel->count() }} Artikel</span>
                    </div>

                    <div class="articles-body">
                        @forelse($artikels ?? $kategori->artikel ?? [] as $artikel)
                            <div class="article-item">
                                <!-- Article Image/Thumbnail -->
                                <div class="article-thumbnail">
                                    @if ($artikel->gambar)
                                        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}">
                                    @else
                                        <div class="article-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Article Content -->
                                <div class="article-content">
                                    <h6 class="article-title">
                                        <a href="{{ route('admin.artikel.show', $artikel->id) }}">
                                            {{ $artikel->judul }}
                                        </a>
                                    </h6>

                                    <div class="article-meta">
                                        <!-- Status Badge -->
                                        <span
                                            class="badge badge-{{ $artikel->status == 'disetujui'
                                                ? 'success'
                                                : ($artikel->status == 'ditolak'
                                                    ? 'danger'
                                                    : ($artikel->status == 'draf'
                                                        ? 'secondary'
                                                        : 'warning')) }}">
                                            {{ ucfirst($artikel->status) ?? 'Tidak Diketahui' }}
                                        </span>

                                        <!-- Author -->
                                        <span class="article-author">
                                            <i class="fas fa-user me-1"></i>
                                            @if ($artikel->penulis_type == 'siswa' && optional($artikel->siswa))
                                                {{ $artikel->siswa->nama ?? 'Siswa Tidak Ditemukan' }}
                                            @else
                                                Admin
                                            @endif
                                        </span>

                                        <!-- Date -->
                                        <span class="article-date">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $artikel->created_at ? $artikel->created_at->format('d M Y') : '-' }}
                                        </span>
                                    </div>

                                    <!-- Excerpt -->
                                    @if ($artikel->konten)
                                        <p class="article-excerpt">
                                            {{ Str::limit(strip_tags($artikel->konten), 100) }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Article Actions -->
                                <div class="article-actions">
                                    <a href="{{ route('admin.artikel.show', $artikel->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum Ada Artikel</h5>
                                <p class="text-muted small">Kategori ini belum memiliki artikel yang terkait.</p>
                            </div>
                        @endforelse

                        <!-- PAGINATION -->
                        @if ($artikels->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $artikels->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons-container mt-4">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditKategori"
            onclick="loadEditData('{{ $kategori->id }}', '{{ addslashes($kategori->nama) }}', '{{ addslashes($kategori->deskripsi ?? '') }}')">
            <i class="fas fa-edit me-2"></i>Edit Data Kategori
        </button>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal"
            onclick="prepareDelete('{{ $kategori->id }}', '{{ $kategori->nama }}')">
            <i class="fas fa-trash me-2"></i>Hapus Kategori
        </button>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content delete-warning-modal">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Peringatan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <p class="mb-3">Yakin ingin menghapus kategori ini?</p>
                    <div class="alert alert-warning">
                        <strong id="delete_id"></strong> - <span id="delete_nama"></span>
                    </div>
                    @if (($stats['total'] ?? $kategori->artikel->count()) > 0)
                        <p class="text-danger small mb-0">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            Perhatian: Kategori ini memiliki <strong>{{ $stats['total'] ?? $kategori->artikel->count() }}
                                artikel</strong> terkait!
                        </p>
                    @else
                        <p class="text-muted small mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Tindakan ini tidak dapat dibatalkan!
                        </p>
                    @endif
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <form id="deleteCategoryForm" method="POST" class="d-inline">
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

    <!-- Edit Kategori Modal -->
    <div class="modal fade" id="modalEditKategori" tabindex="-1" aria-labelledby="modalEditKategoriLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form id="editForm" action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                    @method('PUT')
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger m-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success m-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalEditKategoriLabel">Edit Kategori</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body text-center">
                        <input type="hidden" name="id" id="editId">

                        <div class="mb-3 text-start">
                            <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="nama" id="edit_nama_kategori"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $kategori->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 text-start">
                            <label for="edit_deskripsi" class="form-label">Deskripsi Kategori (opsional)</label>
                            <textarea name="deskripsi" id="edit_deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="4">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Breadcrumb */
        .breadcrumb {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
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

        /* Category Profile Card */
        .category-profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        /* ======== HEADER CATEGORY (diperbaiki) ======== */
        .category-header {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            padding: 2.2rem 1.5rem;
            text-align: center;
            color: white;
            border-radius: 20px 20px 0 0;
            position: relative;
        }

        .category-icon-wrapper {
            margin-bottom: 1.2rem;
        }

        .category-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem auto;
            border: 3px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 8px rgba(255, 255, 255, 0.1);
        }

        .category-name {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        .category-badge-wrapper {
            margin-top: 0.8rem;
        }

        .category-badge {
            background: rgba(255, 255, 255, 0.25);
            padding: 0.45rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 0.8rem;
        }

        /* Category Body */
        .category-body {
            padding: 2rem;
        }

        .info-section {
            margin-bottom: 2rem;
        }

        .info-section:last-child {
            margin-bottom: 0;
        }

        .info-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .info-section-content {
            padding: 1rem;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .description-text {
            color: #475569;
            line-height: 1.7;
            margin: 0;
        }

        /* Metadata Grid */
        .metadata-grid {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .metadata-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .metadata-item:hover {
            background: white;
            transform: translateX(5px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .metadata-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(59, 130, 246, 0.1));
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            margin-right: 1rem;
        }

        .metadata-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .metadata-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .metadata-value {
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 600;
        }

        /* Category Footer */
        .profile-footer {
            padding: 1.5rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        /* Statistics Cards */
        .stats-overview {
            animation: fadeInUp 0.6s ease-out;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            height: 100%;
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
            font-size: 0.85rem;
            color: #64748b;
            margin: 0;
            font-weight: 500;
        }

        /* Articles Card */
        .articles-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .articles-header {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .articles-title {
            margin: 0;
            font-weight: 700;
            color: #1e293b;
            font-size: 1.1rem;
        }

        .articles-count {
            background: rgba(37, 99, 235, 0.1);
            color: #2563eb;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .articles-body {
            padding: 1.5rem 2rem;
            max-height: 600px;
            overflow-y: auto;
        }

        /* Article Item */
        .article-item {
            display: flex;
            gap: 1.25rem;
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.25rem;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            background: #f8fafc;
        }

        .article-item:last-child {
            margin-bottom: 0;
        }

        .article-item:hover {
            background: white;
            border-color: #e2e8f0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
            transform: translateX(5px);
        }

        .article-thumbnail {
            width: 100px;
            height: 100px;
            flex-shrink: 0;
            border-radius: 10px;
            overflow: hidden;
            background: #e2e8f0;
        }

        .article-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .article-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(59, 130, 246, 0.05));
            color: #2563eb;
            font-size: 2rem;
        }

        .article-content {
            flex: 1;
            min-width: 0;
        }

        .article-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .article-title a {
            color: #1e293b;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .article-title a:hover {
            color: #2563eb;
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            font-size: 0.8rem;
            color: #64748b;
        }

        .article-author,
        .article-date {
            display: inline-flex;
            align-items: center;
        }

        .article-excerpt {
            font-size: 0.875rem;
            color: #64748b;
            line-height: 1.6;
            margin: 0;
        }

        .article-actions {
            display: flex;
            align-items: center;
        }

        /* Badge Styles */
        .badge {
            padding: 0.35rem 0.8rem;
            border-radius: 20px;
            font-size: 0.7rem;
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

        .badge-secondary {
            background: rgba(100, 116, 139, 0.15);
            color: #64748b;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state i {
            opacity: 0.3;
        }

        /* Animations */
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

        /* Responsive */
        @media (max-width: 768px) {
            .category-icon {
                width: 80px;
                height: 80px;
                font-size: 2.5rem;
            }

            .category-name {
                font-size: 1.5rem;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .article-item {
                flex-direction: column;
            }

            .article-thumbnail {
                width: 100%;
                height: 150px;
            }

            .articles-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .action-buttons-container {
                flex-direction: column;
            }

            .action-buttons-container .btn {
                width: 100%;
                min-width: auto;
            }
        }
    </style>

    <script>
        function prepareDelete(id, nama) {
            document.getElementById('delete_id').textContent = '#' + id;
            document.getElementById('delete_nama').textContent = nama;

            let url = "{{ route('admin.kategori.destroy', ':id') }}";
            url = url.replace(':id', id);
            document.getElementById('deleteCategoryForm').action = url;
        }

        function loadEditData(id, nama, deskripsi) {
            document.getElementById('editId').value = id;
            document.getElementById('edit_nama_kategori').value = nama;
            document.getElementById('edit_deskripsi').value = deskripsi;
        }
    </script>

@endsection
