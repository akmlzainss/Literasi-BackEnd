<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Web Siswa - SMKN 11 Bandung')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo_sekolah.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_sekolah.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo_sekolah.png') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/websiswa.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    @yield('additional_css')
</head>

<body class="@yield('body_class', '')">

    <header class="header">
        <nav class="container navbar navbar-expand-lg">
            <a href="@auth('siswa'){{ route('dashboard-siswa') }}@else{{ route('artikel-siswa.index') }}@endauth" class="logo">
                <i class="fas fa-graduation-cap"></i> SIPENA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon">
                    <i class="fas fa-bars"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @auth('siswa')
                    <li class="nav-item">
                        <a href="{{ route('dashboard-siswa') }}"
                            class="nav-link {{ request()->routeIs('dashboard-siswa') ? 'active' : '' }}">
                            <i class="fas fa-home me-1 d-lg-none"></i>Beranda
                        </a>
                    </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('artikel-siswa*') && !request()->routeIs('artikel-siswa.upload*') && !request()->routeIs('artikel-siswa.create*') ? 'active' : '' }}"
                            href="{{ route('artikel-siswa.index') }}">
                            <i class="fas fa-newspaper me-1 d-lg-none"></i>Artikel
                        </a>
                    </li>
                    @auth('siswa')
                    <!-- Tambahkan link Video -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('video.index') || request()->routeIs('video.tiktok') ? 'active' : '' }}"
                            href="{{ route('video.index') }}">
                            <i class="fas fa-video me-1 d-lg-none"></i>Video
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('artikel-siswa.upload') }}"
                            class="nav-link {{ request()->routeIs('artikel-siswa.upload*') || request()->routeIs('artikel-siswa.create*') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle me-1 d-lg-none"></i>Upload
                        </a>
                    </li>
                    @endauth
                    <li class="nav-item d-none d-lg-block">
                        <div class="vr mx-3"></div>
                    </li>
                    @auth('siswa')
                        <!-- Notifikasi Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi">
                                <i class="fas fa-bell fs-5"></i>
                                <span class="notification-badge" id="notificationCount" style="display: none;">0</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end notification-dropdown"
                                aria-labelledby="notificationDropdown">
                                <li class="dropdown-header d-flex justify-content-between align-items-center">
                                    <span>Notifikasi</span>
                                    <button class="btn btn-sm btn-link p-0" onclick="markAllAsRead()"
                                        title="Tandai semua sudah dibaca">
                                        <i class="fas fa-check-double"></i>
                                    </button>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <div id="notificationList">
                                    <li class="dropdown-item text-center text-muted py-3">
                                        <i class="fas fa-spinner fa-spin"></i> Memuat...
                                    </li>
                                </div>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-center" href="{{ route('notifikasi.index') }}">
                                        Lihat Semua Notifikasi
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="{{ route('profil.show') }}" class="nav-link" title="Profil"><i
                                    class="fas fa-user-circle fs-5"></i></a></li>
                        <li class="nav-item ms-lg-3">
                            <form action="{{ route('logout-siswa') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                                    <i class="fas fa-sign-out-alt me-1"></i> Keluar
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('siswa.login') }}" class="btn btn-outline-primary btn-sm rounded-pill me-2">
                                <i class="fas fa-sign-in-alt me-1"></i>Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('siswa.login') }}" class="btn btn-primary btn-sm rounded-pill">
                                <i class="fas fa-user-plus me-1"></i>Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </header>

    <main class="main-wrapper">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer-sekolah pt-5 pb-4">
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-lg-4 col-md-12 mx-auto mb-4">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-3">
                        <div class="footer-logo-wrapper me-3">
                            <img src="{{ asset('images/logo_sekolah.png') }}" alt="Logo SMKN 11 Bandung"
                                style="height: 60px;" class="footer-logo">
                        </div>
                        <div>
                            <h6 class="text-uppercase fw-bold mb-0 footer-school-name">SMK Negeri 11 Bandung</h6>
                            <small class="text-muted">Dinas Pendidikan Provinsi Jawa Barat</small>
                        </div>
                    </div>
                    <p class="footer-description">
                        Platform literasi digital SIPENA hadir sebagai sarana untuk menumbuhkan minat baca dan
                        kreativitas siswa/i SMK Negeri 11 Bandung.
                    </p>
                    <div class="footer-social-media mt-3">
                        <a href="#" class="footer-social-link me-3" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="footer-social-link me-3" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="footer-social-link me-3" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="footer-social-link" title="Website Sekolah">
                            <i class="fas fa-globe"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-6 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4 footer-section-title">Navigasi</h6>
                    <ul class="footer-nav-list">
                        @auth('siswa')
                        <li><a href="{{ route('dashboard-siswa') }}" class="footer-nav-link">
                                <i class="fas fa-home me-2"></i>Beranda</a></li>
                        @endauth
                        <li><a href="{{ route('artikel-siswa.index') }}" class="footer-nav-link">
                                <i class="fas fa-newspaper me-2"></i>Jelajahi Artikel</a></li>
                        @auth('siswa')
                        <li><a href="{{ route('artikel-siswa.upload') }}" class="footer-nav-link">
                                <i class="fas fa-plus-circle me-2"></i>Upload Karya</a></li>
                        @else
                        <li><a href="{{ route('siswa.login') }}" class="footer-nav-link">
                                <i class="fas fa-sign-in-alt me-2"></i>Masuk / Daftar</a></li>
                        @endauth
                        <li><a href="https://www.smkn11bdg.sch.id/contact" target="_blank" class="footer-nav-link">
                                <i class="fas fa-phone me-2"></i>Hubungi Kami</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-8 col-12 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4 footer-section-title">Alamat & Kontak</h6>
                    <div class="footer-contact-info">
                        <p class="footer-contact-item">
                            <i class="fas fa-map-marker-alt me-3 text-primary"></i>
                            Jl. Budhi, Cilember, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa Barat 40175
                        </p>
                        <p class="footer-contact-item">
                            <i class="fas fa-phone me-3 text-primary"></i>
                            <a href="tel:(022) 6652442" class="footer-contact-link">(022) 6652442</a>
                        </p>
                        <p class="footer-contact-item">
                            <i class="fas fa-envelope me-3 text-primary"></i>
                            <a href="mailto:smkn11bdg@gmail.com" class="footer-contact-link">smkn11bdg@gmail.com</a>
                        </p>
                        <p class="footer-contact-item">
                            <i class="fas fa-globe me-3 text-primary"></i>
                            <a href="https://www.smkn11bdg.sch.id" target="_blank" class="footer-contact-link">
                                www.smkn11bdg.sch.id
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <hr class="footer-divider my-4">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 footer-copyright">
                        &copy; {{ date('Y') }} SMK Negeri 11 Bandung.
                        <span class="text-primary fw-semibold">SIPENA</span> - Platform Literasi Digital
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <small class="text-muted">
                        Dibuat dengan <i class="fas fa-heart text-danger"></i> untuk pendidikan
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <button class="back-to-top-btn btn btn-primary" id="backToTop" title="Kembali ke atas">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth navbar animations
            const navbar = document.querySelector('.header');
            let lastScrollTop = 0;

            window.addEventListener('scroll', function() {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > lastScrollTop && scrollTop > 100) {
                    // Scrolling down
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    // Scrolling up
                    navbar.style.transform = 'translateY(0)';
                }

                // Add background when scrolled
                if (scrollTop > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }

                lastScrollTop = scrollTop;
            });

            // Back to top button
            const backToTopBtn = document.getElementById('backToTop');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    backToTopBtn.style.display = 'flex';
                } else {
                    backToTopBtn.style.display = 'none';
                }
            });

            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Enhanced mobile menu animation
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');

            navbarToggler.addEventListener('click', function() {
                this.classList.toggle('active');
            });

            // Close mobile menu when clicking on link
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        navbarCollapse.classList.remove('show');
                        navbarToggler.classList.remove('active');
                    }
                });
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading animation for form submissions
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML =
                            '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                        submitBtn.disabled = true;

                        // Reset after 10 seconds as fallback
                        setTimeout(() => {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        }, 10000);
                    }
                });
            });

            // Animate elements when they come into view
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, observerOptions);

            // Observe elements with animation classes
            document.querySelectorAll('.content-card, .choice-card, .form-card, .animate-ready').forEach(card => {
                card.classList.add('animate-ready');
                observer.observe(card);
            });
        });
    </script>

    @auth('siswa')
        <script>
            // Notification System
            let notificationInterval;

            document.addEventListener('DOMContentLoaded', function() {
                loadNotifications();
                updateNotificationCount();

                // Update setiap 30 detik
                notificationInterval = setInterval(() => {
                    updateNotificationCount();
                }, 30000);
            });

            function loadNotifications() {
                fetch('{{ route('notifikasi.recent') }}')
                    .then(response => response.json())
                    .then(data => {
                        const notificationList = document.getElementById('notificationList');

                        if (data.notifications.length === 0) {
                            notificationList.innerHTML = `
                            <li class="dropdown-item text-center text-muted py-3">
                                <i class="fas fa-inbox"></i><br>
                                Tidak ada notifikasi
                            </li>
                        `;
                            return;
                        }

                        let html = '';
                        data.notifications.forEach(notification => {
                            const isUnread = !notification.sudah_dibaca;
                            const timeAgo = formatTimeAgo(notification.created_at);

                            html += `
                            <li class="notification-item ${isUnread ? 'unread' : ''}" onclick="markAsRead(${notification.id})">
                                <div class="notification-content">
                                    <div class="notification-icon bg-primary text-white">
                                        <i class="${getNotificationIcon(notification.jenis)}"></i>
                                    </div>
                                    <div class="notification-text">
                                        <div class="notification-title">${notification.judul}</div>
                                        <div class="notification-message">${notification.pesan}</div>
                                        <div class="notification-time">${timeAgo}</div>
                                    </div>
                                </div>
                            </li>
                        `;
                        });

                        notificationList.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error loading notifications:', error);
                    });
            }

            function updateNotificationCount() {
                fetch('{{ route('notifikasi.unread-count') }}')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('notificationCount');
                        if (data.count > 0) {
                            badge.textContent = data.count > 99 ? '99+' : data.count;
                            badge.style.display = 'flex';
                        } else {
                            badge.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error updating notification count:', error);
                    });
            }

            function markAsRead(notificationId) {
                fetch('{{ route('notifikasi.mark-read') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            id: notificationId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadNotifications();
                            updateNotificationCount();
                        }
                    })
                    .catch(error => {
                        console.error('Error marking notification as read:', error);
                    });
            }

            function markAllAsRead() {
                fetch('{{ route('notifikasi.mark-read') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadNotifications();
                            updateNotificationCount();
                        }
                    })
                    .catch(error => {
                        console.error('Error marking all notifications as read:', error);
                    });
            }

            function getNotificationIcon(jenis) {
                const icons = {
                    'artikel_disetujui': 'fas fa-check-circle',
                    'artikel_ditolak': 'fas fa-times-circle',
                    'komentar_baru': 'fas fa-comment',
                    'penghargaan': 'fas fa-trophy',
                    'video_disetujui': 'fas fa-video',
                    'video_ditolak': 'fas fa-video',
                    'sistem': 'fas fa-cog'
                };
                return icons[jenis] || 'fas fa-bell';
            }

            function formatTimeAgo(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diffInSeconds = Math.floor((now - date) / 1000);

                if (diffInSeconds < 60) return 'Baru saja';
                if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + ' menit lalu';
                if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + ' jam lalu';
                if (diffInSeconds < 604800) return Math.floor(diffInSeconds / 86400) + ' hari lalu';

                return date.toLocaleDateString('id-ID');
            }

            // Cleanup interval when page unloads
            window.addEventListener('beforeunload', function() {
                if (notificationInterval) {
                    clearInterval(notificationInterval);
                }
            });
        </script>
    @endauth

    @yield('scripts')
</body>

</html>
