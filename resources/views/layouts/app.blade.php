<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - SMKN 11 Bandung')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
            min-height: 100vh;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--dark-blue) 0%, var(--primary-blue) 100%);
            z-index: 1000;
            transition: transform 0.3s ease;
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

        /* Sidebar Toggle */
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
            transition: margin-left 0.3s ease;
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

        .footer {
            background: var(--bg-white);
            padding: 1rem 2rem;
            text-align: center;
            color: var(--text-light);
            font-size: 0.9rem;
            border-top: 1px solid rgba(37, 99, 235, 0.1);
            position: sticky;
            bottom: 0;
            z-index: 100;
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
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h5 class="sidebar-title">SMKN 11 Bandung</h5>
            <p class="sidebar-subtitle">Sistem Literasi Akhlak</p>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.artikel.index') }}"
                    class="nav-link {{ Request::routeIs('admin.artikel.index') ? 'active' : '' }}">
                    <i class="fas fa-newspaper nav-icon"></i>
                    <span class="nav-text">Artikel</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.video.persetujuan') }}"
                    class="nav-link {{ Request::routeIs('admin.video.persetujuan') ? 'active' : '' }}">
                    <i class="fas fa-video nav-icon"></i>
                    <span class="nav-text">Persetujuan Video</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.kategori.index') }}"
                    class="nav-link {{ Request::routeIs('admin.kategori.index') ? 'active' : '' }}">
                    <i class="fas fa-tags nav-icon"></i>
                    <span class="nav-text">Kategori</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.penghargaan.index') }}"
                    class="nav-link {{ Request::routeIs('admin.penghargaan.index') ? 'active' : '' }}">
                    <i class="fas fa-trophy nav-icon"></i>
                    <span class="nav-text">Penghargaan</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.siswa.index') }}"
                    class="nav-link {{ Request::routeIs('admin.siswa.index') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate nav-icon"></i>
                    <span class="nav-text">Siswa</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.laporan.aktivitas') }}"
                    class="nav-link {{ Request::routeIs('admin.laporan.aktivitas') ? 'active' : '' }}">
                    <i class="fas fa-chart-line nav-icon"></i>
                    <span class="nav-text">Laporan</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.pengaturan.index') }}"
                    class="nav-link {{ Request::routeIs('admin.pengaturan.index') ? 'active' : '' }}">
                    <i class="fas fa-cog nav-icon"></i>
                    <span class="nav-text">Pengaturan</span>
                </a>
            </div>
            <div class="nav-item">
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="nav-link"
                    onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin logout?')) document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt nav-icon"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <h6 class="mb-0 fw-bold text-primary">Selamat datang kembali, Admin!</h6>
            </div>
            <div class="topbar-right">
                <div class="user-profile dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar">A</div>
                    <span class="fw-semibold">Admin</span>
                    <i class="fas fa-chevron-down ms-1"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('admin.pengaturan.index') }}">Pengaturan</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Content Area -->
        <section class="content-area">
            @yield('content')
            @yield('additional_css')

        </section>

        <!-- Footer -->
        <footer class="footer">
            &copy; {{ date('Y') }} SMKN 11 Bandung - Sistem Literasi Akhlak. All rights reserved.
        </footer>
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>
    @yield('scripts')
</body>

</html>
