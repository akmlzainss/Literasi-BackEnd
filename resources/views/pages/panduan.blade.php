@extends('layouts.siswa')

@section('title', 'Panduan Penggunaan - SIPENA')

@section('body_class', 'panduan-page')

@section('content')
    <!-- Hero Banner -->
    <div class="hero-banner">
        <div class="container">
            <div class="hero-content text-center text-white">
                <div class="hero-icon mb-3">
                    <i class="fas fa-book-open fa-3x"></i>
                </div>
                <h1 class="hero-title">Panduan Penggunaan SIPENA</h1>
                <p class="hero-subtitle">Pelajari cara menggunakan platform literasi digital dengan mudah</p>
            </div>
        </div>
        <div class="hero-wave"></div>
    </div>

    <div class="container py-5">
        <!-- Quick Navigation -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="quick-nav">
                    <h6 class="quick-nav-title text-center">Navigasi Cepat</h6>
                    <div class="quick-nav-items justify-content-center">
                        <a href="{{ route('siswa.login') }}" class="quick-nav-item">
                            <i class="fas fa-rocket"></i>
                            <span>Memulai</span>
                        </a>
                        <a href="{{ route('artikel-siswa.index') }}" class="quick-nav-item">
                            <i class="fas fa-newspaper"></i>
                            <span>Jelajahi Artikel</span>
                        </a>
                        <a href="{{ route('video.index') }}" class="quick-nav-item">
                            <i class="fas fa-video"></i>
                            <span>Jelajahi Video</span>
                        </a>
                        <a href="{{ route('faq') }}" class="quick-nav-item">
                            <i class="fas fa-question-circle"></i>
                            <span>FAQ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guide Sections -->
        <div class="row">
            <div class="col-lg-10 mx-auto">
                
                <!-- Section: Memulai -->
                <section class="guide-section" id="memulai">
                    <div class="guide-header">
                        <div class="guide-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <div>
                            <h2 class="guide-title">Memulai dengan SIPENA</h2>
                            <p class="guide-subtitle">Langkah pertama untuk bergabung dengan komunitas literasi</p>
                        </div>
                    </div>
                    
                    <div class="guide-content">
                        <div class="guide-step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h5>Buat Akun Baru</h5>
                                <p>Klik tombol <strong>"Daftar"</strong> di halaman login. Isi formulir dengan data yang valid:</p>
                                <ul>
                                    <li><strong>NIS:</strong> Nomor Induk Siswa Anda (unik untuk setiap siswa)</li>
                                    <li><strong>Nama Lengkap:</strong> Sesuai data sekolah</li>
                                    <li><strong>Kelas:</strong> Contoh: XI RPL 1</li>
                                    <li><strong>Email:</strong> Opsional, untuk notifikasi</li>
                                    <li><strong>Password:</strong> Minimal 6 karakter</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h5>Login ke Akun</h5>
                                <p>Setelah mendaftar, login menggunakan <strong>NIS</strong> dan <strong>password</strong> yang sudah Anda buat. Anda akan diarahkan ke halaman Beranda.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h5>Jelajahi Konten</h5>
                                <p>Dari Beranda, Anda bisa:</p>
                                <ul>
                                    <li>Melihat <strong>statistik personal</strong> (artikel, views, rating)</li>
                                    <li>Membaca <strong>artikel populer</strong> dan terbaru</li>
                                    <li>Mencari artikel berdasarkan kategori, bulan, atau kata kunci</li>
                                    <li>Menonton video dari siswa lain</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section: Menulis Artikel -->
                <section class="guide-section" id="artikel">
                    <div class="guide-header">
                        <div class="guide-icon artikel">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div>
                            <h2 class="guide-title">Menulis Artikel</h2>
                            <p class="guide-subtitle">Bagikan ide dan cerita melalui tulisan</p>
                        </div>
                    </div>
                    
                    <div class="guide-content">
                        <div class="guide-step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h5>Akses Halaman Upload</h5>
                                <p>Klik menu <strong>"Upload"</strong> di navbar, lalu pilih <strong>"Tulis Artikel Baru"</strong>.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h5>Tulis Konten Artikel</h5>
                                <p>Gunakan editor yang tersedia untuk menulis. Anda bisa:</p>
                                <ul>
                                    <li>Memformat teks (bold, italic, heading)</li>
                                    <li>Membuat daftar (bullet/numbered)</li>
                                    <li>Menambahkan link</li>
                                </ul>
                                <div class="tip-box">
                                    <i class="fas fa-lightbulb"></i>
                                    <span><strong>Tips:</strong> Judul yang menarik dan konten yang berkualitas akan mendapat lebih banyak pembaca!</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h5>Pilih Kategori & Cover</h5>
                                <p>Di sidebar kanan:</p>
                                <ul>
                                    <li>Pilih <strong>kategori</strong> yang sesuai dengan artikel Anda</li>
                                    <li>Upload <strong>gambar cover</strong> (format JPG/PNG, maks 2MB)</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h5>Kirim untuk Review</h5>
                                <p>Klik <strong>"Kirim Artikel"</strong>. Artikel akan direview admin dalam 1-3 hari kerja. Anda akan mendapat notifikasi ketika artikel disetujui.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section: Upload Video -->
                <section class="guide-section" id="video">
                    <div class="guide-header">
                        <div class="guide-icon video">
                            <i class="fas fa-video"></i>
                        </div>
                        <div>
                            <h2 class="guide-title">Upload Video</h2>
                            <p class="guide-subtitle">Tunjukkan kreativitas melalui video pendek</p>
                        </div>
                    </div>
                    
                    <div class="guide-content">
                        <div class="info-box">
                            <h6><i class="fas fa-info-circle me-2"></i>Persyaratan Video</h6>
                            <div class="info-grid">
                                <div class="info-item">
                                    <i class="fas fa-clock"></i>
                                    <span>Durasi: Maks 15 menit</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-file-video"></i>
                                    <span>Format: MP4, WebM, OGG</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-weight"></i>
                                    <span>Ukuran: Maks 500 MB</span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-mobile-alt"></i>
                                    <span>Portrait (9:16) direkomendasikan</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h5>Akses Halaman Upload</h5>
                                <p>Klik menu <strong>"Upload"</strong> di navbar, lalu pilih <strong>"Upload Video Baru"</strong>.</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h5>Isi Informasi Video</h5>
                                <ul>
                                    <li><strong>Judul:</strong> Beri judul yang menarik dan deskriptif</li>
                                    <li><strong>Deskripsi:</strong> Jelaskan isi video secara singkat</li>
                                    <li><strong>Kategori:</strong> Pilih kategori yang sesuai</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h5>Upload File Video</h5>
                                <p>Klik area upload atau drag & drop file video Anda. Tunggu proses upload selesai (bisa memakan waktu beberapa menit tergantung ukuran file).</p>
                            </div>
                        </div>
                        
                        <div class="guide-step">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h5>Tunggu Persetujuan</h5>
                                <p>Video akan direview oleh admin. Setelah disetujui, video akan tampil di galeri dan bisa ditonton oleh semua pengguna.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section: Interaksi -->
                <section class="guide-section" id="interaksi">
                    <div class="guide-header">
                        <div class="guide-icon interaksi">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div>
                            <h2 class="guide-title">Fitur Interaksi</h2>
                            <p class="guide-subtitle">Berinteraksi dengan konten dan pengguna lain</p>
                        </div>
                    </div>
                    
                    <div class="guide-content">
                        <div class="feature-grid">
                            <div class="feature-card">
                                <div class="feature-icon like">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <h6>Like / Suka</h6>
                                <p>Klik ikon hati untuk menyukai artikel atau video. Penulis akan mendapat notifikasi.</p>
                            </div>
                            
                            <div class="feature-card">
                                <div class="feature-icon comment">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <h6>Komentar</h6>
                                <p>Berikan feedback, pertanyaan, atau apresiasi melalui komentar.</p>
                            </div>
                            
                            <div class="feature-card">
                                <div class="feature-icon bookmark">
                                    <i class="fas fa-bookmark"></i>
                                </div>
                                <h6>Bookmark</h6>
                                <p>Simpan konten favorit untuk dibaca atau ditonton nanti.</p>
                            </div>
                            
                            <div class="feature-card">
                                <div class="feature-icon rating">
                                    <i class="fas fa-star"></i>
                                </div>
                                <h6>Rating</h6>
                                <p>Beri rating bintang (1-5) untuk artikel sebagai feedback kualitas.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section: Profil -->
                <section class="guide-section" id="profil">
                    <div class="guide-header">
                        <div class="guide-icon profil">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h2 class="guide-title">Kelola Profil</h2>
                            <p class="guide-subtitle">Personalisasi akun dan lihat statistik Anda</p>
                        </div>
                    </div>
                    
                    <div class="guide-content">
                        <p>Akses halaman profil dengan klik avatar di navbar, lalu pilih <strong>"Profil"</strong>.</p>
                        
                        <h5 class="mt-4 mb-3">Yang bisa Anda lakukan di halaman Profil:</h5>
                        <ul class="guide-list">
                            <li><i class="fas fa-check text-success me-2"></i>Melihat statistik (artikel ditulis, views, rating rata-rata)</li>
                            <li><i class="fas fa-check text-success me-2"></i>Mengubah foto profil</li>
                            <li><i class="fas fa-check text-success me-2"></i>Mengupdate data diri (nama, email, bio)</li>
                            <li><i class="fas fa-check text-success me-2"></i>Mengubah password</li>
                            <li><i class="fas fa-check text-success me-2"></i>Melihat daftar artikel yang sudah ditulis</li>
                            <li><i class="fas fa-check text-success me-2"></i>Melihat video yang disukai dan disimpan</li>
                        </ul>
                    </div>
                </section>

                <!-- Section: Penghargaan -->
                <section class="guide-section" id="penghargaan">
                    <div class="guide-header">
                        <div class="guide-icon penghargaan">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <h2 class="guide-title">Penghargaan Literasi</h2>
                            <p class="guide-subtitle">Dapatkan apresiasi atas karya terbaik Anda!</p>
                        </div>
                    </div>
                    
                    <div class="guide-content">
                        <div class="info-box" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                            <h6 style="color: #b45309;"><i class="fas fa-award me-2"></i>Program Apresiasi Bulanan</h6>
                            <p style="color: #92400e; margin-bottom: 0;">SIPENA memberikan penghargaan kepada siswa dengan karya terbaik setiap bulan!</p>
                        </div>
                        
                        <h5 class="mt-4 mb-3">Kriteria Pemenang:</h5>
                        <div class="feature-grid">
                            <div class="feature-card">
                                <div class="feature-icon" style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); color: #16a34a;">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                                <h6>Artikel Terbaik</h6>
                                <p>Dipilih berdasarkan <strong>rating tertinggi</strong> dari pembaca (1-5 bintang)</p>
                            </div>
                            
                            <div class="feature-card">
                                <div class="feature-icon" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #dc2626;">
                                    <i class="fas fa-video"></i>
                                </div>
                                <h6>Video Terbaik</h6>
                                <p>Dipilih berdasarkan <strong>jumlah like terbanyak</strong> dari penonton</p>
                            </div>
                        </div>
                        
                        <h5 class="mt-4 mb-3">Hadiah Pemenang:</h5>
                        <ul class="guide-list">
                            <li><i class="fas fa-certificate text-warning me-2"></i>Sertifikat penghargaan dari sekolah</li>
                            <li><i class="fas fa-bell text-primary me-2"></i>Notifikasi khusus sebagai pengakuan</li>
                            <li><i class="fas fa-medal text-danger me-2"></i>Badge/lencana di profil</li>
                            <li><i class="fas fa-gift text-success me-2"></i>Hadiah tambahan (diumumkan setiap periode)</li>
                        </ul>
                        
                        <div class="tip-box">
                            <i class="fas fa-lightbulb"></i>
                            <span><strong>Tips:</strong> Buat konten berkualitas secara konsisten dan ajak teman untuk memberi rating/like pada karya Anda!</span>
                        </div>
                    </div>
                </section>

                <!-- Contact CTA -->
                <div class="panduan-cta">
                    <div class="cta-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <div class="cta-text">
                        <h5>Butuh Bantuan Lebih?</h5>
                        <p>Kunjungi halaman FAQ atau hubungi kami untuk pertanyaan lainnya.</p>
                    </div>
                    <div class="cta-buttons">
                        <a href="{{ route('faq') }}" class="btn btn-outline-light">
                            <i class="fas fa-book me-2"></i>Lihat FAQ
                        </a>
                        <a href="https://www.smkn11bdg.sch.id/contact" target="_blank" class="btn btn-light">
                            <i class="fas fa-envelope me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('additional_css')
<style>
    /* Quick Navigation */
    .quick-nav {
        background: white;
        border-radius: 16px;
        padding: 1.5rem 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
    }
    
    .quick-nav-title {
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        margin-bottom: 1rem;
    }
    
    .quick-nav-items {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .quick-nav-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: #f8fafc;
        border-radius: 10px;
        color: #475569;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
        border: 1px solid #e2e8f0;
    }
    
    .quick-nav-item:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: translateY(-2px);
    }
    
    .quick-nav-item i {
        font-size: 1rem;
    }

    /* Guide Section */
    .guide-section {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
    }
    
    .guide-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f1f5f9;
    }
    
    .guide-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .guide-icon.artikel {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    
    .guide-icon.video {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }
    
    .guide-icon.interaksi {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
    }
    
    .guide-icon.profil {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }
    
    .guide-icon.penghargaan {
        background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);
    }
    
    .guide-icon i {
        font-size: 1.75rem;
        color: white;
    }
    
    .guide-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }
    
    .guide-subtitle {
        color: #64748b;
        margin-bottom: 0;
    }

    /* Guide Steps */
    .guide-step {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 12px;
        border-left: 4px solid var(--primary);
    }
    
    .step-number {
        width: 40px;
        height: 40px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    
    .step-content h5 {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    
    .step-content p {
        color: #475569;
        margin-bottom: 0.75rem;
        line-height: 1.7;
    }
    
    .step-content ul, 
    .step-content ol {
        margin-bottom: 0;
        padding-left: 1.25rem;
    }
    
    .step-content li {
        color: #475569;
        margin-bottom: 0.35rem;
    }

    /* Tip Box */
    .tip-box {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 1rem;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 10px;
        margin-top: 1rem;
    }
    
    .tip-box i {
        color: #d97706;
        font-size: 1.25rem;
        margin-top: 2px;
    }
    
    .tip-box span {
        color: #92400e;
        font-size: 0.9rem;
    }

    /* Info Box */
    .info-box {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .info-box h6 {
        color: var(--primary);
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #1e40af;
        font-size: 0.9rem;
    }
    
    .info-item i {
        width: 20px;
        text-align: center;
    }

    /* Feature Grid */
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    
    .feature-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    
    .feature-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.25rem;
    }
    
    .feature-icon.like {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #dc2626;
    }
    
    .feature-icon.comment {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #2563eb;
    }
    
    .feature-icon.bookmark {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #d97706;
    }
    
    .feature-icon.rating {
        background: linear-gradient(135deg, #fef9c3 0%, #fef08a 100%);
        color: #ca8a04;
    }
    
    .feature-card h6 {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    
    .feature-card p {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 0;
        line-height: 1.5;
    }

    /* Guide List */
    .guide-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .guide-list li {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
    }
    
    .guide-list li:last-child {
        border-bottom: none;
    }

    /* Panduan CTA */
    .panduan-cta {
        background: linear-gradient(135deg, #1e3a5f 0%, #1e40af 100%);
        border-radius: 20px;
        padding: 2.5rem;
        display: flex;
        align-items: center;
        gap: 2rem;
        color: white;
        margin-top: 2rem;
    }
    
    .cta-icon {
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.15);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .cta-icon i {
        font-size: 2rem;
    }
    
    .cta-text {
        flex: 1;
    }
    
    .cta-text h5 {
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .cta-text p {
        margin-bottom: 0;
        opacity: 0.85;
    }
    
    .cta-buttons {
        display: flex;
        gap: 1rem;
        flex-shrink: 0;
    }
    
    .cta-buttons .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 10px;
    }
    
    .cta-buttons .btn-light {
        background: white;
        color: var(--primary);
    }
    
    .cta-buttons .btn-light:hover {
        background: #f1f5f9;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .guide-section {
            padding: 1.5rem;
        }
        
        .guide-header {
            flex-direction: column;
            text-align: center;
        }
        
        .guide-step {
            flex-direction: column;
            gap: 1rem;
        }
        
        .panduan-cta {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }
        
        .cta-buttons {
            width: 100%;
            flex-direction: column;
        }
        
        .cta-buttons .btn {
            width: 100%;
        }
    }
</style>
@endsection
