@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <!-- Content Area -->
    <div class="content-area fade-in">
        <!-- Page Header -->
        <div class="text-center mb-5 header-section">
            <h1 class="page-title gradient-text">Dashboard Admin</h1>
            <p class="subtitle">Kelola data sistem literasi akhlak | <small class="text-muted pulse-text">Update: {{ date('d M Y, H:i A') }} WIB</small></p>
        </div>

        <!-- Stats Cards (Kotak-kotak) -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stats-card primary enhanced-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stats-icon primary">
                        <i class="fas fa-newspaper pulse-icon"></i>
                    </div>
                    <h5 class="stats-title">Total Artikel</h5>
                    <div class="stats-number counter" data-target="245">0</div>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up text-success"></i>
                        <span class="text-success">+12% dari bulan lalu</span>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="#" class="btn btn-sm btn-outline-primary hover-lift">
                            <i class="fas fa-eye me-1"></i> Detail
                        </a>
                        <a href="#" class="btn btn-sm btn-primary hover-lift">
                            <i class="fas fa-plus me-1"></i> Tambah
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stats-card success enhanced-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stats-icon success">
                        <i class="fas fa-tags pulse-icon"></i>
                    </div>
                    <h5 class="stats-title">Total Kategori</h5>
                    <div class="stats-number counter" data-target="18">0</div>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up text-success"></i>
                        <span class="text-success">+2 kategori baru</span>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="#" class="btn btn-sm btn-outline-success hover-lift">
                            <i class="fas fa-eye me-1"></i> Detail
                        </a>
                        <a href="#" class="btn btn-sm btn-success hover-lift">
                            <i class="fas fa-plus me-1"></i> Tambah
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stats-card warning enhanced-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="stats-icon warning">
                        <i class="fas fa-trophy pulse-icon"></i>
                    </div>
                    <h5 class="stats-title">Total Penghargaan</h5>
                    <div class="stats-number counter" data-target="12">0</div>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up text-success"></i>
                        <span class="text-success">+3 penghargaan</span>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="#" class="btn btn-sm btn-outline-warning hover-lift">
                            <i class="fas fa-eye me-1"></i> Detail
                        </a>
                        <a href="#" class="btn btn-sm btn-warning hover-lift">
                            <i class="fas fa-plus me-1"></i> Tambah
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stats-card info enhanced-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="stats-icon info">
                        <i class="fas fa-user-graduate pulse-icon"></i>
                    </div>
                    <h5 class="stats-title">Total Siswa</h5>
                    <div class="stats-number counter" data-target="1247">0</div>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up text-success"></i>
                        <span class="text-success">+47 siswa aktif</span>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="#" class="btn btn-sm btn-outline-info hover-lift">
                            <i class="fas fa-eye me-1"></i> Detail
                        </a>
                        <a href="#" class="btn btn-sm btn-info hover-lift">
                            <i class="fas fa-plus me-1"></i> Tambah
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row g-4 mb-4">
            <div class="col-xl-8">
                <div class="card h-100 enhanced-card" data-aos="fade-right">
                    <div class="card-header glass-effect">
                        <i class="fas fa-chart-bar me-2 text-primary"></i> 
                        <span class="fw-bold">Statistik Data Bulanan</span>
                        <div class="card-actions">
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartStatistik"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card h-100 enhanced-card" data-aos="fade-left">
                    <div class="card-header glass-effect">
                        <i class="fas fa-chart-pie me-2 text-success"></i> 
                        <span class="fw-bold">Distribusi Kategori</span>
                        <div class="card-actions">
                            <button class="btn btn-sm btn-outline-success">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-12">
                <div class="card enhanced-card" data-aos="fade-up">
                    <div class="card-header glass-effect">
                        <i class="fas fa-chart-line me-2 text-info"></i> 
                        <span class="fw-bold">Trend Aktivitas 7 Hari Terakhir</span>
                        <div class="card-actions">
                            <select class="form-select form-select-sm" style="width: auto;">
                                <option>7 Hari</option>
                                <option>30 Hari</option>
                                <option>3 Bulan</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Log Section -->
        <div class="row g-4 mt-4">
            <div class="col-12">
                <div class="card enhanced-card" data-aos="fade-up">
                    <div class="card-header glass-effect activity-header">
                        <div class="activity-header-title">
                            <i class="fas fa-clock me-2"></i> 
                            <span class="fw-bold">Aktivitas Terbaru</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- Activity Table Header -->
                        <div class="activity-table-header">
                            <div class="row g-0">
                                <div class="col-5">
                                    <div class="activity-column-header">
                                        <i class="fas fa-tasks me-2 text-primary"></i> Aktivitas
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="activity-column-header">
                                        <i class="fas fa-users me-2 text-success"></i> Pengguna
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="activity-column-header">
                                        <i class="fas fa-calendar-alt me-2 text-info"></i> Tanggal
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="activity-column-header">
                                        <i class="fas fa-flag me-2 text-warning"></i> Status
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Activity List -->
                        <div class="activity-list">
                            <div class="activity-row" data-aos="fade-up" data-aos-delay="100">
                                <div class="row g-0 align-items-center">
                                    <div class="col-5">
                                        <div class="activity-info">
                                            <div class="activity-icon-new success-gradient">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-name">Artikel Baru Ditambahkan</div>
                                                <div class="activity-desc">"Pentingnya Literasi Digital dalam Era Modern"</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">Dra. Siti Nurhaliza</div>
                                                <div class="user-email">guru@smkn1lbdg.sch.id</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="date-info">
                                            <div class="date-main">28 Jul 2025</div>
                                            <div class="date-time">10:30 WIB</div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="status-info">
                                            <span class="badge bg-success">Berhasil</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="activity-row" data-aos="fade-up" data-aos-delay="200">
                                <div class="row g-0 align-items-center">
                                    <div class="col-5">
                                        <div class="activity-info">
                                            <div class="activity-icon-new primary-gradient">
                                                <i class="fas fa-user-plus"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-name">Siswa Baru Terdaftar</div>
                                                <div class="activity-desc">Registrasi akun siswa baru</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="user-info">
                                            <div class="user-avatar info-bg">
                                                <i class="fas fa-user-graduate"></i>
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">Ahmad Hidayat Ramadhan</div>
                                                <div class="user-email">XII RPL 1 - 2023456789</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="date-info">
                                            <div class="date-main">28 Jul 2025</div>
                                            <div class="date-time">09:15 WIB</div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="status-info">
                                            <span class="badge bg-primary">Aktif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="activity-row" data-aos="fade-up" data-aos-delay="300">
                                <div class="row g-0 align-items-center">
                                    <div class="col-5">
                                        <div class="activity-info">
                                            <div class="activity-icon-new warning-gradient">
                                                <i class="fas fa-edit"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-name">Kategori Diperbarui</div>
                                                <div class="activity-desc">Kategori "Akhlak Mulia" diubah deskripsinya</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="user-info">
                                            <div class="user-avatar warning-bg">
                                                <i class="fas fa-user-shield"></i>
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">Super Admin</div>
                                                <div class="user-email">admin@smkn1lbdg.sch.id</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="date-info">
                                            <div class="date-main">27 Jul 2025</div>
                                            <div class="date-time">16:45 WIB</div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="status-info">
                                            <span class="badge bg-success">Berhasil</span>
                                            <a href="#" class="text-primary ms-2 text-decoration-none">Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js and AOS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Counter Animation
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-target'));
            const increment = target / 50;
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 30);
        }

        // Initialize counters when visible
        const counters = document.querySelectorAll('.counter');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        });

        counters.forEach(counter => observer.observe(counter));

        // Enhanced Chart.js configurations
        Chart.defaults.font.family = "'Inter', -apple-system, BlinkMacSystemFont, sans-serif";
        Chart.defaults.font.size = 12;
        Chart.defaults.color = '#6b7280';

        // Bar Chart with enhanced styling
        const ctxStatistik = document.getElementById('chartStatistik').getContext('2d');
        new Chart(ctxStatistik, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Jumlah Artikel',
                    data: [65, 59, 80, 81, 56, 55],
                    backgroundColor: 'rgba(37, 99, 235, 0.8)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });

        // Enhanced Pie Chart
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Akhlak Mulia', 'Karakter Islami', 'Literasi Digital', 'Kearifan Lokal'],
                datasets: [{
                    data: [40, 30, 20, 10],
                    backgroundColor: [
                        'rgba(37, 99, 235, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(6, 182, 212, 0.8)'
                    ],
                    borderColor: [
                        'rgba(37, 99, 235, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(6, 182, 212, 1)'
                    ],
                    borderWidth: 3,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    duration: 2000
                }
            }
        });

        // Enhanced Line Chart
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Aktivitas Harian',
                    data: [12, 19, 3, 5, 2, 3, 9],
                    fill: true,
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(37, 99, 235, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuint'
                }
            }
        });
    </script>

    <style>
        /* Enhanced styles */
        .header-section {
            margin-bottom: 3rem !important;
            position: relative;
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--primary-blue), #1e40af);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.5rem;
        }

        .pulse-text {
            animation: pulse 2s infinite;
        }

        .enhanced-card {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
        }

        .enhanced-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }

        .enhanced-card:hover::before {
            left: 100%;
        }

        .enhanced-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .stats-card {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
        }

        .stats-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), #1e40af);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .stats-card:hover::after {
            transform: scaleX(1);
        }

        .stats-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
            position: relative;
            overflow: hidden;
        }

        .pulse-icon {
            animation: pulse 2s infinite;
        }

        .stats-icon.primary { 
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(37, 99, 235, 0.2)); 
            color: var(--primary-blue);
            border: 2px solid rgba(37, 99, 235, 0.2);
        }
        .stats-icon.success { 
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.2)); 
            color: #10b981;
            border: 2px solid rgba(16, 185, 129, 0.2);
        }
        .stats-icon.warning { 
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.2)); 
            color: #f59e0b;
            border: 2px solid rgba(245, 158, 11, 0.2);
        }
        .stats-icon.info { 
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(6, 182, 212, 0.2)); 
            color: #06b6d4;
            border: 2px solid rgba(6, 182, 212, 0.2);
        }

        .stats-title { 
            font-size: 1rem; 
            color: var(--text-light); 
            margin-bottom: 0.75rem; 
            font-weight: 500;
        }
        
        .stats-number { 
            font-size: 2.5rem; 
            font-weight: 800; 
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .stats-trend {
            font-size: 0.85rem;
            margin-bottom: 1rem;
            padding: 0.5rem;
            background: rgba(16, 185, 129, 0.05);
            border-radius: 8px;
            border: 1px solid rgba(16, 185, 129, 0.1);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .chart-container {
            height: 320px;
            position: relative;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,255,255,0.7));
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(37, 99, 235, 0.1);
            font-weight: 600;
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
        }

        .card-actions {
            display: flex;
            gap: 0.5rem;
        }

        .card-body {
            padding: 2rem 1.5rem;
        }

        /* Activity table styles */
        .activity-header {
            background: linear-gradient(135deg, #4285f4, #4285f4);
            color: white;
            border-radius: 20px 20px 0 0 !important;
            border-bottom: none !important;
        }

        .activity-header-title {
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .activity-table-header {
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
        }

        .activity-column-header {
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            text-align: left;
        }

        .activity-column-header i {
            flex-shrink: 0;
        }

        .activity-list {
            background: white;
        }

        .activity-row {
            border-bottom: 1px solid #f1f3f4;
            transition: all 0.3s ease;
            padding: 0.75rem 0;
        }

        .activity-row:hover {
            background: #f8f9ff;
            transform: translateX(5px);
        }

        .activity-row:last-child {
            border-bottom: none;
        }

        .activity-info {
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
        }

        .activity-icon-new {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin-right: 1rem;
            flex-shrink: 0;
            color: white;
        }

        .activity-details {
            flex: 1;
        }

        .activity-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
        }

        .activity-desc {
            color: #6b7280;
            font-size: 0.85rem;
            line-height: 1.3;
        }

        .user-info {
            display: flex;
            align-items: center;
            padding: 0 1rem;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            margin-right: 0.75rem;
            flex-shrink: 0;
            background: #4285f4;
            color: white;
        }

        .user-avatar.info-bg {
            background: #06b6d4;
        }

        .user-avatar.warning-bg {
            background: #f59e0b;
        }

        .user-details {
            flex: 1;
        }

        .user-name {
            font-weight: 500;
            color: #1f2937;
            font-size: 0.9rem;
            margin-bottom: 0.1rem;
        }

        .user-email {
            color: #6b7280;
            font-size: 0.8rem;
        }

        .date-info {
            padding: 0 1rem;
            text-align: left;
        }

        .date-main {
            font-weight: 500;
            color: #1f2937;
            font-size: 0.9rem;
            margin-bottom: 0.1rem;
        }

        .date-time {
            color: #6b7280;
            font-size: 0.8rem;
        }

        .status-info {
            padding: 0 1rem;
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .badge {
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 20px;
        }

        /* Responsive design for activity table */
        @media (max-width: 768px) {
            .activity-table-header,
            .activity-row .col-3,
            .activity-row .col-2 {
                display: none;
            }

            .activity-row .col-5 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .activity-info {
                flex-direction: column;
                align-items: flex-start;
                padding: 1rem 1.5rem;
            }

            .activity-icon-new {
                margin-bottom: 0.5rem;
                margin-right: 0;
            }

            .activity-details {
                width: 100%;
            }

            .activity-name::after {
                content: " • 28 Jul 2025, 10:30 WIB • Berhasil";
                color: #6b7280;
                font-weight: 400;
                font-size: 0.8rem;
            }
        }

        .animated-badge {
            animation: fadeInScale 0.5s ease;
        }

        /* Animations */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Responsive enhancements */
        @media (max-width: 768px) {
            .gradient-text {
                font-size: 2rem;
            }
            
            .stats-number {
                font-size: 2rem;
            }
            
            .chart-container {
                height: 250px;
            }
            
            .activity-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>
@endsection