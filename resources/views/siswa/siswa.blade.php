<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Siswa - SMKN 11 Bandung</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --sidebar-width: 280px;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --purple: #8b5cf6;
            --pink: #ec4899;
            --indigo: #6366f1;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
            min-height: 100vh;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--dark-blue) 0%, var(--primary-blue) 100%);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            width: 60px;
            height: 60px;
            background: var(--bg-white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
            color: var(--primary-blue);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }

        .sidebar-title {
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            margin: 0;
        }

        .sidebar-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            margin: 0;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.2rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: white;
            border-radius: 0 4px 4px 0;
        }

        .nav-icon {
            width: 20px;
            margin-right: 1rem;
            text-align: center;
        }

        .nav-text {
            flex: 1;
        }

        .nav-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Mobile Toggle */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: var(--primary-blue);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.5rem;
            width: 40px;
            height: 40px;
            box-shadow: var(--shadow);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .topbar {
            background: var(--bg-white);
            padding: 1rem 2rem;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left {
            flex: 1;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: var(--bg-light);
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-profile:hover {
            background: var(--primary-blue);
            color: white;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .content-area {
            padding: 2rem;
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

        /* Table Styles */
        .students-table {
            margin-top: 1rem;
        }

        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .custom-table {
            margin: 0;
            background: white;
            border: none;
        }

        .custom-table thead {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
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

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block;
            }
            
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
            .topbar {
                padding: 1rem;
            }
            
            .user-profile span {
                display: none;
            }
            
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
</head>
<body>
    <!-- Sidebar Toggle for Mobile -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h5 class="sidebar-title">SMKN 11 Bandung</h5>
            <p class="sidebar-subtitle">Sistem Literasi Akhlak</p>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{route('admin.dashboard')}}" class="nav-link">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{route('artikel.artikel')}}" class="nav-link">
                    <i class="fas fa-newspaper nav-icon"></i>
                    <span class="nav-text">Artikel</span>
                    <span class="nav-badge">245</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{route('kategori.kategori')}}" class="nav-link">
                    <i class="fas fa-tags nav-icon"></i>
                    <span class="nav-text">Kategori</span>
                    <span class="nav-badge">18</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{route('penghargaan.penghargaan')}}" class="nav-link">
                    <i class="fas fa-trophy nav-icon"></i>
                    <span class="nav-text">Penghargaan</span>
                    <span class="nav-badge">12</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{route('siswa.siswa')}}" class="nav-link active">
                    <i class="fas fa-user-graduate nav-icon"></i>
                    <span class="nav-text">Siswa</span>
                    <span class="nav-badge">1.2K</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{route('laporan.laporan')}}" class="nav-link">
                    <i class="fas fa-chart-line nav-icon"></i>
                    <span class="nav-text">Laporan</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{route('pengaturan.pengaturan')}}" class="nav-link">
                    <i class="fas fa-cog nav-icon"></i>
                    <span class="nav-text">Pengaturan</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <h6 class="mb-0 fw-bold text-primary">Kelola Data Siswa</h6>
            </div>
            <div class="topbar-right">
                <div class="user-profile">
                    <div class="user-avatar">
                        A
                    </div>
                    <span class="fw-semibold">Admin</span>
                    <i class="fas fa-chevron-down ms-1"></i>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area fade-in">
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

            <!-- Main Card -->
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
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Total Artikel</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
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
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth <= 992) {
                if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 992) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>
</html>