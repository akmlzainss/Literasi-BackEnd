@extends('layouts.app')
@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <h6 class="mb-0 fw-bold text-primary">Selamat datang kembali, Admin!</h6>
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
            <div class="text-center mb-5">
                <h1 class="page-title">Dashboard Admin</h1>
                <p class="subtitle">Kelola data sistem literasi akhlak dengan mudah dan efisien</p>
            </div>

            <!-- Stats Cards -->
            <div class="row stats-row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stats-card primary">
                        <div class="stats-icon primary">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h5 class="stats-title">Total Artikel</h5>
                        <div class="stats-number">245</div>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn-custom btn-outline-custom">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                            <a href="#" class="btn-custom btn-primary-custom">
                                <i class="fas fa-plus me-1"></i>Tambah
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stats-card success">
                        <div class="stats-icon success">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h5 class="stats-title">Total Kategori</h5>
                        <div class="stats-number">18</div>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn-custom btn-outline-custom">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                            <a href="#" class="btn-custom btn-primary-custom">
                                <i class="fas fa-plus me-1"></i>Tambah
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stats-card warning">
                        <div class="stats-icon warning">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h5 class="stats-title">Total Penghargaan</h5>
                        <div class="stats-number">12</div>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn-custom btn-outline-custom">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                            <a href="#" class="btn-custom btn-primary-custom">
                                <i class="fas fa-plus me-1"></i>Tambah
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stats-card info">
                        <div class="stats-icon info">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h5 class="stats-title">Total Siswa</h5>
                        <div class="stats-number">1,247</div>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn-custom btn-outline-custom">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                            <a href="#" class="btn-custom btn-primary-custom">
                                <i class="fas fa-plus me-1"></i>Tambah
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="charts-grid">
                <!-- Main Chart -->
                <div class="chart-card">
                    <div class="chart-header">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Data Bulanan
                    </div>
                    <div class="chart-body">
                        <div class="chart-container">
                            <canvas id="chartStatistik"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="chart-card">
                    <div class="chart-header">
                        <i class="fas fa-chart-pie me-2"></i>Distribusi Kategori
                    </div>
                    <div class="chart-body">
                        <div class="small-chart-container">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Line Chart -->
            <div class="main-card">
                <div class="card-header-custom">
                    <i class="fas fa-chart-line me-2"></i>Trend Aktivitas 7 Hari Terakhir
                </div>
                <div class="card-body-custom">
                    <div class="chart-container">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Activity Table -->
            <div class="main-card">
                <div class="card-header-custom">
                    <i class="fas fa-clock me-2"></i>Aktivitas Terbaru
                </div>
                <div class="card-body-custom">
                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-list-ul me-2"></i>Aktivitas</th>
                                    <th><i class="fas fa-user me-2"></i>Pengguna</th>
                                    <th><i class="fas fa-calendar me-2"></i>Tanggal</th>
                                    <th><i class="fas fa-cog me-2"></i>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="activity-icon me-3">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                            <div>
                                                <strong>Artikel Baru Ditambahkan</strong>
                                                <br>
                                                <small class="text-muted">"Pentingnya Literasi Digital dalam Era Modern"</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <strong>Dra. Siti Nurhaliza</strong>
                                                <br>
                                                <small class="text-muted">guru@smkn11bdg.sch.id</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>28 Jul 2025</strong>
                                        <br>
                                        <small class="text-muted">10:30 WIB</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-success rounded-pill">Berhasil</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="activity-icon me-3">
                                                <i class="fas fa-user-plus"></i>
                                            </div>
                                            <div>
                                                <strong>Siswa Baru Terdaftar</strong>
                                                <br>
                                                <small class="text-muted">Registrasi akun siswa baru</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                <i class="fas fa-user-graduate"></i>
                                            </div>
                                            <div>
                                                <strong>Ahmad Hidayat Ramadhan</strong>
                                                <br>
                                                <small class="text-muted">XII RPL 1 - 2023456789</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>28 Jul 2025</strong>
                                        <br>
                                        <small class="text-muted">09:15 WIB</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary rounded-pill">Aktif</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="activity-icon me-3">
                                                <i class="fas fa-edit"></i>
                                            </div>
                                            <div>
                                                <strong>Kategori Diperbarui</strong>
                                                <br>
                                                <small class="text-muted">Kategori "Akhlak Mulia" diubah deskripsinya</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                <i class="fas fa-user-cog"></i>
                                            </div>
                                            <div>
                                                <strong>Super Admin</strong>
                                                <br>
                                                <small class="text-muted">admin@smkn11bdg.sch.id</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>27 Jul 2025</strong>
                                        <br>
                                        <small class="text-muted">16:45 WIB</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-success rounded-pill">Berhasil</span>





    {{-- Tombol Logout --}}
    <form id="logout-form" action="{{ route('logout.admin') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>

    <br><br>

   
</body>

</html>
