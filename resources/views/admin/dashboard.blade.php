@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
   <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <!-- Content Area -->
    <div class="content-area fade-in">
        <!-- Page Header -->
        <div class="text-center mb-5 header-section">
            <h1 class="page-title gradient-text">Dashboard Admin</h1>
            <p class="subtitle">Kelola data sistem literasi akhlak | <small class="text-muted pulse-text">Update:
                    {{ date('d M Y, H:i A') }} WIB</small></p>
        </div>

        <!-- Stats Cards (Kotak-kotak) -->
        <div class="row g-4 mb-4">

            <!-- Artikel -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card primary enhanced-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="stats-icon primary">
                        <i class="fas fa-newspaper pulse-icon"></i>
                    </div>
                    <h5 class="stats-title">Total Artikel</h5>
                    <div class="stats-number counter" data-target="{{ $artikelCount }}">{{ $artikelCount }}</div>
                </div>
            </div>

            <!-- Kategori -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card success enhanced-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="stats-icon success">
                        <i class="fas fa-tags pulse-icon"></i>
                    </div>
                    <h5 class="stats-title">Total Kategori</h5>
                    <div class="stats-number counter" data-target="{{ $kategoriCount }}">{{ $kategoriCount }}</div>
                </div>
            </div>

            <!-- Video -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card warning enhanced-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="stats-icon warning">
                        <i class="fas fa-play-circle pulse-icon"></i>
                    </div>
                    <h5 class="stats-title">Total Video</h5>
                    <div class="stats-number counter" data-target="{{ $penghargaanCount }}">{{ $penghargaanCount }}</div>
                </div>
            </div>

            <!-- Siswa -->
            <div class="col-xl-3 col-md-6">
                <div class="stats-card info enhanced-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="stats-icon info">
                        <i class="fas fa-user-graduate pulse-icon"></i>
                    </div>
                    <h5 class="stats-title">Total Siswa</h5>
                    <div class="stats-number counter" data-target="{{ $siswaCount }}">{{ $siswaCount }}</div>
                </div>
            </div>

        </div>

        <!-- Charts Section -->
        <div class="row g-4 mb-4">
            <div class="col-xl-8">
                <div class="card h-100 enhanced-card" data-aos="fade-right">
                    <div class="card-header glass-effect">

                        <span class="fw-bold">Statistik Data Berdasarkan Kategori</span>
                        <div class="card-actions">

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
                        <span class="fw-bold">Distribusi Data</span>
                        <div class="card-actions">

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
                       
                        <span class="fw-bold">Trend Aktivitas 7 Hari Terakhir</span>
                        <div class="card-actions">
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
                            <span class="fw-bold">Aktivitas Admin</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <!-- Activity Table Header -->
                        <div class="activity-table-header row g-0">
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
                        </div>

                        <!-- Activity List -->
                        <div class="activity-list">
                            @forelse ($logs as $log)
                                <div class="activity-row row g-0 align-items-center" data-aos="fade-up"
                                    data-aos-delay="{{ ($loop->index + 1) * 100 }}">
                                    <div class="col-5">
                                        <div class="activity-info">
                                            <div class="activity-icon-new success-gradient">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-name">{{ $log->aksi }}</div>
                                                <div class="activity-desc">{{ $log->detail }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">
                                                    {{ $log->admin->nama_pengguna ?? 'Admin tidak ditemukan' }}</div>
                                                <div class="user-email">{{ $log->admin->email ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="date-info">
                                            <div class="date-main">{{ optional($log->created_at)->format('d M Y') }}</div>
                                            <div class="date-time">{{ optional($log->created_at)->format('H:i') }} WIB
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="activity-row">
                                    <div class="col-12 text-center py-3">
                                        Tidak ada aktivitas terbaru.
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="mt-3">
                            {{ $logs->links() }}
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

            // Data from Laravel Controller
            const chartData = {
                categories: @json($chartData['categories'] ?? []),
                categoryNames: @json($chartData['categoryNames'] ?? []),
                statsData: @json($statsData ?? []),
                activityData: @json($activityData ?? [])
            };

            // Debugging - bisa dihapus nanti
            console.log('Chart Data:', chartData);

            // Bar Chart - Statistik berdasarkan kategori/data
            const ctxStatistik = document.getElementById('chartStatistik').getContext('2d');
            new Chart(ctxStatistik, {
                type: 'bar',
                data: {
                    labels: chartData.categoryNames && chartData.categoryNames.length > 0 ? chartData.categoryNames : [
                        'Artikel', 'Kategori', 'Video', 'Siswa'
                    ],
                    datasets: [{
                        label: 'Jumlah Data',
                        data: chartData.categories && chartData.categories.length > 0 ? chartData.categories : [
                            {{ $artikelCount }}, {{ $kategoriCount }}, {{ $penghargaanCount }},
                            {{ $siswaCount }}
                        ],
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

            // Enhanced Pie Chart - Distribusi data
            const ctxPie = document.getElementById('pieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: chartData.statsData && chartData.statsData.labels ? chartData.statsData.labels : ['Artikel',
                        'Kategori', 'Video', 'Siswa'
                    ],
                    datasets: [{
                        data: chartData.statsData && chartData.statsData.data ? chartData.statsData.data : [
                            {{ $artikelCount }}, {{ $kategoriCount }}, {{ $penghargaanCount }},
                            {{ $siswaCount }}
                        ],
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

            // Enhanced Line Chart - Trend aktivitas 7 hari terakhir
            const ctxLine = document.getElementById('lineChart').getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: chartData.activityData && chartData.activityData.labels ? chartData.activityData.labels : [
                        '6 hari lalu', '5 hari lalu', '4 hari lalu', '3 hari lalu', '2 hari lalu', 'Kemarin',
                        'Hari ini'
                    ],
                    datasets: [{
                        label: 'Aktivitas Harian',
                        data: chartData.activityData && chartData.activityData.data ? chartData.activityData
                            .data : [2, 5, 3, 8, 4, 6, 7],
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
    </div>
@endsection