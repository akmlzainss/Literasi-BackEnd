@extends('layouts.app')

@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan Sistem Literasi Akhlak')

@section('content')
<link rel="stylesheet" href="css/pengaturan.css">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Pengaturan Sistem</h1>
        <p class="page-subtitle">Kelola pengaturan sistem untuk mendukung operasional literasi akhlak</p>
        
        <div class="action-buttons">
            <button type="button" class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalUpdateSettings">
                <i class="fas fa-cog"></i>
                Ubah Pengaturan
            </button>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-undo"></i>
                Reset ke Default
            </a>
        </div>
    </div>

    <!-- Modal Update Settings -->
    <div class="modal fade" id="modalUpdateSettings" tabindex="-1" aria-labelledby="modalUpdateSettingsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUpdateSettingsLabel">Ubah Pengaturan Sistem</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_sistem" class="form-label">Nama Sistem</label>
                            <input type="text" name="nama_sistem" id="nama_sistem" class="form-control" value="Sistem Literasi Akhlak" required>
                        </div>
                        <div class="mb-3">
                            <label for="maks_artikel" class="form-label">Maksimal Artikel per Siswa (per Bulan)</label>
                            <input type="number" name="maks_artikel" id="maks_artikel" class="form-control" value="5" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="notifikasi_email" class="form-label">Notifikasi Email</label>
                            <select name="notifikasi_email" id="notifikasi_email" class="form-control">
                                <option value="enabled">Aktif</option>
                                <option value="disabled">Nonaktif</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tema_sistem" class="form-label">Tema Sistem</label>
                            <select name="tema_sistem" id="tema_sistem" class="form-control">
                                <option value="light">Terang</option>
                                <option value="dark">Gelap</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="timezone" class="form-label">Zona Waktu</label>
                            <input type="text" name="timezone" id="timezone" class="form-control" value="Asia/Jakarta" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan Pengaturan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
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
                <span>Total: 20 aktivitas</span>
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
                            <option value="pengaturan">Ubah Pengaturan</option>
                            <option value="artikel">Upload Artikel</option>
                            <option value="kategori">Upload Kategori</option>
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
                                <td>2025-07-30 20:53:00 WIB</td>
                                <td>Mart Riay</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <span class="activity-type">Ubah Pengaturan</span>
                                </td>
                                <td>Admin mengubah pengaturan maksimal artikel per siswa menjadi 5</td>
                                <td>2025-07-30 15:30:00 WIB</td>
                                <td>Mart Riay</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    <span class="activity-type">Upload Artikel</span>
                                </td>
                                <td>Admin mengunggah artikel "Penerapan Kejujuran dalam Kehidupan Sehari-hari"</td>
                                <td>2025-07-30 14:25:00 WIB</td>
                                <td>Mart Riay</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>
                                    <span class="activity-type">Upload Kategori</span>
                                </td>
                                <td>Admin menambahkan kategori baru "Toleransi"</td>
                                <td>2025-07-30 10:15:00 WIB</td>
                                <td>Mart Riay</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>
                                    <span class="activity-type">Ubah Pengaturan</span>
                                </td>
                                <td>Admin mengubah zona waktu sistem ke Asia/Jakarta</td>
                                <td>2025-07-29 09:00:00 WIB</td>
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