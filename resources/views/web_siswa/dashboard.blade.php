<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - EduHub</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/websiswa.css">
</head>

<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="nav-brand d-flex align-items-center">
                    <i class="fas fa-graduation-cap me-2"></i>EduHub
                </div>
                <div class="user-profile">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <div class="d-none d-md-block text-end">
                        <div class="fw-semibold">John Doe</div>
                        <small class="text-muted">Siswa Aktif</small>
                    </div>
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face"
                        alt="Profile" class="user-avatar">
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Welcome Section -->
        <section class="welcome-section fade-in">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="welcome-title">Selamat Datang Kembali! 👋</h1>
                    <p class="welcome-subtitle">Mari lanjutkan perjalanan belajar Anda. Hari ini adalah kesempatan baru
                        untuk tumbuh dan berkembang.</p>
                    <div class="quick-actions">
                        <a href="#" class="quick-action-btn"><i class="fas fa-plus"></i>Buat Artikel Baru</a>
                        <a href="#" class="quick-action-btn secondary"><i class="fas fa-book-open"></i>Jelajahi
                            Konten</a>
                        <a href="#" class="quick-action-btn secondary"><i class="fas fa-chart-line"></i>Lihat
                            Progress</a>
                    </div>
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <div class="welcome-illustration">
                        <i class="fas fa-rocket"
                            style="font-size: 6rem; color: var(--primary-light); opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Content Grid -->
        <div class="content-grid fade-in fade-in-delay-2">
            <!-- Articles Section -->
            <section class="articles-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <div class="section-icon"><i class="fas fa-fire"></i></div>
                        Artikel Trending
                    </h2>
                </div>
                <div class="articles-grid">
                    <div class="article-card p-3 d-flex">
                        <img src="https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?w=400&h=300&fit=crop"
                            alt="AI dalam Pendidikan" class="article-image">
                        <div class="article-content">
                            <h5 class="article-title">Revolusi AI dalam Pendidikan Modern</h5>
                            <div class="article-meta">
                                <div class="article-author">
                                    <div class="author-avatar-sm">JD</div>
                                    <span>John Doe</span>
                                </div>
                                <span>•</span>
                                <span>2.1K views</span>
                                <span>•</span>
                                <span>5 min read</span>
                            </div>
                        </div>
                    </div>
                    <div class="article-card p-3 d-flex">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=300&fit=crop"
                            alt="Pembelajaran Interaktif" class="article-image">
                        <div class="article-content">
                            <h5 class="article-title">Metode Pembelajaran Interaktif yang Efektif</h5>
                            <div class="article-meta">
                                <div class="article-author">
                                    <div class="author-avatar-sm">SA</div>
                                    <span>Sarah Ahmad</span>
                                </div>
                                <span>•</span>
                                <span>1.8K views</span>
                                <span>•</span>
                                <span>7 min read</span>
                            </div>
                        </div>
                    </div>
                    <div class="article-card p-3 d-flex">
                        <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&h=300&fit=crop"
                            alt="Coding untuk Pemula" class="article-image">
                        <div class="article-content">
                            <h5 class="article-title">Panduan Coding untuk Generasi Milenial</h5>
                            <div class="article-meta">
                                <div class="article-author">
                                    <div class="author-avatar-sm">MR</div>
                                    <span>Mike Rogers</span>
                                </div>
                                <span>•</span>
                                <span>3.2K views</span>
                                <span>•</span>
                                <span>12 min read</span>
                            </div>
                        </div>
                    </div>
                    <div class="article-card p-3 d-flex">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop"
                            alt="Study Tips" class="article-image">
                        <div class="article-content">
                            <h5 class="article-title">10 Tips Study Smart untuk Mahasiswa</h5>
                            <div class="article-meta">
                                <div class="article-author">
                                    <div class="author-avatar-sm">AL</div>
                                    <span>Anna Lee</span>
                                </div>
                                <span>•</span>
                                <span>2.5K views</span>
                                <span>•</span>
                                <span>8 min read</span>
                            </div>
                        </div>
                    </div>
                    <div class="article-card p-3 d-flex">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=400&h=300&fit=crop"
                            alt="Digital Marketing" class="article-image">
                        <div class="article-content">
                            <h5 class="article-title">Strategi Digital Marketing untuk Pemula</h5>
                            <div class="article-meta">
                                <div class="article-author">
                                    <div class="author-avatar-sm">RK</div>
                                    <span>Rizky Kurniawan</span>
                                </div>
                                <span>•</span>
                                <span>1.9K views</span>
                                <span>•</span>
                                <span>6 min read</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-outline-primary rounded-pill px-4"><i
                            class="fas fa-plus me-2"></i>Lihat Semua Artikel</a>
                </div>
            </section>

            <!-- Sidebar -->
            <aside class="sidebar fade-in fade-in-delay-3">
                <!-- Profile Card -->
                <div class="sidebar-card profile-card">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face"
                        alt="Profile" class="profile-avatar-lg">
                    <h5 class="profile-name">John Doe</h5>
                    <p class="profile-email">john.doe@student.edu</p>
                    <div class="profile-stats">
                        <div class="profile-stat">
                            <div class="profile-stat-number">24</div>
                            <div class="profile-stat-label">Artikel</div>
                        </div>
                        <div class="profile-stat">
                            <div class="profile-stat-number">4.2K</div>
                            <div class="profile-stat-label">Views</div>
                        </div>
                        <div class="profile-stat">
                            <div class="profile-stat-number">892</div>
                            <div class="profile-stat-label">Likes</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted"><i class="fas fa-calendar me-1"></i>Bergabung September 2024</small>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="sidebar-card">
                    <h6 class="mb-3"><i class="fas fa-clock me-2 text-primary"></i>Aktivitas Terbaru</h6>
                    <div class="activity-item">
                        <div class="activity-icon-wrapper blue"><i class="fas fa-plus"></i></div>
                        <div class="activity-content">
                            <h6>Artikel Baru Dipublish</h6>
                            <p class="mb-1 text-muted small">"Tips Study Smart untuk Mahasiswa"</p>
                            <div class="activity-time">2 jam lalu</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon-wrapper green"><i class="fas fa-heart"></i></div>
                        <div class="activity-content">
                            <h6>Mendapat 25 Likes Baru</h6>
                            <p class="mb-1 text-muted small">Artikel "Revolusi AI dalam Pendidikan"</p>
                            <div class="activity-time">5 jam lalu</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon-wrapper orange"><i class="fas fa-trophy"></i></div>
                        <div class="activity-content">
                            <h6>Badge Baru Diraih</h6>
                            <p class="mb-1 text-muted small">"Content Creator" badge</p>
                            <div class="activity-time">1 hari lalu</div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Lihat Semua</a>
                    </div>
                </div>

                <!-- Progress Card -->
                <div class="sidebar-card">
                    <h6 class="mb-3"><i class="fas fa-chart-line me-2 text-primary"></i>Progress Bulan Ini</h6>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Target Artikel</small>
                            <small class="text-primary">8/10</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Views Target</small>
                            <small class="text-success">4.2K/5K</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 84%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Engagement Rate</small>
                            <small class="text-info">21%</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: 21%"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <small class="text-muted"><i class="fas fa-fire text-warning me-1"></i>Performa sangat baik!
                            🚀</small>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="sidebar-card">
                    <h6 class="mb-3"><i class="fas fa-link me-2 text-primary"></i>Link Cepat</h6>
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary btn-sm text-start"><i
                                class="fas fa-edit me-2"></i>Draft Artikel</a>
                        <a href="#" class="btn btn-outline-primary btn-sm text-start"><i
                                class="fas fa-bookmark me-2"></i>Artikel Tersimpan</a>
                        <a href="#" class="btn btn-outline-primary btn-sm text-start"><i
                                class="fas fa-users me-2"></i>Following</a>
                        <a href="#" class="btn btn-outline-primary btn-sm text-start"><i
                                class="fas fa-cog me-2"></i>Pengaturan</a>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Animate elements on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            document.querySelectorAll('.fade-in').forEach(el => {
                el.style.animationPlayState = 'paused';
                observer.observe(el);
            });

            // Stats card hover effects
            document.querySelectorAll('.stats-card').forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-10px) rotateX(5deg) scale(1.02)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0) rotateX(0deg) scale(1)';
                });
            });

            // Notification bell interaction
            const notificationBtn = document.querySelector('.notification-btn');
            notificationBtn.addEventListener('click', () => {
                notificationBtn.style.animation = 'none';
                setTimeout(() => {
                    notificationBtn.style.animation = 'pulse 2s infinite';
                }, 100);
            });

            // Progress bar animations
            document.querySelectorAll('.progress-bar').forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.transition = 'width 1.5s ease-out';
                    bar.style.width = width;
                }, 500);
            });

            // Button ripple effect
            document.querySelectorAll('.quick-action-btn, .btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const ripple = document.createElement('span');
                    const rect = btn.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        left: ${x}px;
                        top: ${y}px;
                        background: rgba(255, 255, 255, 0.5);
                        border-radius: 50%;
                        pointer-events: none;
                        animation: ripple 0.6s linear;
                    `;
                    btn.style.position = 'relative';
                    btn.style.overflow = 'hidden';
                    btn.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector(anchor.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Hide nav on scroll down
            let lastScrollY = window.scrollY;
            window.addEventListener('scroll', () => {
                const nav = document.querySelector('.top-nav');
                if (window.scrollY > lastScrollY && window.scrollY > 100) {
                    nav.style.transform = 'translateY(-100%)';
                } else {
                    nav.style.transform = 'translateY(0)';
                }
                lastScrollY = window.scrollY;
            });

            // Performance monitoring
            window.addEventListener('load', () => {
                document.body.classList.add('loaded');
                if (window.performance) {
                    const loadTime = window.performance.timing.loadEventEnd - window.performance.timing
                        .navigationStart;
                    console.log('Page load time:', loadTime + 'ms');
                }
            });
        });
    </script>
</body>

</html>
