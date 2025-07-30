<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kelola Penghargaan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            min-height: 100vh;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 0;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sidebar-header .logo {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            flex-shrink: 0;
        }

        .sidebar-header h2 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 14px;
            opacity: 0.8;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left-color: #60a5fa;
            backdrop-filter: blur(10px);
        }

        .menu-item i {
            width: 20px;
            margin-right: 15px;
            font-size: 16px;
        }

        .menu-item span {
            font-size: 14px;
            font-weight: 500;
        }

        .menu-badge {
            background: #ef4444;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            margin-left: auto;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            background: #ffffff;
        }

        .header {
            background: #ffffff;
            padding: 20px 30px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .header h1 {
            color: #1f2937;
            font-size: 28px;
            font-weight: 700;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .header-controls {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .filter-select {
            background: #f9fafb;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .filter-select:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        .filter-select option {
            background: #ffffff;
            color: #374151;
        }

        .filter-btn {
            background: #f9fafb;
            color: #374151;
            border: 1px solid #d1d5db;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-btn:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        .add-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .add-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #374151;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .content {
            padding: 30px;
            background: #ffffff;
        }

        /* Awards Grid */
        .awards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .award-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            height: 300px;
            width: 100%;
        }

        .award-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .award-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .award-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .award-icon.gold {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .award-icon.silver {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        }

        .award-icon.bronze {
            background: linear-gradient(135deg, #92400e 0%, #78350f 100%);
        }

        .award-info h3 {
            color: #1f2937;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .award-date {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .award-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 0 15px;
        }

        .stat-item {
            text-align: center;
            flex: 1;
        }

        .stat-number {
            font-size: 30px;
            font-weight: 700;
            color: #2563eb;
            display: block;
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .award-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            flex: 1;
            padding: 10px 6px;
            border: none;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            min-height: 40px;
            text-align: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
        }

        .btn-secondary {
            background: rgba(107, 114, 128, 0.1);
            color: #374151;
            border: 1px solid #d1d5db;
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .action-btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary:hover {
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        /* Winners Section */
        .winners-section {
            background: #ffffff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
        }

        .section-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .section-header h2 {
            color: #1f2937;
            font-size: 24px;
            font-weight: 700;
        }

        .winners-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .winner-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .winner-item:hover {
            background: rgba(37, 99, 235, 0.05);
            transform: translateX(5px);
        }

        .winner-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }

        .winner-info {
            flex: 1;
        }

        .winner-name {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .winner-description {
            font-size: 14px;
            color: #6b7280;
        }

        .winner-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: 700;
            color: #2563eb;
        }

        .rating-stars {
            color: #f59e0b;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .awards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
            }
            
            .awards-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
            
            .header-controls {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <h2>SMKN 11 Bandung</h2>
                    <p>Sistem Literasi Akhlak</p>
                </div>
            </div>
            <nav class="sidebar-menu">
                <a href="#" class="menu-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-newspaper"></i>
                    <span>Artikel</span>
                    <span class="menu-badge">245</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-tags"></i>
                    <span>Kategori</span>
                    <span class="menu-badge">18</span>
                </a>
                <a href="#" class="menu-item active">
                    <i class="fas fa-trophy"></i>
                    <span>Penghargaan</span>
                    <span class="menu-badge">12</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-users"></i>
                    <span>Siswa</span>
                    <span class="menu-badge">1.2K</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-user-friends"></i>
                    <span>Pengguna</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="header-left">
                    <h1>Kelola Penghargaan</h1>
                    <div class="header-controls">
                        <select class="filter-select">
                            <option>Tanggal</option>
                            <option>Minggu Ini</option>
                            <option>Bulan Ini</option>
                        </select>
                        <select class="filter-select">
                            <option>Status</option>
                            <option>Aktif</option>
                            <option>Nonaktif</option>
                        </select>
                        <select class="filter-select">
                            <option>Periode</option>
                            <option>2025</option>
                            <option>2024</option>
                        </select>
                        <button class="filter-btn">
                            <i class="fas fa-filter"></i> Reset Filter
                        </button>
                        <button class="add-btn">
                            <i class="fas fa-plus"></i> Tambah Penghargaan
                        </button>
                    </div>
                </div>
                <div class="user-profile">
                    <div class="user-avatar">MR</div>
                    <div>
                        <div style="font-weight: 600;">Mart Riay</div>
                        <div style="font-size: 12px; opacity: 0.8;">Admin</div>
                    </div>
                </div>
            </div>

            <div class="content">
                <!-- Awards Grid -->
                <div class="awards-grid">
                    <div class="award-card">
                        <div class="award-header">
                            <div class="award-icon gold">
                                <i class="fas fa-trophy"></i>
                            </div>
                        <div class="award-info">
                            <h3>Artikel Terbaik Januari 2025</h3>
                            <div class="award-date">1 Januari - 31 Januari 2025</div>
                        </div>
                        </div>
                        <div class="award-stats">
                            <div class="stat-item">
                                <span class="stat-number">10</span>
                                <span class="stat-label">Artikel</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">100</span>
                                <span class="stat-label">Rating</span>
                            </div>
                        </div>
                        <div class="award-actions">
                            <button class="action-btn btn-primary">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </button>
                            <button class="action-btn btn-secondary">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>

                    <div class="award-card">
                        <div class="award-header">
                            <div class="award-icon silver">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div class="award-info">
                                <h3>Artikel Terbaik Februari 2025</h3>
                                <div class="award-date">1 Februari - 28 Februari 2025</div>
                            </div>
                        </div>
                        <div class="award-stats">
                            <div class="stat-item">
                                <span class="stat-number">5</span>
                                <span class="stat-label">Artikel</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">90</span>
                                <span class="stat-label">Rating</span>
                            </div>
                        </div>
                        <div class="award-actions">
                            <button class="action-btn btn-primary">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </button>
                            <button class="action-btn btn-secondary">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>

                    <div class="award-card">
                        <div class="award-header">
                            <div class="award-icon bronze">
                                <i class="fas fa-award"></i>
                            </div>
                            <div class="award-info">
                                <h3>Artikel Terbaik Maret 2025</h3>
                                <div class="award-date">1 Maret - 31 Maret 2025</div>
                            </div>
                        </div>
                        <div class="award-stats">
                            <div class="stat-item">
                                <span class="stat-number">8</span>
                                <span class="stat-label">Artikel</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">85</span>
                                <span class="stat-label">Rating</span>
                            </div>
                        </div>
                        <div class="award-actions">
                            <button class="action-btn btn-primary">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </button>
                            <button class="action-btn btn-secondary">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>

                    <div class="award-card">
                        <div class="award-header">
                            <div class="award-icon" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="award-info">
                                <h3>Artikel Terbaik April 2025</h3>
                                <div class="award-date">1 April - 30 April 2025</div>
                            </div>
                        </div>
                        <div class="award-stats">
                            <div class="stat-item">
                                <span class="stat-number">12</span>
                                <span class="stat-label">Artikel</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">92</span>
                                <span class="stat-label">Rating</span>
                            </div>
                        </div>
                        <div class="award-actions">
                            <button class="action-btn btn-primary">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </button>
                            <button class="action-btn btn-secondary">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="action-btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Winners Section -->
                <div class="winners-section">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fas fa-crown"></i>
                        </div>
                        <h2>Pemenang Bulan Januari 2025</h2>
                    </div>
                    <div class="winners-list">
                        <div class="winner-item">
                            <div class="winner-avatar" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">A</div>
                            <div class="winner-info">
                                <div class="winner-name">Ahmad Reza Pratama</div>
                                <div class="winner-description">"Penerapan Kejujuran dalam Kehidupan Sehari-hari"</div>
                            </div>
                            <div class="winner-rating">
                                <span class="rating-stars">★★★★★</span>
                                <span>4.9</span>
                            </div>
                        </div>

                        <div class="winner-item">
                            <div class="winner-avatar" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);">S</div>
                            <div class="winner-info">
                                <div class="winner-name">Siti Nurhaliza</div>
                                <div class="winner-description">"Menghargai Perbedaan dan Toleransi"</div>
                            </div>
                            <div class="winner-rating">
                                <span class="rating-stars">★★★★☆</span>
                                <span>4.8</span>
                            </div>
                        </div>

                        <div class="winner-item">
                            <div class="winner-avatar" style="background: linear-gradient(135deg, #92400e 0%, #78350f 100%);">M</div>
                            <div class="winner-info">
                                <div class="winner-name">Muhammad Fajar</div>
                                <div class="winner-description">"Gotong Royong di Era Digital"</div>
                            </div>
                            <div class="winner-rating">
                                <span class="rating-stars">★★★★☆</span>
                                <span>4.5</span>
                            </div>
                        </div>

                        <div class="winner-item">
                            <div class="winner-avatar" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">A</div>
                            <div class="winner-info">
                                <div class="winner-name">Adrian Maulana</div>
                                <div class="winner-description">"Tanggung Jawab Bersama"</div>
                            </div>
                            <div class="winner-rating">
                                <span class="rating-stars">★★★★☆</span>
                                <span>4.5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add some interactive functionality
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.textContent.trim();
                if (action.includes('Lihat Detail')) {
                    alert('Membuka detail penghargaan...');
                } else if (action.includes('Edit')) {
                    alert('Membuka form edit penghargaan...');
                } else if (action.includes('Hapus')) {
                    if (confirm('Apakah Anda yakin ingin menghapus penghargaan ini?')) {
                        alert('Penghargaan berhasil dihapus!');
                    }
                }
            });
        });

        document.querySelector('.add-btn').addEventListener('click', function() {
            alert('Membuka form tambah penghargaan baru...');
        });

        // Add hover effects to cards
        document.querySelectorAll('.award-card, .winner-item').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>