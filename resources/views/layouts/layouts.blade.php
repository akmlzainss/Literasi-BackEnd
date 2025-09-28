<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Web Siswa - SMKN 11 Bandung')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/websiswa.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    @yield('additional_css')
</head>

<body class="@yield('body_class', '')">

    <header class="header">
        <nav class="container navbar navbar-expand-lg">
            <a href="{{ route('dashboard-siswa') }}" class="logo">
                <i class="fas fa-graduation-cap"></i> SIPENA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon">
                    <i class="fas fa-bars"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a href="{{ route('dashboard-siswa') }}"
                            class="nav-link {{ request()->routeIs('dashboard-siswa') ? 'active' : '' }}">
                            <i class="fas fa-home me-1 d-lg-none"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('artikel-siswa*') && !request()->routeIs('artikel-siswa.upload*') && !request()->routeIs('artikel-siswa.create*') ? 'active' : '' }}"
                            href="{{ route('artikel-siswa.index') }}">
                            <i class="fas fa-newspaper me-1 d-lg-none"></i>Artikel
                        </a>
                    </li>
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
                    <li class="nav-item d-none d-lg-block">
                        <div class="vr mx-3"></div>
                    </li>
                    @auth('siswa')
                        <li class="nav-item"><a href="{{ route('notifikasi.index') }}" class="nav-link"
                                title="Notifikasi"><i class="fas fa-bell fs-5"></i></a></li>
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
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill me-2">
                                <i class="fas fa-sign-in-alt me-1"></i>Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="btn btn-primary btn-sm rounded-pill">
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
                        <li><a href="{{ route('dashboard-siswa') }}" class="footer-nav-link">
                                <i class="fas fa-home me-2"></i>Beranda</a></li>
                        <li><a href="{{ route('artikel-siswa.index') }}" class="footer-nav-link">
                                <i class="fas fa-newspaper me-2"></i>Jelajahi Artikel</a></li>
                        <li><a href="{{ route('artikel-siswa.upload') }}" class="footer-nav-link">
                                <i class="fas fa-plus-circle me-2"></i>Upload Karya</a></li>
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

    @yield('scripts')
</body>

</html>
