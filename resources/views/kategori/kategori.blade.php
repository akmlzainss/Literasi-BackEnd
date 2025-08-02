@extends('layouts.app')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori Artikel')

@section('content')
<link rel="stylesheet" href="css/kategori.css">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Kelola Kategori</h1>
        <p class="page-subtitle">Atur dan kelola semua kategori artikel literasi akhlak untuk sistem pembelajaran</p>
        
        <div class="action-buttons">
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                <i class="fas fa-plus"></i>
                Tambah Kategori Baru
            </button>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-upload"></i>
                Import Kategori
            </a>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-download"></i>
                Export Data
            </a>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahKategoriLabel">Tambah Kategori Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Kategori (opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="warna" class="form-label">Warna Kategori</label>
                            <input type="color" name="warna" id="warna" class="form-control form-control-color" value="#2563eb">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan Kategori</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-tags me-2"></i>Daftar Kategori
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: 12 kategori</span>
            </div>
        </div>
        
        <div class="card-body-custom">
            <!-- Search and Filter Section -->
            <div class="search-filter-section">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control search-input border-start-0" placeholder="Cari kategori...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select filter-select">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-secondary w-100" style="border-radius: 12px;">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="categories-grid">
                <div class="row g-4">
                    <!-- Category Card 1 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="category-card fade-in">
                            <div class="category-header" style="background: linear-gradient(135deg, #2563eb, #60a5fa);">
                                <h5 class="category-title">Literasi Digital</h5>
                                <span class="category-status status-active">Aktif</span>
                            </div>
                            <div class="category-content">
                                <p class="category-description">Kategori untuk artikel yang membahas pentingnya literasi digital di era modern.</p>
                                <div class="category-meta">
                                    <span><i class="fas fa-newspaper"></i> 45 Artikel</span>
                                    <span><i class="fas fa-eye"></i> 12,345</span>
                                </div>
                                <div class="category-actions">
                                    <button class="btn-action-card btn-view-card">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action-card btn-edit-card">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action-card btn-delete-card">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Card 2 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="category-card fade-in">
                            <div class="category-header" style="background: linear-gradient(135deg, #10b981, #34d399);">
                                <h5 class="category-title">Karakter Islami</h5>
                                <span class="category-status status-active">Aktif</span>
                            </div>
                            <div class="category-content">
                                <p class="category-description">Berisi artikel tentang pembangunan karakter Islami pada siswa.</p>
                                <div class="category-meta">
                                    <span><i class="fas fa-newspaper"></i> 32 Artikel</span>
                                    <span><i class="fas fa-eye"></i> 9,876</span>
                                </div>
                                <div class="category-actions">
                                    <button class="btn-action-card btn-view-card">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action-card btn-edit-card">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action-card btn-delete-card">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Card 3 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="category-card fade-in">
                            <div class="category-header" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                                <h5 class="category-title">Akhlak Mulia</h5>
                                <span class="category-status status-inactive">Nonaktif</span>
                            </div>
                            <div class="category-content">
                                <p class="category-description">Artikel tentang implementasi nilai-nilai akhlak mulia dalam kehidupan sehari-hari.</p>
                                <div class="category-meta">
                                    <span><i class="fas fa-newspaper"></i> 28 Artikel</span>
                                    <span><i class="fas fa-eye"></i> 7,654</span>
                                </div>
                                <div class="category-actions">
                                    <button class="btn-action-card btn-view-card">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action-card btn-edit-card">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action-card btn-delete-card">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Card 4 -->
                    <div class="col-lg-4 col-md-6">
                        <div class="category-card fade-in">
                            <div class="category-header" style="background: linear-gradient(135deg, #06b6d4, #22d3ee);">
                                <h5 class="category-title">Kearifan Lokal</h5>
                                <span class="category-status status-active">Aktif</span>
                            </div>
                            <div class="category-content">
                                <p class="category-description">Melestarikan nilai-nilai kearifan lokal melalui artikel pendidikan.</p>
                                <div class="category-meta">
                                    <span><i class="fas fa-newspaper"></i> 19 Artikel</span>
                                    <span><i class="fas fa-eye"></i> 5,432</span>
                                </div>
                                <div class="category-actions">
                                    <button class="btn-action-card btn-view-card">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action-card btn-edit-card">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action-card btn-delete-card">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection