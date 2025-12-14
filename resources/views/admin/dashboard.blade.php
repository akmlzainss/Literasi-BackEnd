@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Content Area -->
    <div class="content-area fade-in">
        <!-- Page Header -->
        <div class="text-center mb-5 header-section">
            <h1 class="page-title gradient-text">Dashboard Admin</h1>
            <p class="subtitle">Kelola data sistem literasi akhlak | <small class="text-muted pulse-text">Update:
                    {{ date('d M Y, H:i A') }} WIB</small></p>
        </div>

        <!-- Stats Cards -->
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
                    <div class="stats-number counter" data-target="{{ $videoCount }}">{{ $videoCount }}</div>
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
                        <div class="card-actions"></div>
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
                        <div class="card-actions"></div>
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
                        <div class="card-actions"></div>
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
        <div class="row g-4 mt-4 mb-0">
            <div class="col-12">
                <div class="card enhanced-card" data-aos="fade-up" style="margin-bottom: 0;">
                    <div class="card-header glass-effect activity-header">
                        <div class="activity-header-title">
                            <i class="fas fa-history me-2"></i>
                            <span class="fw-bold">Aktivitas Terbaru (7 Terakhir)</span>
                        </div>
                    </div>
                    <div class="card-body p-0" style="margin-bottom: 0; padding-bottom: 0;">
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
                            <div class="col-2">
                                <div class="activity-column-header">
                                    <i class="fas fa-flag me-2 text-warning"></i> Status
                                </div>
                            </div>
                        </div>

                        <!-- Activity List -->
                        <div class="activity-list" style="margin-bottom: 0; padding-bottom: 0;">
                            @forelse ($logs as $log)
                                @php
                                    // Determine icon and color based on action type
                                    $iconClass = 'fas fa-circle';
                                    $colorClass = 'success-gradient';

                                    if (
                                        stripos($log->jenis_aksi, 'create') !== false ||
                                        stripos($log->aksi, 'tambah') !== false
                                    ) {
                                        $iconClass = 'fas fa-plus';
                                        $colorClass = 'success-gradient';
                                    } elseif (
                                        stripos($log->jenis_aksi, 'update') !== false ||
                                        stripos($log->aksi, 'edit') !== false ||
                                        stripos($log->aksi, 'ubah') !== false
                                    ) {
                                        $iconClass = 'fas fa-edit';
                                        $colorClass = 'warning-gradient';
                                    } elseif (
                                        stripos($log->jenis_aksi, 'delete') !== false ||
                                        stripos($log->aksi, 'hapus') !== false
                                    ) {
                                        $iconClass = 'fas fa-trash';
                                        $colorClass = 'danger-gradient';
                                    } elseif (
                                        stripos($log->jenis_aksi, 'login') !== false ||
                                        stripos($log->aksi, 'masuk') !== false
                                    ) {
                                        $iconClass = 'fas fa-sign-in-alt';
                                        $colorClass = 'info-gradient';
                                    } elseif (
                                        stripos($log->jenis_aksi, 'logout') !== false ||
                                        stripos($log->aksi, 'keluar') !== false
                                    ) {
                                        $iconClass = 'fas fa-sign-out-alt';
                                        $colorClass = 'secondary-gradient';
                                    } elseif (
                                        stripos($log->jenis_aksi, 'export') !== false ||
                                        stripos($log->aksi, 'ekspor') !== false
                                    ) {
                                        $iconClass = 'fas fa-file-export';
                                        $colorClass = 'purple-gradient';
                                    } elseif (
                                        stripos($log->jenis_aksi, 'import') !== false ||
                                        stripos($log->aksi, 'impor') !== false
                                    ) {
                                        $iconClass = 'fas fa-file-import';
                                        $colorClass = 'teal-gradient';
                                    } elseif (
                                        stripos($log->aksi, 'menyetujui') !== false ||
                                        stripos($log->aksi, 'disetujui') !== false
                                    ) {
                                        $iconClass = 'fas fa-check-circle';
                                        $colorClass = 'success-gradient';
                                    } elseif (
                                        stripos($log->aksi, 'menolak') !== false ||
                                        stripos($log->aksi, 'ditolak') !== false
                                    ) {
                                        $iconClass = 'fas fa-times-circle';
                                        $colorClass = 'danger-gradient';
                                    }

                                    // Status badge
                                    $statusBadge = 'Berhasil';
                                    $statusColor = 'success';
                                    if (stripos($log->jenis_aksi, 'gagal') !== false) {
                                        $statusBadge = 'Gagal';
                                        $statusColor = 'danger';
                                    }
                                @endphp

                                <div class="activity-row row g-0 align-items-center" data-aos="fade-up"
                                    data-aos-delay="{{ ($loop->index + 1) * 50 }}"
                                    style="@if ($loop->last) margin-bottom: 0; padding-bottom: 1.5rem; @endif">
                                    <div class="col-5">
                                        <div class="activity-info">
                                            <div class="activity-icon-new {{ $colorClass }}">
                                                <i class="{{ $iconClass }}"></i>
                                            </div>
                                            <div class="activity-details">
                                                <div class="activity-name">{{ $log->aksi }}</div>
                                                <div class="activity-desc text-muted small">
                                                    @php
                                                        $detail = is_array($log->detail)
                                                            ? $log->detail
                                                            : json_decode($log->detail, true);
                                                        $desc = $detail['nama'] ?? ($detail['judul'] ?? null);
                                                    @endphp

                                                    {{ $desc ? $desc : '—' }}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">{{ $log->admin->nama_pengguna ?? 'Admin' }}</div>
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
                                    <div class="col-2">
                                        <div class="status-badge-wrapper">
                                            <span class="status-badge badge-{{ $statusColor }}">
                                                <i
                                                    class="fas fa-{{ $statusColor == 'success' ? 'check' : 'times' }} me-1"></i>
                                                {{ $statusBadge }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="activity-row" style="margin-bottom: 0;">
                                    <div class="col-12 text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3 opacity-50"></i>
                                        <p class="text-muted mb-0">Tidak ada aktivitas terbaru.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

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

            // Chart.js configurations
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

            // Bar Chart
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
                            {{ $artikelCount }}, {{ $kategoriCount }}, {{ $videoCount }},
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
                        borderSkipped: false
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

            // Pie Chart
            const ctxPie = document.getElementById('pieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: chartData.statsData && chartData.statsData.labels ? chartData.statsData.labels : [
                        'Artikel', 'Kategori', 'Video', 'Siswa'
                    ],
                    datasets: [{
                        data: chartData.statsData && chartData.statsData.data ? chartData.statsData.data : [
                            {{ $artikelCount }}, {{ $kategoriCount }}, {{ $videoCount }},
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

            // Line Chart
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
                            .data : [
                                2, 5, 3, 8, 4, 6, 7
                            ],
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
