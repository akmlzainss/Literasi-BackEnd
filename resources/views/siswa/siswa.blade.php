@extends('layouts.app')

@section('title', 'Kelola Siswa')
@section('page-title', 'Kelola Siswa')

@section('content')
<link rel="stylesheet" href="css/siswa.css">
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
@endsection