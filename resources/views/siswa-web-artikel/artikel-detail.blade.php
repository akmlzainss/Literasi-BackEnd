@extends('layouts.layouts')

@section('title', $konten->judul . ' - SiPena')

@section('body_class', 'page-artikel-detail')

@php \Carbon\Carbon::setLocale('id'); @endphp

@section('content')
    <div class="container py-4">
        <section class="content-section">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 100px;">
                        <a href="{{ session('previous_artikel_url', route('artikel-siswa.index')) }}" class="btn-kembali mb-4">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        @if ($konten->gambar)
                            <img src="{{ asset('storage/' . $konten->gambar) }}"
                                alt="{{ $konten->judul ?? 'Gambar Artikel' }}" class="detail-page-image"
                                onerror="this.src='{{ asset('images/fallback.jpg') }}';">
                        @else
                            <img src="{{ asset('images/fallback.jpg') }}" alt="Gambar Default" class="detail-page-image">
                        @endif
                        <div class="author-card-siswa mt-3">
                            <div class="author-avatar-siswa">
                                {{ strtoupper(substr($konten->siswa->nama ?? 'AD', 0, 2)) }}
                            </div>
                            <div class="author-info-siswa">
                                <p class="name">{{ $konten->siswa->nama ?? 'Admin' }}</p>
                                <p class="date">
                                    Dipublikasikan pada
                                    {{ $konten->created_at ? $konten->created_at->translatedFormat('d F Y') : 'Tanggal tidak tersedia' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <article>
                        <header>
                            <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill mb-3 fs-6">{{ $konten->kategori->nama ?? 'Umum' }}</span>
                            <h1 class="detail-page-title">{{ $konten->judul ?? 'Judul Tidak Tersedia' }}</h1>
                            <div class="meta-info">
                                <span><i class="fas fa-eye"></i> {{ $konten->jumlah_dilihat ?? 0 }} Dilihat</span>
                                <span id="comment-count"><i class="fas fa-comments"></i> {{ $konten->komentarArtikel->count() ?? 0 }} Komentar</span>
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
                        <div class="article-body mt-4">{!! $konten->isi ?? 'Konten tidak tersedia' !!}</div>
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
                                    <div class="rating-stars-modern">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $userRating && $userRating->rating == $i ? 'checked' : '' }}
                                                   class="rating-input">
                                            <label for="star{{ $i }}" class="rating-label" title="{{ ['Buruk', 'Kurang', 'Cukup', 'Bagus', 'Luar Biasa'][$i - 1] }}">
                                                <i class="fas fa-star"></i>
                                            </label>
                                        @endfor
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
                                    @include('partials.komentar', ['komentar' => $komentar, 'konten' => $konten])
                                    @auth('siswa')
                                        <button class="btn btn-outline-secondary btn-sm mt-2 btn-reply" data-id="{{ $komentar->id }}">Balas</button>
                                        <form action="{{ route('komentar.store', [$konten->id, $komentar->id]) }}" method="POST" class="reply-form mt-2" style="display: none;">
                                            @csrf
                                            <div class="mb-3">
                                                <textarea class="form-control" name="komentar" rows="2" placeholder="Tulis balasan Anda..."></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">Kirim Balasan</button>
                                            <button type="button" class="btn btn-secondary btn-sm btn-cancel-reply">Batal</button>
                                        </form>
                                    @endauth
                                @empty
                                    <p id="no-comment-msg">Belum ada komentar. Jadilah yang pertama!</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('styles')
    <style>
        /* Kode CSS yang sudah ada dan diperbarui */
        .rating-stars-modern {
            display: flex;
            gap: 0.25rem;
            direction: rtl; /* Membuat bintang terbalik untuk efek hover */
            margin-bottom: 0.5rem;
        }

        .rating-label {
            font-size: 1.5rem;
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.3s ease, transform 0.2s ease;
            display: flex;
            align-items: center;
        }

        .rating-input {
            display: none;
        }

        .rating-input:checked ~ .rating-label,
        .rating-input:checked ~ .rating-label:hover,
        .rating-label:hover,
        .rating-label:hover ~ .rating-label {
            color: var(--gradient-blue-enhanced); /* Warna biru gradient modern */
        }

        .rating-label:hover {
            transform: scale(1.2);
        }

        .btn-action {
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
            padding: 0.5rem 1rem;
            margin-right: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-action.active {
            border-color: transparent;
        }

        .btn-action[data-action="suka"].active {
            background-color: #fee2e2; /* Merah muda lembut */
            color: #dc2626; /* Merah tua */
            animation: pulse 0.5s ease;
        }

        .btn-action[data-action="bookmark"].active {
            background-color: #dbeafe; /* Biru muda lembut */
            color: #1e40af; /* Biru tua */
            animation: pulse 0.5s ease;
        }

        .btn-action:hover {
            transform: scale(1.1);
            background-color: var(--light);
        }

        .btn-action i {
            margin-right: 0.5rem;
            transition: color 0.3s ease;
        }

        .reply-form {
            margin-left: 2rem;
            margin-top: 0.5rem;
            padding: 1rem;
            background-color: var(--white);
            border-radius: 8px;
            border: 1px solid var(--border);
            display: none;
        }

        .komentar-section {
            margin-top: 2rem;
        }

        .komentar-item {
            margin-bottom: 1.5rem;
            padding: 1rem;
            background-color: var(--white);
            border-radius: 8px;
            border: 1px solid var(--border-light);
        }

        .komentar-replies {
            margin-left: 2rem;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .reply-form {
                margin-left: 0;
                margin-top: 0.5rem;
            }
            .komentar-replies {
                margin-left: 1rem;
            }
        }

        /* Animasi Pulse */
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Handle Suka & Simpan dengan animasi
            document.querySelectorAll('.btn-action').forEach(button => {
                button.addEventListener('click', function() {
                    this.disabled = true;
                    const jenis = this.dataset.action;
                    const artikelId = this.dataset.id;
                    const url = `/artikel-siswa/${artikelId}/interaksi`;

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
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
                                document.getElementById('like-count').innerText = `<i class="fas fa-heart"></i> ${data.like_count} Suka`;
                            }
                            // Animasi tambahan
                            this.style.transform = 'scale(1.2)';
                            setTimeout(() => {
                                this.style.transform = 'scale(1)';
                            }, 300);
                        } else {
                            alert('Gagal menyimpan interaksi.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    })
                    .finally(() => {
                        this.disabled = false;
                    });
                });
            });

            // Handle Form Komentar & Rating
            const form = document.getElementById('feedbackForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const submitBtn = document.getElementById('submitBtn');
                    const originalBtnText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengirim...';

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
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
                                commentList.prepend(newCommentEl.firstChild);
                            }

                            // Perbarui URL sebelumnya setelah komentar berhasil
                            session(['previous_artikel_url' => route('artikel-siswa.show', $konten->id)]);

                            setTimeout(() => {
                                form.reset();
                                const checkedStar = document.querySelector('.rating-stars-modern input:checked');
                                if (checkedStar) checkedStar.checked = false;
                                submitBtn.disabled = false;
                                submitBtn.classList.replace('btn-success', 'btn-primary');
                                submitBtn.innerHTML = originalBtnText;
                            }, 2000);
                        } else {
                            alert(data.message || 'Gagal mengirim tanggapan.');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan. Pastikan Anda sudah login.');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    });
                });
            }

            // Handle Balas Komentar
            document.querySelectorAll('.btn-reply').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.nextElementSibling;
                    if (form && form.classList.contains('reply-form')) {
                        form.style.display = form.style.display === 'none' ? 'block' : 'none';
                    } else {
                        console.log('Form balasan tidak ditemukan untuk komentar ID:', this.dataset.id);
                    }
                });
            });

            document.querySelectorAll('.btn-cancel-reply').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.reply-form').style.display = 'none';
                });
            });
        });
    </script>
@endsection