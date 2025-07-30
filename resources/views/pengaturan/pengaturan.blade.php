@extends('layouts.app')

@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan Sistem Literasi Akhlak')

@section('content')
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

    <style>
        :root {
            --primary-blue: #2563eb;
            --light-blue: #3b82f6;
            --dark-blue: #1e40af;
            --accent-blue: #60a5fa;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

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

        .activity-logs-table {
            margin-top: 1rem;
        }

        .table-responsive {
            border-radius: 15px;
            overflow-x: auto;
            box-shadow: var(--shadow);
        }

        .custom-table {
            margin: 0;
            background: white;
            border-collapse: separate;
            border-spacing: 0;
        }

        .custom-table thead {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .custom-table thead th {
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1.2rem 1rem;
            border: none;
            vertical-align: middle;
            text-align: center;
            white-space: nowrap;
        }

        .custom-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e2e8f0;
        }

        .custom-table tbody tr:hover {
            background: rgba(37, 99, 235, 0.05);
            transform: scale(1.01);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .custom-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border: none;
            font-size: 0.9rem;
            text-align: center;
        }

        .activity-type {
            font-weight: 600;
            color: var(--primary-blue);
        }

        .pagination-custom {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .page-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            font-weight: 600;
        }

        .page-btn:hover, .page-btn.active {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
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

        @media (max-width: 992px) {
            .content-area {
                padding: 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .custom-table {
                font-size: 0.8rem;
            }

            .custom-table thead th,
            .custom-table tbody td {
                padding: 0.75rem 0.5rem;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 1rem;
            }

            .card-body-custom {
                padding: 1rem;
            }

            .search-filter-section {
                padding: 1rem;
            }

            .search-filter-section .row > * {
                margin-bottom: 0.5rem;
            }
        }

        @media (max-width: 576px) {
            .action-buttons-table {
                flex-direction: column;
                gap: 0.3rem;
            }

            .btn-action-table {
                width: 30px;
                height: 30px;
                font-size: 0.7rem;
            }
        }
    </style>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Pengaturan berhasil disimpan!');
            this.closest('.modal').querySelector('.btn-close').click();
        });
    </script>
@endsection