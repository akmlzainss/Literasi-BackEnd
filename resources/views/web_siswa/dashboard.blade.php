<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - EduHub</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4CAF50; /* Green for growth and education */
            --secondary-color: #2196F3; /* Blue for trust and professionalism */
            --accent-color: #FF9800; /* Orange for energy and fun */
            --bg-color: #F4F7FA; /* Light background for clean look */
            --text-dark: #333333;
            --text-light: #666666;
            --card-bg: #FFFFFF;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            min-height: 100vh;
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--card-bg);
            box-shadow: var(--shadow);
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .user-info-sidebar {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .user-info-sidebar strong {
            display: block;
            font-weight: 600;
            color: var(--text-dark);
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }

        .nav-link.active {
            background-color: var(--primary-color);
            color: white;
            border-left-color: white;
        }

        .nav-link i {
            width: 20px;
            margin-right: 1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* Header */
        .header-section {
            text-align: center;
            margin-bottom: 2rem;
            padding: 1rem;
        }

        .gradient-text {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .welcome-text {
            font-size: 1.1rem;
            color: var(--text-light);
        }

        /* Stats Cards */
        .stats-card {
            background-color: var(--card-bg);
            box-shadow: var(--shadow);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1rem;
            color: white;
            transition: transform 0.3s ease;
        }

        .stats-card:hover .stats-icon {
            transform: scale(1.1);
        }

        .stats-icon.primary { background-color: var(--primary-color); }
        .stats-icon.success { background-color: var(--secondary-color); }
        .stats-icon.warning { background-color: var(--accent-color); }
        .stats-icon.info { background-color: #9C27B0; }

        .stats-title {
            text-uppercase fw-bold;
            color: var(--text-light);
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 0.5rem;
        }

        /* Article Cards */
        .article-card {
            background-color: var(--card-bg);
            box-shadow: var(--shadow);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .article-cover {
            height: 180px;
            overflow: hidden;
        }

        .article-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .article-card:hover .article-cover img {
            transform: scale(1.05);
        }

        .article-content {
            padding: 1.2rem;
        }

        .article-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .article-summary {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .author-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Enhanced Cards */
        .enhanced-card {
            background-color: var(--card-bg);
            box-shadow: var(--shadow);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .card-header {
            background-color: rgba(76, 175, 80, 0.1);
            padding: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn-custom {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            width: 100%;
            justify-content: start;
            text-align: left;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #388E3C;
            transform: translateY(-1px);
        }

        .btn-outline-custom {
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            background-color: transparent;
        }

        .btn-outline-custom:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        /* Profile Summary */
        .profile-avatar img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 3px solid var(--primary-color);
        }

        .profile-stat {
            text-align: center;
        }

        .profile-stat .fw-bold {
            font-size: 1.2rem;
            color: var(--text-dark);
        }

        .profile-stat small {
            color: var(--text-light);
            font-size: 0.8rem;
        }

        /* Activity Items */
        .activity-item {
            transition: background-color 0.3s ease;
            border-radius: 8px;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .activity-item:hover {
            background-color: rgba(76, 175, 80, 0.05);
        }

        .activity-icon {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        /* Mobile Responsiveness */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        @media (max-width: 991.98px) { /* Tablet and below */
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .mobile-toggle {
                display: block;
            }

            .header-section {
                padding: 0.5rem;
            }

            .gradient-text {
                font-size: 2rem;
            }

            .welcome-text {
                font-size: 1rem;
            }

            .stats-card {
                padding: 1rem;
            }

            .stats-number {
                font-size: 1.5rem;
            }

            .stats-icon {
                width: 50px;
                height: 50px;
                font-size: 1.5rem;
            }
        }

        @media (max-width: 767.98px) { /* Mobile */
            .main-content {
                padding: 0.5rem;
            }

            .header-section {
                text-align: left;
                margin-bottom: 1.5rem;
            }

            .gradient-text {
                font-size: 1.8rem;
            }

            /* Stack columns vertically */
            .row > .col-lg-8,
            .row > .col-lg-4 {
                width: 100% !important;
                margin-bottom: 1.5rem;
            }

            .row > * {
                padding-left: 0;
                padding-right: 0;
            }

            /* Adjust article cards for mobile */
            .article-cover {
                height: 150px;
            }

            .article-content {
                padding: 1rem;
            }

            .article-title {
                font-size: 1rem;
                -webkit-line-clamp: 1;
            }

            .article-summary {
                -webkit-line-clamp: 1;
            }

            /* Quick actions buttons */
            .d-grid.gap-2 {
                gap: 0.75rem;
            }

            .btn-custom {
                padding: 0.875rem 1rem;
                font-size: 0.9rem;
            }

            /* Profile stats */
            .row .col-4 {
                margin-bottom: 1rem;
            }

            /* Activity feed */
            .activity-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
                padding: 1rem;
            }

            .activity-item .me-3 {
                margin-right: 0 !important;
                margin-bottom: 0.5rem;
            }

            /* Statistics overview */
            .col-md-4 {
                margin-bottom: 1.5rem;
            }

            /* Ensure touch-friendly sizes */
            .stats-card,
            .article-card,
            .enhanced-card {
                min-height: auto;
            }

            /* Improve readability */
            body {
                font-size: 16px; /* Base font size for mobile */
            }
        }

        @media (max-width: 575.98px) { /* Small mobile */
            .gradient-text {
                font-size: 1.5rem;
            }

            .stats-number {
                font-size: 1.3rem;
            }

            .card-header {
                padding: 1rem;
                font-size: 0.95rem;
            }

            .card-body {
                padding: 1rem;
            }
        }

        /* Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Backdrop for mobile sidebar */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-backdrop.active {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Mobile Backdrop -->
    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

    <div class="main-wrapper">
        <!-- Mobile Toggle -->
        <button class="mobile-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="fas fa-book-open me-2"></i>EduHub
                </div>
                <div class="user-info-sidebar">
                    <strong>John Doe</strong>
                    <small>john.doe@student.edu</small>
                </div>
            </div>

            <nav class="nav-menu mt-4">
                <a href="#" class="nav-link active">
                    <i class="fas fa-home"></i>
                    Beranda
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-newspaper"></i>
                    Artikel
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-upload"></i>
                    Upload Artikel
                </a>
                <a href="#" class="nav-link">
                    <i class="fas fa-user"></i>
                    Profil
                </a>
                <div class="mt-4 pt-3 border-top">
                    <a href="#" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header Section -->
            <div class="header-section fade-in">
                <h1 class="gradient-text">Dashboard Siswa</h1>
                <p class="welcome-text">Selamat datang, John Doe! 📚</p>
            </div>

            <!-- Stats Cards - On mobile, full width, stacked -->
            <div class="row mb-4 g-3">
                <div class="col-6 col-md-3 fade-in">
                    <div class="stats-card h-100">
                        <div class="stats-icon primary">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="stats-title">Total Artikel</div>
                        <div class="stats-number">156</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 fade-in">
                    <div class="stats-card h-100">
                        <div class="stats-icon success">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stats-title">Total Views</div>
                        <div class="stats-number">2.8K</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 fade-in">
                    <div class="stats-card h-100">
                        <div class="stats-icon warning">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="stats-title">Artikel Saya</div>
                        <div class="stats-number">12</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 fade-in">
                    <div class="stats-card h-100">
                        <div class="stats-icon info">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-title">Total Siswa</div>
                        <div class="stats-number">428</div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Latest Articles - Stacked on mobile -->
                <div class="col-lg-8 fade-in">
                    <div class="enhanced-card h-100">
                        <div class="card-header">
                            <i class="fas fa-newspaper me-2"></i>
                            Artikel Terbaru
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <div class="article-card h-100">
                                        <div class="article-cover">
                                            <img src="https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?w=400&h=200&fit=crop" alt="Teknologi AI dalam Pendidikan">
                                        </div>
                                        <div class="article-content">
                                            <h6 class="article-title">Teknologi AI dalam Pendidikan</h6>
                                            <p class="article-summary">Bagaimana artificial intelligence merubah cara kita belajar dan mengajar di era digital...</p>
                                            <div class="author-info">
                                                <div class="author-avatar">JD</div>
                                                <small>John Doe</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="article-card h-100">
                                        <div class="article-cover">
                                            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=200&fit=crop" alt="Metode Pembelajaran Interaktif">
                                        </div>
                                        <div class="article-content">
                                            <h6 class="article-title">Metode Pembelajaran Interaktif</h6>
                                            <p class="article-summary">Strategi pembelajaran yang melibatkan siswa secara aktif untuk meningkatkan pemahaman...</p>
                                            <div class="author-info">
                                                <div class="author-avatar">SA</div>
                                                <small>Sarah Ahmad</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="article-card h-100">
                                        <div class="article-cover">
                                            <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&h=200&fit=crop" alt="Coding untuk Pemula">
                                        </div>
                                        <div class="article-content">
                                            <h6 class="article-title">Coding untuk Pemula</h6>
                                            <p class="article-summary">Panduan lengkap memulai journey programming dari nol hingga mahir...</p>
                                            <div class="author-info">
                                                <div class="author-avatar">MR</div>
                                                <small>Mike Rodgers</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="article-card h-100">
                                        <div class="article-cover">
                                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=200&fit=crop" alt="Tips Study Efektif">
                                        </div>
                                        <div class="article-content">
                                            <h6 class="article-title">Tips Study Efektif</h6>
                                            <p class="article-summary">Teknik-teknik belajar yang terbukti efektif untuk meningkatkan hasil akademik...</p>
                                            <div class="author-info">
                                                <div class="author-avatar">AL</div>
                                                <small>Anna Lee</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions & Profile - Stacked on mobile, full width -->
                <div class="col-lg-4">
                    <!-- Quick Actions -->
                    <div class="enhanced-card mb-4 fade-in">
                        <div class="card-header">
                            <i class="fas fa-bolt me-2"></i>
                            Aksi Cepat
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary-custom btn-custom">
                                    <i class="fas fa-plus me-2"></i>Upload Artikel Baru
                                </button>
                                <button class="btn btn-outline-custom btn-custom">
                                    <i class="fas fa-search me-2"></i>Jelajahi Artikel
                                </button>
                                <button class="btn btn-outline-custom btn-custom">
                                    <i class="fas fa-user-edit me-2"></i>Edit Profil
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Summary -->
                    <div class="enhanced-card fade-in">
                        <div class="card-header">
                            <i class="fas fa-user me-2"></i>
                            Profil Saya
                        </div>
                        <div class="card-body text-center">
                            <div class="profile-avatar mb-3">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face" 
                                     alt="Profile" class="rounded-circle">
                            </div>
                            <h6 class="mb-2">John Doe</h6>
                            <p class="text-light mb-3" style="font-size: 0.9rem;">john.doe@student.edu</p>
                            <div class="row g-2 mb-3">
                                <div class="col-4">
                                    <div class="profile-stat">
                                        <div class="fw-bold">12</div>
                                        <small>Artikel</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="profile-stat">
                                        <div class="fw-bold">856</div>
                                        <small>Views</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="profile-stat">
                                        <div class="fw-bold">24</div>
                                        <small>Likes</small>
                                    </div>
                                </div>
                            </div>
                            <small class="text-light">
                                <i class="fas fa-calendar me-1"></i>
                                Bergabung Sep 2024
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Overview - Stacked on mobile -->
            <div class="row mt-4 g-4">
                <div class="col-12">
                    <div class="enhanced-card fade-in">
                        <div class="card-header">
                            <i class="fas fa-chart-line me-2"></i>
                            Ringkasan Aktivitas
                        </div>
                        <div class="card-body">
                            <div class="row g-3 text-center">
                                <div class="col-12 col-md-4">
                                    <div class="activity-stat">
                                        <i class="fas fa-calendar-week fa-2x mb-3 activity-icon"></i>
                                        <h6 class="mb-2">Minggu Ini</h6>
                                        <p class="text-light mb-2">3 artikel baru dipublish</p>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-primary" style="width: 75%;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="activity-stat">
                                        <i class="fas fa-calendar-month fa-2x mb-3" style="color: var(--secondary-color);"></i>
                                        <h6 class="mb-2">Bulan Ini</h6>
                                        <p class="text-light mb-2">12 artikel diterbitkan</p>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar" style="width: 60%; background-color: var(--secondary-color);"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="activity-stat">
                                        <i class="fas fa-trophy fa-2x mb-3" style="color: var(--accent-color);"></i>
                                        <h6 class="mb-2">Pencapaian</h6>
                                        <p class="text-light mb-2">8 artikel trending</p>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar" style="width: 90%; background-color: var(--accent-color);"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Feed -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="enhanced-card fade-in">
                        <div class="card-header">
                            <i class="fas fa-history me-2"></i>
                            Aktivitas Terbaru
                        </div>
                        <div class="card-body">
                            <div class="activity-item d-flex">
                                <div class="activity-icon me-3 mt-1"><i class="fas fa-plus-circle"></i></div>
                                <div class="flex-grow-1">
                                    <p class="mb-1"><strong>Artikel baru</strong> "Tips Belajar Efektif" telah dipublish</p>
                                    <small class="text-light">2 jam yang lalu</small>
                                </div>
                            </div>
                            <div class="activity-item d-flex mt-3">
                                <div class="activity-icon me-3 mt-1" style="color: var(--secondary-color);"><i class="fas fa-heart"></i></div>
                                <div class="flex-grow-1">
                                    <p class="mb-1">Artikel <strong>"Coding untuk Pemula"</strong> mendapat 15 like baru</p>
                                    <small class="text-light">5 jam yang lalu</small>
                                </div>
                            </div>
                            <div class="activity-item d-flex mt-3">
                                <div class="activity-icon me-3 mt-1" style="color: var(--accent-color);"><i class="fas fa-eye"></i></div>
                                <div class="flex-grow-1">
                                    <p class="mb-1">Total views mencapai <strong>2,800</strong> dalam bulan ini</p>
                                    <small class="text-light">1 hari yang lalu</small>
                                </div>
                            </div>
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
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('active');
            backdrop.classList.toggle('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-toggle');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (window.innerWidth <= 991 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target)) {
                sidebar.classList.remove('active');
                backdrop.classList.remove('active');
            }
        });

        // Staggered animations
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });

            // Prevent body scroll when sidebar is open on mobile
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.addEventListener('transitionend', function() {
                if (window.innerWidth <= 991 && sidebar.classList.contains('active')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = 'auto';
                }
            });
        });

        // Touch-friendly enhancements for mobile
        if ('ontouchstart' in window) {
            document.body.classList.add('touch-device');
        }
    </script>
</body>
</html>