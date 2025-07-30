<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
</head>

<body>
    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SMKN 11 Bandung</title>
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
            justify-content: between;
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

        .page-title {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(37, 99, 235, 0.1);
        }

        .subtitle {
            color: var(--text-light);
            font-weight: 400;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }

        .stats-card {
            background: var(--bg-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(37, 99, 235, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--light-blue));
        }

        .stats-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .stats-card.primary {
            border-left: 4px solid var(--primary-blue);
        }

        .stats-card.success {
            border-left: 4px solid #10b981;
        }

        .stats-card.warning {
            border-left: 4px solid #f59e0b;
        }

        .stats-card.info {
            border-left: 4px solid #06b6d4;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            position: relative;
        }

        .stats-icon::after {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 50%;
            padding: 2px;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
        }

        .stats-icon.primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
        }

        .stats-icon.success {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white;
        }

        .stats-icon.warning {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: white;
        }

        .stats-icon.info {
            background: linear-gradient(135deg, #06b6d4, #22d3ee);
            color: white;
        }

        .stats-title {
            font-weight: 600;
            font-size: 1rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .stats-number {
            font-weight: 700;
            font-size: 2.5rem;
            color: var(--primary-blue);
            margin-bottom: 1rem;
            line-height: 1;
        }

        .btn-custom {
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            border: none;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(37, 99, 235, 0.3);
            color: white;
        }

        .btn-outline-custom {
            background: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
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
        }

        .card-body-custom {
            padding: 2rem;
        }

        .chart-container {
            position: relative;
            height: 400px;
            background: var(--bg-white);
            border-radius: 15px;
        }

        .table-custom {
            border-radius: 10px;
            overflow: hidden;
        }

        .table-custom thead th {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border: none;
            font-weight: 600;
            color: var(--text-dark);
            padding: 1rem;
        }

        .table-custom tbody td {
            padding: 1rem;
            border: none;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-custom tbody tr:hover {
            background: #f8fafc;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
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

        .stats-row {
            margin-bottom: 3rem;
        }

        /* Charts Grid */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: var(--bg-white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .chart-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            padding: 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .chart-body {
            padding: 1.5rem;
        }

        .small-chart-container {
            position: relative;
            height: 300px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

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
            
            .stats-card {
                margin-bottom: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .topbar {
                padding: 1rem;
            }
            
            .user-profile span {
                display: none;
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
                <a href="{{route('admin.dashboard')}}" class="nav-link active">
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
                <a href="#" class="nav-link">
                    <i class="fas fa-tags nav-icon"></i>
                    <span class="nav-text">Kategori</span>
                    <span class="nav-badge">18</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-trophy nav-icon"></i>
                    <span class="nav-text">Penghargaan</span>
                    <span class="nav-badge">12</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-user-graduate nav-icon"></i>
                    <span class="nav-text">Siswa</span>
                    <span class="nav-badge">1.2K</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-users nav-icon"></i>
                    <span class="nav-text">Pengguna</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-chart-line nav-icon"></i>
                    <span class="nav-text">Laporan</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog nav-icon"></i>
                    <span class="nav-text">Pengaturan</span>
                </a>
            </div>
        </nav>
    </div>
</body>
</html>
