@extends('layouts.app')

@section('title', 'Kelola Laporan')
@section('page-title', 'Kelola Laporan Literasi Akhlak')

@section('content')
<link rel="stylesheet" href="css/laporan.css">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Kelola Laporan</h1>
        <p class="page-subtitle">Pantau dan analisis data literasi akhlak siswa serta aktivitas admin melalui laporan terperinci</p>
        
        <div class="action-buttons">
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalGenerateLaporan">
                <i class="fas fa-plus"></i>
                Generate Laporan Baru
            </button>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-download"></i>
                Export Laporan
            </a>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-print"></i>
                Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Modal Generate Laporan -->
    <div class="modal fade" id="modalGenerateLaporan" tabindex="-1" aria-labelledby="modalGenerateLaporanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalGenerateLaporanLabel">Generate Laporan Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="judul_laporan" class="form-label">Judul Laporan</label>
                            <input type="text" name="judul_laporan" id="judul_laporan" class="form-control" placeholder="Contoh: Laporan Artikel Bulanan 2025" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipe_laporan" class="form-label">Tipe Laporan</label>
                            <select name="tipe_laporan" id="tipe_laporan" class="form-control">
                                <option value="artikel">Artikel Literasi</option>
                                <option value="penghargaan">Penghargaan</option>
                                <option value="siswa">Aktivitas Siswa</option>
                                <option value="kategori">Kategori Artikel</option>
                                <option value="admin_activity">Aktivitas Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="periode" class="form-label">Periode</label>
                            <input type="text" name="periode" id="periode" class="form-control" placeholder="Contoh: Januari 2025" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Generate Laporan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Card: Reports Table -->
    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-chart-line me-2"></i>Daftar Laporan
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: 25 laporan</span>
            </div>
        </div>
        
        <div class="card-body-custom">
            <!-- Search and Filter Section -->
            <div class="search-filter-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control search-input border-start-0" placeholder="Cari laporan...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select filter-select">
                            <option value="">Semua Tipe</option>
                            <option value="artikel">Artikel</option>
                            <option value="penghargaan">Penghargaan</option>
                            <option value="siswa">Siswa</option>
                            <option value="kategori">Kategori</option>
                            <option value="admin_activity">Aktivitas Admin</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select filter-select">
                            <option value="">Semua Periode</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary flex-fill" style="border-radius: 12px;">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                            <button class="btn btn-outline-success" style="border-radius: 12px;">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Table -->
            <div class="reports-table">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Judul Laporan</th>
                                <th scope="col">Tipe</th>
                                <th scope="col">Periode</th>
                                <th scope="col">Tanggal Dibuat</th>
                                <th scope="col">Total Data</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="report-title">Laporan Artikel Bulanan Januari 2025</div>
                                </td>
                                <td>Artikel</td>
                                <td>Januari 2025</td>
                                <td>2025-01-31</td>
                                <td>
                                    <span class="data-count">
                                        <i class="fas fa-database"></i>
                                        245
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-completed">Selesai</span>
                                </td>
                                <td>
                                    <div class="action-buttons-table">
                                        <button class="btn-action-table btn-view-table" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-action-table btn-download-table" title="Download">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <button class="btn-action-table btn-delete-table" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <div class="report-title">Laporan Penghargaan Q1 2025</div>
                                </td>
                                <td>Penghargaan</td>
                                <td>Q1 2025</td>
                                <td>2025-03-31</td>
                                <td>
                                    <span class="data-count">
                                        <i class="fas fa-database"></i>
                                        12
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-completed">Selesai</span>
                                </td>
                                <td>
                                    <div class="action-buttons-table">
                                        <button class="btn-action-table btn-view-table" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-action-table btn-download-table" title="Download">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <button class="btn-action-table btn-delete-table" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    <div class="report-title">Laporan Aktivitas Siswa 2025</div>
                                </td>
                                <td>Siswa</td>
                                <td>2025</td>
                                <td>2025-07-30</td>
                                <td>
                                    <span class="data-count">
                                        <i class="fas fa-database"></i>
                                        1,247
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-processing">Sedang Diproses</span>
                                </td>
                                <td>
                                    <div class="action-buttons-table">
                                        <button class="btn-action-table btn-view-table" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-action-table btn-download-table" title="Download">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <button class="btn-action-table btn-delete-table" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>
                                    <div class="report-title">Laporan Kategori Artikel 2025</div>
                                </td>
                                <td>Kategori</td>
                                <td>2025</td>
                                <td>2025-07-30</td>
                                <td>
                                    <span class="data-count">
                                        <i class="fas fa-database"></i>
                                        18
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-completed">Selesai</span>
                                </td>
                                <td>
                                    <div class="action-buttons-table">
                                        <button class="btn-action-table btn-view-table" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-action-table btn-download-table" title="Download">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <button class="btn-action-table btn-delete-table" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="pagination-custom">
                    <button class="page-btn">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Logs Card -->
    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-user-clock me-2"></i>Log Aktivitas Admin
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: 50 aktivitas</span>
            </div>
        </div>
        
        <div class="card-body-custom">
            <!-- Search and Filter Section for Logs -->
            <div class="search-filter-section">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control search-input border-start-0" placeholder="Cari aktivitas...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select filter-select">
                            <option value="">Semua Tipe Aktivitas</option>
                            <option value="login">Login</option>
                            <option value="artikel">Upload Artikel</option>
                            <option value="kategori">Upload Kategori</option>
                            <option value="penghargaan">Kelola Penghargaan</option>
                            <option value="siswa">Kelola Siswa</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select filter-select">
                            <option value="">Semua Tanggal</option>
                            <option value="2025-07-30">30 Juli 2025</option>
                            <option value="2025-07-29">29 Juli 2025</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-secondary flex-fill" style="border-radius: 12px;">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                            <button class="btn btn-outline-success" style="border-radius: 12px;">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Logs Table -->
            <div class="activity-logs-table">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Tipe Aktivitas</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <span class="activity-type">Login</span>
                                </td>
                                <td>Admin Mart Riay login ke sistem</td>
                                <td>2025-07-30 20:43:00 WIB</td>
                                <td>Mart Riay</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <span class="activity-type">Upload Artikel</span>
                                </td>
                                <td>Admin mengunggah artikel "Penerapan Kejujuran dalam Kehidupan Sehari-hari"</td>
                                <td>2025-07-30 14:25:00 WIB</td>
                                <td>Mart Riay</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    <span class="activity-type">Upload Kategori</span>
                                </td>
                                <td>Admin menambahkan kategori baru "Toleransi"</td>
                                <td>2025-07-30 10:15:00 WIB</td>
                                <td>Mart Riay</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>
                                    <span class="activity-type">Kelola Penghargaan</span>
                                </td>
                                <td>Admin membuat penghargaan "Artikel Terbaik Juli 2025"</td>
                                <td>2025-07-29 16:30:00 WIB</td>
                                <td>Mart Riay</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>
                                    <span class="activity-type">Kelola Siswa</span>
                                </td>
                                <td>Admin menambahkan data siswa baru "Ahmad Reza Pratama"</td>
                                <td>2025-07-29 09:45:00 WIB</td>
                                <td>Mart Riay</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="pagination-custom">
                    <button class="page-btn">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection