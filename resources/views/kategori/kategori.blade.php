@extends('layouts.app')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori Artikel')

@section('content')
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

    <style>
        .page-header {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(37, 99, 235, 0.1);
        }

        .page-title {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--text-light);
            font-weight: 400;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            color: white;
        }

        .btn-outline-custom {
            background: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-custom:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
        }

        .main-card {
            background: var(--bg-white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            border: none;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            padding: 1.5rem 2rem;
            border: none;
            font-weight: 600;
            font-size: 1.2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-body-custom {
            padding: 2rem;
        }

        .search-filter-section {
            background: var(--bg-light);
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .search-input {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .search-input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .filter-select {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            background: white;
            transition: all 0.3s ease;
        }

        .filter-select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .categories-grid {
            margin-top: 1rem;
        }

        .category-card {
            background: var(--bg-white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            height: 100%;
            border: 1px solid rgba(37, 99, 235, 0.1);
            position: relative;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .category-header {
            padding: 1.5rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .category-title {
            font-weight: 700;
            font-size: 1.3rem;
            margin: 0;
            line-height: 1.4;
        }

        .category-status {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: rgba(255, 255, 255, 0.2);
        }

        .status-active {
            color: #10b981;
            background: rgba(16, 185, 129, 0.2);
        }

        .status-inactive {
            color: #f59e0b;
            background: rgba(245, 158, 11, 0.2);
        }

        .category-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .category-description {
            color: var(--text-light);
            font-size: 0.9rem;
            line-height: 1.6;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .category-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .category-meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .category-meta i {
            font-size: 0.7rem;
        }

        .category-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .btn-action-card {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .btn-view-card {
            background: rgba(37, 99, 235, 0.9);
            color: white;
        }

        .btn-view-card:hover {
            background: var(--primary-blue);
            transform: scale(1.1);
        }

        .btn-edit-card {
            background: rgba(245, 158, 11, 0.9);
            color: white;
        }

        .btn-edit-card:hover {
            background: var(--warning);
            transform: scale(1.1);
        }

        .btn-delete-card {
            background: rgba(239, 68, 68, 0.9);
            color: white;
        }

        .btn-delete-card:hover {
            background: var(--danger);
            transform: scale(1.1);
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 576px) {
            .page-header {
                padding: 1rem;
            }

            .category-title {
                font-size: 1.1rem;
            }

            .category-actions {
                justify-content: center;
            }
        }
    </style>
@endsection