<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMKN 11 Bandung - Kelola Penghargaan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            color: white;
            padding: 0;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        .school-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .school-name {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .school-subtitle {
            font-size: 14px;
            color: rgba(255,255,255,0.8);
        }

        .nav-menu {
            padding: 20px 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }

        .nav-item.active {
            background: rgba(255,255,255,0.15);
            color: white;
            border-right: 3px solid white;
        }

        .nav-item i {
            width: 20px;
            margin-right: 12px;
            font-size: 16px;
        }

        .nav-badge {
            background: #ef4444;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: auto;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            background: white;
            padding: 16px 32px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .header-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .filter-dropdown {
            padding: 8px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: white;
            font-size: 14px;
            cursor: pointer;
        }

        .reset-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .add-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: #f97316;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-details h4 {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .user-details p {
            font-size: 12px;
            color: #64748b;
        }

        /* Content Area */
        .content {
            flex: 1;
            padding: 32px;
        }

        /* Main Award Section */
        .main-award-section {
            margin-bottom: 40px;
        }

        .main-award-card {
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .award-header {
            display: flex;
            align-items: center;
            padding: 20px 24px;
            gap: 20px;
        }

        .award-icon-large {
            width: 60px;
            height: 60px;
            background: #f97316;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .award-main-info {
            flex: 1;
        }

        .award-main-info h2 {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .award-period {
            font-size: 14px;
            color: #64748b;
        }

        .award-stats-inline {
            display: flex;
            gap: 40px;
            align-items: center;
        }

        .stat-inline {
            text-align: center;
        }

        .stat-inline .stat-number {
            display: block;
            font-size: 24px;
            font-weight: 700;
            color: #3b82f6;
            margin-bottom: 2px;
        }

        .stat-inline .stat-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .award-actions-inline {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #64748b;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .btn-icon:hover {
            background: #f1f5f9;
            color: #374151;
        }

        .btn {
            flex: 1;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        /* Winners Section */
        .winners-section {
            background: white;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }

        .winners-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .crown-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .winners-title {
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
        }

        .winner-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .winner-item:last-child {
            border-bottom: none;
        }

        .winner-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .winner-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .winner-avatar.first { background: #f59e0b; }
        .winner-avatar.second { background: #64748b; }
        .winner-avatar.third { background: #92400e; }
        .winner-avatar.fourth { background: #ec4899; }

        .winner-details h4 {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 2px;
        }

        .winner-details p {
            font-size: 14px;
            color: #64748b;
        }

        .winner-rating {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stars {
            color: #fbbf24;
            font-size: 14px;
        }

        .rating-number {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
            }
            
            .header {
                padding: 16px;
                flex-wrap: wrap;
                gap: 16px;
            }
            
            .content {
                padding: 16px;
            }
            
            .awards-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="school-header">
                <div class="school-name">SMKN 11</div>
                <div class="school-name">Bandung</div>
                <div class="school-subtitle">Sistem Literasi Akhlak</div>
            </div>
            
            <nav class="nav-menu">
                <a href="#" class="nav-item">
                    <i class="fas fa-chart-line"></i>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-newspaper"></i>
                    Artikel
                    <span class="nav-badge">245</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-tags"></i>
                    Kategori
                    <span class="nav-badge">18</span>
                </a>
                <a href="#" class="nav-item active">
                    <i class="fas fa-trophy"></i>
                    Penghargaan
                    <span class="nav-badge">12</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-users"></i>
                    Siswa
                    <span class="nav-badge">1.2K</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-user-tie"></i>
                    Pengguna
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-chart-bar"></i>
                    Laporan
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-cog"></i>
                    Pengaturan
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1 class="header-title">Kelola Penghargaan</h1>
                
                <div class="header-controls">
                    <select class="filter-dropdown">
                        <option>Tanggal</option>
                    </select>
                    <select class="filter-dropdown">
                        <option>Status</option>
                    </select>
                    <select class="filter-dropdown">
                        <option>Periode</option>
                    </select>
                    <button class="reset-btn">
                        <i class="fas fa-filter"></i>
                        Reset Filter
                    </button>
                    <button class="add-btn">
                        <i class="fas fa-plus"></i>
                        Tambah Penghargaan
                    </button>
                </div>

                <div class="user-info">
                    <div class="user-avatar">MR</div>
                    <div class="user-details">
                        <h4>Mart Riay</h4>
                        <p>Admin</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                <!-- Main Award Card -->
                <div class="main-award-section">
                    <div class="main-award-card">
                        <div class="award-header">
                            <div class="award-icon-large">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="award-main-info">
                                <h2>Artikel Terbaik Januari 2025</h2>
                                <p class="award-period">1 Januari - 31 Januari 2025</p>
                            </div>
                            <div class="award-stats-inline">
                                <div class="stat-inline">
                                    <span class="stat-number">10</span>
                                    <span class="stat-label">ARTIKEL</span>
                                </div>
                                <div class="stat-inline">
                                    <span class="stat-number">100</span>
                                    <span class="stat-label">RATING</span>
                                </div>
                            </div>
                            <div class="award-actions-inline">
                                <button class="btn-icon" title="JSON">
                                    <i class="fas fa-code"></i>
                                </button>
                                <button class="btn-icon" title="Lengkap">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Winners Section -->
                <div class="winners-section">
                    <div class="winners-header">
                        <div class="crown-icon">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h2 class="winners-title">Pemenang Bulan Januari 2025</h2>
                    </div>

                    <div class="winner-item">
                        <div class="winner-info">
                            <div class="winner-avatar first">A</div>
                            <div class="winner-details">
                                <h4>Ahmad Reza Pratama</h4>
                                <p>"Penerapan Kejujuran dalam Kehidupan Sehari-hari"</p>
                            </div>
                        </div>
                        <div class="winner-rating">
                            <div class="stars">★★★★★</div>
                            <div class="rating-number">4.9</div>
                        </div>
                    </div>

                    <div class="winner-item">
                        <div class="winner-info">
                            <div class="winner-avatar second">S</div>
                            <div class="winner-details">
                                <h4>Siti Nurhaliza</h4>
                                <p>"Menghargai Perbedaan dan Toleransi"</p>
                            </div>
                        </div>
                        <div class="winner-rating">
                            <div class="stars">★★★★★</div>
                            <div class="rating-number">4.8</div>
                        </div>
                    </div>

                    <div class="winner-item">
                        <div class="winner-info">
                            <div class="winner-avatar third">M</div>
                            <div class="winner-details">
                                <h4>Muhammad Fajar</h4>
                                <p>"Gotong Royong di Era Digital"</p>
                            </div>
                        </div>
                        <div class="winner-rating">
                            <div class="stars">★★★★★</div>
                            <div class="rating-number">4.5</div>
                        </div>
                    </div>

                    <div class="winner-item">
                        <div class="winner-info">
                            <div class="winner-avatar fourth">A</div>
                            <div class="winner-details">
                                <h4>Adrian Maulana</h4>
                                <p>"Tanggap dan Beradaptasi"</p>
                            </div>
                        </div>
                        <div class="winner-rating">
                            <div class="stars">★★★★★</div>
                            <div class="rating-number">4.5</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>