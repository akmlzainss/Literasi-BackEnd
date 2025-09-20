<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $konten->judul }} - SiPena</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/websiswa.css') }}">
</head>
<body class="page-artikel-detail"> 

    <header class="header">
        <nav class="container navbar navbar-expand-lg">
            <a href="{{ route('dashboard-siswa') }}" class="logo"><i class="fas fa-graduation-cap"></i> SIPENA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a href="{{ route('dashboard-siswa') }}" class="nav-link">Beranda</a></li>
                    <li class="nav-item"><a href="{{ route('artikel-siswa') }}" class="nav-link active">Artikel</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Upload</a></li>
                    <li class="nav-item d-none d-lg-block"><div class="vr mx-3"></div></li>
                    @auth('siswa')
                        <li class="nav-item"><a href="#" class="nav-link" title="Notifikasi"><i class="fas fa-bell fs-5"></i></a></li>
                        <li class="nav-item"><a href="#" class="nav-link" title="Profil"><i class="fas fa-user-circle fs-5"></i></a></li>
                        <li class="nav-item ms-lg-3"><form action="{{ route('logout-siswa') }}" method="POST">@csrf<button type="submit" class="btn btn-danger btn-sm">Keluar</button></form></li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Masuk</a></li>
                        <li class="nav-item ms-2"><a href="#" class="btn btn-primary btn-sm">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </nav>
    </header>
    
    <main class="container py-4">
        <section class="content-section">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
      {{-- KODE BARU --}}
<a href="{{ url()->previous() }}" class="btn-kembali mb-4">
    <i class="fas fa-arrow-left me-2"></i>Kembali
</a>
                        @if($konten->gambar)
                            <img src="{{ asset('storage/' . $konten->gambar) }}" alt="{{ $konten->judul }}" class="detail-page-image" onerror="this.style.display='none';">
                        @endif
                        <div class="author-card-siswa">
                            <div class="author-avatar-siswa">{{ strtoupper(substr($konten->siswa->nama ?? 'AD', 0, 2)) }}</div>
                            <div class="author-info-siswa">
                                <p class="name">{{ $konten->siswa->nama ?? 'Admin' }}</p>
                                <p class="date">Dipublikasikan pada {{ $konten->created_at?->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <article>
                        <header>
                            <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill mb-3 fs-6">{{ $konten->kategori->nama ?? 'Umum' }}</span>
                            <h1 class="detail-page-title">{{ $konten->judul }}</h1>
                            <div class="meta-info">
                                <span><i class="fas fa-eye"></i> {{ $konten->jumlah_dilihat }} Dilihat</span>
                                <span id="comment-count"><i class="fas fa-comments"></i> {{ $konten->komentarArtikel->count() }} Komentar</span>
                                <span id="rating-summary">
                                    <i class="fas fa-star"></i> 
                                    @if ($konten->ratingArtikel->count() > 0)
                                        {{ round($konten->ratingArtikel->avg('rating'), 1) }}/5
                                    @else
                                        Belum ada rating
                                    @endif
                                </span>
                                <span id="like-count"><i class="fas fa-heart"></i> {{ $konten->jumlah_suka ?? 0 }} Suka</span>
                            </div>
                        </header>
                        
                        <div class="article-body mt-4">{!! $konten->isi !!}</div>
                    </article>

                    @auth('siswa')
                    <div class="action-buttons-wrapper mt-4">
                        <button class="btn-action {{ $userHasLiked ? 'active' : '' }}" data-action="suka" data-id="{{ $konten->id }}">
                            <i class="{{ $userHasLiked ? 'fas' : 'far' }} fa-heart"></i> Suka
                        </button>
                        <button class="btn-action {{ $userHasBookmarked ? 'active' : '' }}" data-action="bookmark" data-id="{{ $konten->id }}">
                            <i class="{{ $userHasBookmarked ? 'fas' : 'far' }} fa-bookmark"></i> Simpan
                        </button>
                    </div>
                    @endauth

                    <div class="feedback-section mt-4">
                        @auth('siswa')
                            <form id="feedbackForm" action="{{ route('komentar.store', $konten->id) }}" method="POST">
                                @csrf
                                <h3 class="mb-3">Beri Tanggapan Anda</h3>
                                <div class="mb-3">
                                    <label class="form-label">Beri Rating:</label>
                                    <div class="rating-stars">
                                        <input type="radio" id="star5" name="rating" value="5" {{ ($userRating && $userRating->rating == 5) ? 'checked' : '' }} /><label for="star5" title="Luar biasa"><i class="fas fa-star"></i></label>
                                        <input type="radio" id="star4" name="rating" value="4" {{ ($userRating && $userRating->rating == 4) ? 'checked' : '' }} /><label for="star4" title="Bagus"><i class="fas fa-star"></i></label>
                                        <input type="radio" id="star3" name="rating" value="3" {{ ($userRating && $userRating->rating == 3) ? 'checked' : '' }} /><label for="star3" title="Cukup"><i class="fas fa-star"></i></label>
                                        <input type="radio" id="star2" name="rating" value="2" {{ ($userRating && $userRating->rating == 2) ? 'checked' : '' }} /><label for="star2" title="Kurang"><i class="fas fa-star"></i></label>
                                        <input type="radio" id="star1" name="rating" value="1" {{ ($userRating && $userRating->rating == 1) ? 'checked' : '' }} /><label for="star1" title="Buruk"><i class="fas fa-star"></i></label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="komentar" class="form-label">Tulis Komentar:</label>
                                    <textarea class="form-control" id="komentar" name="komentar" rows="4" placeholder="Bagikan pendapat Anda..."></textarea>
                                </div>
                                <button type="submit" id="submitBtn" class="btn btn-primary">Kirim Tanggapan</button>
                            </form>
                        @else
                            <div class="text-center p-4 border rounded">
                                <p class="mb-1">Silakan <a href="{{ route('login') }}">masuk</a> untuk memberi rating dan komentar.</p>
                            </div>
                        @endauth

                        <div class="komentar-section mt-5">
                            <h3 class="mb-4" id="comment-title">Komentar ({{ $konten->komentarArtikel->count() }})</h3>
                            <div id="comment-list">
                                @forelse($konten->komentarArtikel as $komentar)
                                    @include('partials.komentar', ['komentar' => $komentar])
                                @empty
                                    <p id="no-comment-msg">Belum ada komentar. Jadilah yang pertama!</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white text-center p-3 mt-4">
        <p class="mb-0">&copy; {{ date('Y') }} EduHub. Hak Cipta Dilindungi.</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.querySelectorAll('.btn-action').forEach(button => {
            button.addEventListener('click', function() {
                this.disabled = true;
                const jenis = this.dataset.action;
                const artikelId = this.dataset.id;
                const url = `/artikel-siswa/${artikelId}/interaksi`;

                fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ jenis: jenis })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.classList.toggle('active');
                        const icon = this.querySelector('i');
                        icon.classList.toggle('far');
                        icon.classList.toggle('fas');
                        if (jenis === 'suka') {
                            document.getElementById('like-count').innerHTML = `<i class="fas fa-heart"></i> ${data.like_count} Suka`;
                        }
                    }
                })
                .catch(error => console.error('Error:', error))
                .finally(() => { this.disabled = false; });
            });
        });
        
        const form = document.getElementById('feedbackForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const submitBtn = document.getElementById('submitBtn');
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengirim...';

                fetch(form.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: new FormData(form)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        submitBtn.classList.replace('btn-primary', 'btn-success');
                        submitBtn.innerHTML = '<i class="fas fa-check"></i> Terkirim!';
                        
                        const ratingSummary = document.getElementById('rating-summary');
                        if (data.new_rating_count > 0) {
                            ratingSummary.innerHTML = `<i class="fas fa-star"></i> ${data.new_avg_rating}/5`;
                        }

                        const commentCount = document.getElementById('comment-count');
                        const commentTitle = document.getElementById('comment-title');
                        commentCount.innerHTML = `<i class="fas fa-comments"></i> ${data.new_comment_count} Komentar`;
                        commentTitle.innerText = `Komentar (${data.new_comment_count})`;
                        
                        if (data.new_comment_html) {
                            document.getElementById('no-comment-msg')?.remove();
                            const commentList = document.getElementById('comment-list');
                            const newCommentEl = document.createElement('div');
                            newCommentEl.innerHTML = data.new_comment_html;
                            newCommentEl.querySelector('.komentar-item').classList.add('new-comment');
                            commentList.prepend(newCommentEl);
                        }

                        setTimeout(() => {
                            form.reset();
                            const checkedStar = document.querySelector('.rating-stars input:checked');
                            if (checkedStar) checkedStar.checked = false;
                            submitBtn.disabled = false;
                            submitBtn.classList.replace('btn-success', 'btn-primary');
                            submitBtn.innerHTML = originalBtnText;
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                    alert('Terjadi kesalahan.');
                });
            });
        }
    });
    </script>
</body>
</html>