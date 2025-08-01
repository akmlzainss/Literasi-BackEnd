@extends('layouts.app')

@section('title', 'Kelola Siswa')
@section('page-title', 'Kelola Siswa')

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Kelola Siswa</h1>
        <p class="page-subtitle">Kelola dan pantau data siswa beserta prestasi dan aktivitas literasi akhlak mereka</p>
        
        <div class="action-buttons">
            <a href="#" class="btn-primary-custom">
                <i class="fas fa-user-plus"></i>
                Tambah Siswa Baru
            </a>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-upload"></i>
                Import Data Siswa
            </a>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-download"></i>
                Export Data
            </a>
            <a href="#" class="btn-outline-custom">
                <i class="fas fa-award"></i>
                Kelola Prestasi
            </a>
        </div>
    </div>

    <!-- Main Card: Students Table -->
    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="fas fa-user-graduate me-2"></i>Daftar Siswa
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: 1,247 siswa</span>
            </div>
        </div>
        
        <div class="card-body-custom">
            <!-- Search and Filter Section -->
            <div class="search-filter-section">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control search-input border-start-0" placeholder="Cari siswa...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select filter-select">
                            <option value="">Semua Kelas</option>
                            <option value="x">Kelas X</option>
                            <option value="xi">Kelas XI</option>
                            <option value="xii">Kelas XII</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select filter-select">
                            <option value="">Semua Jurusan</option>
                            <option value="rpl">RPL</option>
                            <option value="tkj">TKJ</option>
                            <option value="mm">Multimedia</option>
                            <option value="akl">AKL</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select filter-select">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                            <option value="graduated">Lulus</option>
                        </select>
                    </div>
                    <div class="col-md-3">
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

            <!-- Students Table -->
            <div class="students-table">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">NIS</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Email</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Jurusan</th>
                                <th scope="col">Total Artikel</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>1001</td>
                                <td>
                                    <div class="student-name">Akmal Zains</div>
                                </td>
                                <td>
                                    <div class="student-email">akmal.zains@student.smkn11bdg.sch.id</div>
                                </td>
                                <td>
                                    <span class="class-badge">XII RPL 2</span>
                                </td>
                                <td>RPL</td>
                                <td>
                                    <span class="article-count">
                                        <i class="fas fa-newspaper"></i>
                                        10
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-active">Aktif</span>
                                </td>
                                <td>
                                    <div class="action-buttons-table">
                                        <button class="btn-action-table btn-view-table" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-action-table btn-edit-table" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-action-table btn-delete-table" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>1002</td>
                                <td>
                                    <div class="student-name">Bayu Resmadi</div>
                                </td>
                                <td>
                                    <div class="student-email">bayu.resmadi@student.smkn11bdg.sch.id</div>
                                </td>
                                <td>
                                    <span class="class-badge">XII RPL 2</span>
                                </td>
                                <td>RPL</td>
                                <td>
                                    <span class="article-count">
                                        <i class="fas fa-newspaper"></i>
                                        5
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-active">Aktif</span>
                                </td>
                                <td>
                                    <div class="action-buttons-table">
                                        <button class="btn-action-table btn-view-table" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-action-table btn-edit-table" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-action-table btn-delete-table" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>1003</td>
                                <td>
                                    <div class="student-name">Carin Zuleyka</div>
                                </td>
                                <td>
                                    <div class="student-email">carin.zuleyka@student.smkn11bdg.sch.id</div>
                                </td>
                                <td>
                                    <span class="class-badge">XII RPL 2</span>
                                </td>
                                <td>RPL</td>
                                <td>
                                    <span class="article-count">
                                        <i class="fas fa-newspaper"></i>
                                        15
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-active">Aktif</span>
                                </td>
                                <td>
                                    <div class="action-buttons-table">
                                        <button class="btn-action-table btn-view-table" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-action-table btn-edit-table" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-action-table btn-delete-table" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>1004</td>
                                <td>
                                    <div class="student-name">Dwi Alifa</div>
                                </td>
                                <td>
                                    <div class="student-email">dwi.alifa@student.smkn11bdg.sch.id</div>
                                </td>
                                <td>
                                    <span class="class-badge">XII RPL 2</span>
                                </td>
                                <td>RPL</td>
                                <td>
                                    <span class="article-count">
                                        <i class="fas fa-newspaper"></i>
                                        10
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-active">Aktif</span>
                                </td>
                                <td>
                                    <div class="action-buttons-table">
                                        <button class="btn-action-table btn-view-table" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-action-table btn-edit-table" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-action-table btn-delete-table" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>1005</td>
                                <td>
                                    <div class="student-name">Nabila</div>
                                </td>
                                <td>
                                    <div class="student-email">nabila@student.smkn11bdg.sch.id</div>
                                </td>
                                <td>
                                    <span class="class-badge">XII RPL 2</span>
                                </td>
                                <td>RPL</td>
                                <td>
                                    <span class="article-count">
                                        <i class="fas fa-newspaper"></i>
                                        10
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-active">Aktif</span>
                                </td>
                                <td>
                                    <div class="action-buttons-table">
                                        <button class="btn-action-table btn-view-table" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-action-table btn-edit-table" title="Edit">
                                            <i class="fas fa-edit"></i>
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

        .students-table {
            margin-top: 1rem;
        }

        .table-responsive {
            border-radius: 15px;
            overflow-x: auto;
            box-shadow: var(--shadow);
        }

        .custom-table {
            margin: 0;
            background: var(--bg-white);
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

        .student-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.2rem;
        }

        .student-email {
            color: var(--text-light);
            font-size: 0.8rem;
            font-style: italic;
        }

        .class-badge {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-blue);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
        }

        .status-graduated {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
        }

        .article-count {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
            padding: 0.3rem 0.7rem;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .action-buttons-table {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .btn-action-table {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.8rem;
        }

        .btn-view-table {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-blue);
        }

        .btn-view-table:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
        }

        .btn-edit-table {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .btn-edit-table:hover {
            background: var(--warning);
            color: white;
            transform: translateY(-2px);
        }

        .btn-delete-table {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .btn-delete-table:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
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
        document.querySelectorAll('.btn-action-table').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.querySelector('i').classList;
                if (action.contains('fa-eye')) {
                    alert('Membuka detail siswa...');
                } else if (action.contains('fa-edit')) {
                    alert('Membuka form edit siswa...');
                } else if (action.contains('fa-trash')) {
                    if (confirm('Apakah Anda yakin ingin menghapus data siswa ini?')) {
                        alert('Data siswa berhasil dihapus!');
                    }
                }
            });
        });
    </script>
@endsection