@extends('layouts.siswa')

@section('title', 'FAQ - SIPENA')

@section('body_class', 'faq-page')

@section('content')
    <!-- Hero Banner -->
    <div class="hero-banner">
        <div class="container">
            <div class="hero-content text-center text-white">
                <div class="hero-icon mb-3">
                    <i class="fas fa-question-circle fa-3x"></i>
                </div>
                <h1 class="hero-title">Pertanyaan yang Sering Diajukan</h1>
                <p class="hero-subtitle">Temukan jawaban untuk pertanyaan umum seputar platform SIPENA</p>
            </div>
        </div>
        <div class="hero-wave"></div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Accordion FAQ -->
                <div class="accordion faq-accordion" id="faqAccordion">
                    
                    <!-- Kategori: Umum -->
                    <div class="faq-category">
                        <h4 class="faq-category-title">
                            <i class="fas fa-info-circle me-2"></i>Umum
                        </h4>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Apa itu SIPENA?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p><strong>SIPENA (Sistem Informasi Pena)</strong> adalah platform literasi digital yang dikembangkan khusus untuk siswa/i SMK Negeri 11 Bandung. Platform ini bertujuan untuk:</p>
                                    <ul>
                                        <li>Menumbuhkan minat baca dan menulis siswa</li>
                                        <li>Menyediakan wadah untuk berbagi karya tulis (artikel)</li>
                                        <li>Memfasilitasi kreativitas melalui konten video pendek</li>
                                        <li>Membangun komunitas literasi di lingkungan sekolah</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Siapa yang bisa menggunakan SIPENA?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>SIPENA dapat digunakan oleh:</p>
                                    <ul>
                                        <li><strong>Siswa SMK Negeri 11 Bandung</strong> - Dapat membuat akun, menulis artikel, upload video, dan berinteraksi dengan konten lainnya</li>
                                        <li><strong>Pengunjung umum</strong> - Dapat membaca artikel dan menonton video tanpa perlu mendaftar</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Apakah SIPENA gratis?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Ya, SIPENA <strong>100% gratis</strong> untuk semua siswa SMK Negeri 11 Bandung. Tidak ada biaya pendaftaran atau biaya berlangganan.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori: Akun & Registrasi -->
                    <div class="faq-category">
                        <h4 class="faq-category-title">
                            <i class="fas fa-user-circle me-2"></i>Akun & Registrasi
                        </h4>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Bagaimana cara mendaftar akun SIPENA?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Untuk mendaftar akun SIPENA:</p>
                                    <ol>
                                        <li>Klik tombol <strong>"Daftar"</strong> di halaman login</li>
                                        <li>Isi formulir pendaftaran dengan:
                                            <ul>
                                                <li>NIS (Nomor Induk Siswa)</li>
                                                <li>Nama lengkap</li>
                                                <li>Kelas</li>
                                                <li>Email (opsional)</li>
                                                <li>Password</li>
                                            </ul>
                                        </li>
                                        <li>Klik tombol <strong>"Daftar"</strong></li>
                                        <li>Akun Anda siap digunakan!</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    Bagaimana jika saya lupa password?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Jika Anda lupa password, silakan hubungi pihak sekolah atau guru pembimbing untuk reset password. Anda juga bisa menghubungi kami melalui:</p>
                                    <ul>
                                        <li>Email: smkn11bdg@gmail.com</li>
                                        <li>Telepon: (022) 6652442</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori: Artikel -->
                    <div class="faq-category">
                        <h4 class="faq-category-title">
                            <i class="fas fa-newspaper me-2"></i>Artikel
                        </h4>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                    Bagaimana cara menulis artikel?
                                </button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Untuk menulis artikel:</p>
                                    <ol>
                                        <li>Login ke akun SIPENA Anda</li>
                                        <li>Klik menu <strong>"Upload"</strong> di navbar</li>
                                        <li>Pilih <strong>"Tulis Artikel Baru"</strong></li>
                                        <li>Isi judul, konten, pilih kategori, dan upload gambar cover</li>
                                        <li>Klik <strong>"Kirim Artikel"</strong></li>
                                        <li>Artikel akan direview oleh pihak sekolah sebelum dipublikasikan</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                    Berapa lama artikel saya akan direview?
                                </button>
                            </h2>
                            <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Proses review artikel biasanya memakan waktu <strong>1-3 hari kerja</strong>. Anda akan menerima notifikasi ketika artikel Anda disetujui atau ditolak.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                                    Apa saja yang boleh dan tidak boleh ditulis?
                                </button>
                            </h2>
                            <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p><strong>Konten yang diperbolehkan:</strong></p>
                                    <ul>
                                        <li>Artikel edukatif dan informatif</li>
                                        <li>Review buku, film, atau game</li>
                                        <li>Cerita pendek dan puisi</li>
                                        <li>Tips dan tutorial</li>
                                        <li>Opini yang bersifat membangun</li>
                                    </ul>
                                    <p class="mt-3"><strong>Konten yang dilarang:</strong></p>
                                    <ul>
                                        <li>Konten SARA, pornografi, atau kekerasan</li>
                                        <li>Ujaran kebencian atau bullying</li>
                                        <li>Plagiarisme (menjiplak karya orang lain)</li>
                                        <li>Informasi palsu (hoax)</li>
                                        <li>Promosi terlarang</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori: Video -->
                    <div class="faq-category">
                        <h4 class="faq-category-title">
                            <i class="fas fa-video me-2"></i>Video
                        </h4>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                                    Bagaimana cara upload video?
                                </button>
                            </h2>
                            <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Untuk upload video:</p>
                                    <ol>
                                        <li>Login ke akun SIPENA Anda</li>
                                        <li>Klik menu <strong>"Upload"</strong> di navbar</li>
                                        <li>Pilih <strong>"Upload Video Baru"</strong></li>
                                        <li>Isi judul, deskripsi, dan pilih kategori</li>
                                        <li>Pilih file video dari perangkat Anda</li>
                                        <li>Klik <strong>"Upload Video"</strong></li>
                                        <li>Video akan direview oleh pihak sekolah sebelum dipublikasikan</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq10">
                                    Apa syarat video yang bisa diupload?
                                </button>
                            </h2>
                            <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Persyaratan video:</p>
                                    <ul>
                                        <li><strong>Durasi maksimal:</strong> 15 menit</li>
                                        <li><strong>Format:</strong> MP4, WebM, atau OGG</li>
                                        <li><strong>Ukuran maksimal:</strong> 500 MB</li>
                                        <li><strong>Orientasi:</strong> Portrait (9:16) direkomendasikan untuk tampilan optimal</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori: Fitur Interaksi -->
                    <div class="faq-category">
                        <h4 class="faq-category-title">
                            <i class="fas fa-heart me-2"></i>Fitur Interaksi
                        </h4>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq11">
                                    Apa saja fitur interaksi yang tersedia?
                                </button>
                            </h2>
                            <div id="faq11" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>SIPENA menyediakan berbagai fitur interaksi:</p>
                                    <ul>
                                        <li><strong>Like/Suka</strong> - Beri apresiasi pada konten yang Anda sukai</li>
                                        <li><strong>Komentar</strong> - Berikan tanggapan atau feedback</li>
                                        <li><strong>Bookmark</strong> - Simpan konten favorit untuk dibaca nanti</li>
                                        <li><strong>Rating</strong> - Beri rating bintang (1-5) untuk artikel</li>
                                        <li><strong>Share</strong> - Bagikan konten ke media sosial</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq12">
                                    Bagaimana sistem notifikasi bekerja?
                                </button>
                            </h2>
                            <div id="faq12" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Anda akan menerima notifikasi ketika:</p>
                                    <ul>
                                        <li>Artikel/video Anda disetujui atau ditolak</li>
                                        <li>Ada komentar baru di artikel/video Anda</li>
                                        <li>Seseorang menyukai konten Anda</li>
                                        <li>Ada balasan komentar Anda</li>
                                        <li>Anda mendapat penghargaan</li>
                                    </ul>
                                    <p>Notifikasi dapat diakses melalui ikon lonceng di navbar.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori: Penghargaan -->
                    <div class="faq-category">
                        <h4 class="faq-category-title">
                            <i class="fas fa-trophy me-2"></i>Penghargaan Literasi
                        </h4>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq13">
                                    Apa itu Penghargaan Literasi?
                                </button>
                            </h2>
                            <div id="faq13" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p><strong>Penghargaan Literasi</strong> adalah program apresiasi bulanan dari SIPENA untuk siswa yang aktif dan berprestasi dalam membuat konten. Program ini bertujuan untuk:</p>
                                    <ul>
                                        <li>Memberikan apresiasi kepada siswa yang konsisten berkarya</li>
                                        <li>Memotivasi siswa lain untuk terus berkarya</li>
                                        <li>Meningkatkan kualitas konten di platform SIPENA</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq14">
                                    Bagaimana cara menjadi pemenang penghargaan?
                                </button>
                            </h2>
                            <div id="faq14" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Pemenang penghargaan dipilih berdasarkan:</p>
                                    <ul>
                                        <li><strong>Artikel:</strong> Berdasarkan <strong>rating tertinggi</strong> dari pembaca (skala 1-5 bintang)</li>
                                        <li><strong>Video:</strong> Berdasarkan <strong>jumlah like terbanyak</strong> dari penonton</li>
                                    </ul>
                                    <p class="mt-3">Setiap bulan, pihak sekolah akan memilih pemenang dari daftar <strong>Top 3 kandidat terbaik</strong> di masing-masing kategori.</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq15">
                                    Apa hadiah untuk pemenang?
                                </button>
                            </h2>
                            <div id="faq15" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Pemenang penghargaan akan mendapatkan:</p>
                                    <ul>
                                        <li><strong>Sertifikat penghargaan</strong> dari sekolah</li>
                                        <li><strong>Notifikasi khusus</strong> sebagai pengakuan atas pencapaian</li>
                                        <li><strong>Badge/lencana</strong> di profil sebagai tanda penghargaan</li>
                                        <li>Kemungkinan <strong>hadiah tambahan</strong> dari sekolah (diumumkan setiap periode)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq16">
                                    Kapan penghargaan diumumkan?
                                </button>
                            </h2>
                            <div id="faq16" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Penghargaan diumumkan setiap <strong>awal bulan baru</strong>. Pemenang dari bulan sebelumnya akan diumumkan dan menerima notifikasi apresiasi.</p>
                                    <p>Pastikan Anda aktif membuat konten berkualitas sepanjang bulan untuk meningkatkan peluang menjadi pemenang!</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Contact CTA -->
                <div class="faq-contact-cta">
                    <div class="cta-content">
                        <i class="fas fa-headset"></i>
                        <div>
                            <h5>Masih ada pertanyaan?</h5>
                            <p>Hubungi kami melalui email atau telepon untuk bantuan lebih lanjut.</p>
                        </div>
                    </div>
                    <a href="https://www.smkn11bdg.sch.id/contact" target="_blank" class="btn btn-primary">
                        <i class="fas fa-envelope me-2"></i>Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_css')
<style>
    .faq-accordion {
        border-radius: 16px;
        overflow: hidden;
    }
    
    .faq-category {
        margin-bottom: 2rem;
    }
    
    .faq-category-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
    }
    
    .accordion-item {
        border: 1px solid #e2e8f0;
        margin-bottom: 0.5rem;
        border-radius: 12px !important;
        overflow: hidden;
    }
    
    .accordion-button {
        font-weight: 600;
        color: #1e293b;
        background: white;
        padding: 1.25rem;
    }
    
    .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        color: var(--primary);
        box-shadow: none;
    }
    
    .accordion-button:focus {
        box-shadow: none;
        border-color: var(--primary);
    }
    
    .accordion-button::after {
        background-size: 1rem;
    }
    
    .accordion-body {
        padding: 1.25rem;
        background: #f8fafc;
    }
    
    .accordion-body p {
        margin-bottom: 0.75rem;
        line-height: 1.7;
    }
    
    .accordion-body ul, 
    .accordion-body ol {
        margin-bottom: 0;
        padding-left: 1.5rem;
    }
    
    .accordion-body li {
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }
    
    .faq-contact-cta {
        background: linear-gradient(135deg, #1e3a5f 0%, #1e40af 100%);
        border-radius: 16px;
        padding: 2rem;
        margin-top: 3rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.5rem;
    }
    
    .cta-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        color: white;
    }
    
    .cta-content i {
        font-size: 2.5rem;
        opacity: 0.9;
    }
    
    .cta-content h5 {
        margin-bottom: 0.25rem;
        font-weight: 700;
    }
    
    .cta-content p {
        margin-bottom: 0;
        opacity: 0.85;
        font-size: 0.95rem;
    }
    
    .faq-contact-cta .btn-primary {
        background: white;
        color: var(--primary);
        border: none;
        padding: 0.875rem 1.5rem;
        font-weight: 600;
        border-radius: 10px;
    }
    
    .faq-contact-cta .btn-primary:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .faq-contact-cta {
            flex-direction: column;
            text-align: center;
        }
        
        .cta-content {
            flex-direction: column;
            text-align: center;
        }
        
        .faq-contact-cta .btn-primary {
            width: 100%;
        }
    }
</style>
@endsection
