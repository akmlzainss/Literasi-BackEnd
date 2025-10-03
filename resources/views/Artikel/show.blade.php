@extends('layouts.app')

@section('title', 'Detail Artikel - ' . $artikel->judul)
@section('page-title', 'Detail Artikel Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/artikel.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <div class="page-header floating-element">
        <h1 class="page-title">Detail Artikel</h1>
        <p class="page-subtitle">Lihat informasi lengkap artikel literasi akhlak</p>
        <div class="action-buttons">
            <a href="{{ route('admin.artikel.index') }}" class="btn btn-outline-custom">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
            </a>
            @if (Auth::guard('admin')->check())
                <a href="{{ route('admin.artikel.edit', $artikel->id) }}" class="btn btn-primary-custom">
                    <i class="fas fa-edit me-2"></i>Edit Artikel
                </a>
                <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" style="display:inline;"
                    id="deleteForm_{{ $artikel->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger-custom no-loading" onclick="confirmDelete({{ $artikel->id }})">
                        <i class="fas fa-trash me-2"></i>Hapus Artikel
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="main-card detail-card full-width">
        <div class="card-header-custom">
            <i class="fas fa-book-open me-2"></i>{{ $artikel->judul }}
        </div>
        <div class="card-body-custom">
            <div class="article-detail-content">
                <div class="article-detail-image">
                    <img src="{{ $artikel->gambar ? asset('storage/' . $artikel->gambar) : asset('images/no-image.jpg') }}"
                        alt="{{ $artikel->judul }}"
                        onerror="this.onerror=null; this.src='{{ asset('images/no-image.jpg') }}';"
                        class="floating-element">
                </div>
                <div class="article-meta">
                    <div class="meta-item">
                        <i class="fas fa-folder me-1"></i>
                        <span>Kategori: {{ $artikel->kategori->nama ?? 'Tanpa Kategori' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-user me-1"></i>
                        <span>Penulis:
                            {{ $artikel->penulis_type === 'siswa' && $artikel->siswa ? $artikel->siswa->nama : 'Admin' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt me-1"></i>
                        <span>Diterbitkan:
                            {{ $artikel->diterbitkan_pada ? $artikel->diterbitkan_pada->format('d M Y') : 'Belum diterbitkan' }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-check-circle me-1"></i>
                        <span>Status: {{ ucfirst($artikel->status) }}</span>
                    </div>
                    @if ($artikel->status === 'ditolak' && $artikel->alasan_penolakan)
                        <div class="meta-item text-danger">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <span>Alasan Penolakan: {{ $artikel->alasan_penolakan }}</span>
                        </div>
                    @endif
                </div>
                <div class="article-content mt-4">
                    {!! $artikel->isi !!}
                </div>
                <div class="article-stats mt-4">
                    <div class="stats-item">
                        <i class="fas fa-eye me-1"></i> {{ $artikel->jumlah_dilihat }} Dilihat
                    </div>
                    <div class="stats-item">
                        <i class="fas fa-heart me-1"></i> {{ $artikel->jumlah_suka }} Suka
                    </div>
                    <div class="stats-item">
                        <i class="fas fa-comment me-1"></i>
                        {{ $artikel->komentarArtikel->where('id_komentar_parent', null)->count() }} Komentar
                    </div>
                </div>
                <div class="article-rating mt-4">
                    <h5><i class="fas fa-star text-warning me-2"></i>Rating Artikel</h5>
                    <div class="rating-display">
                        @php
                            $rating = $avgRating ?? ($artikel->nilai_rata_rata ?? 0);
                            $totalReviews = $artikel->ratingArtikel->count();
                            $fullStars = floor($rating);
                            $hasHalfStar = $rating - $fullStars >= 0.5;
                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                        @endphp
                        <div class="stars">
                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star star-filled text-warning"></i>
                            @endfor
                            @if ($hasHalfStar)
                                <i class="fas fa-star-half-alt star-half text-warning"></i>
                            @endif
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="far fa-star star-empty text-warning"></i>
                            @endfor
                        </div>
                        <div class="rating-info">
                            <span class="rating-value">{{ number_format($rating, 1) }}</span>
                            <span class="rating-count">({{ $totalReviews }} ulasan)</span>
                        </div>
                    </div>
                    @if (Auth::guard('admin')->check() || Auth::guard('siswa')->check())
                        <form id="ratingForm" class="mt-3">
                            @csrf
                            <div class="form-group">
                                <label for="rating"><i class="fas fa-star text-warning me-1"></i>Beri Rating:</label>
                                <div class="d-flex align-items-center gap-3 mt-2">
                                    <select name="rating" id="rating" class="form-select w-auto">
                                        <option value="">Pilih Rating</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">⭐ {{ $i }}</option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="btn btn-primary-custom no-loading">
                                        <i class="fas fa-star me-1"></i>Simpan Rating
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
            <div class="article-comments mt-5">
                <h5><i class="fas fa-comments me-2" style="color: var(--primary-blue);"></i>Komentar ({{ $artikel->komentarArtikel->where('id_komentar_parent', null)->count() }})</h5>
                @php
                    $rootComments = $artikel->komentarArtikel->where('id_komentar_parent', null);
                @endphp
                @if ($rootComments->isEmpty())
                    <div class="text-center py-4">
                        <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                        <p class="text-muted fs-5">Belum ada komentar untuk artikel ini.</p>
                        <p class="text-muted">Jadilah yang pertama memberikan komentar!</p>
                    </div>
                @else
                    @foreach ($rootComments as $comment)
                        <x-comment-card :comment="$comment" :depth="0" :artikel="$artikel" />
                    @endforeach
                @endif
                @if (Auth::guard('admin')->check() || Auth::guard('siswa')->check())
                    <div class="comment-form mt-4">
                        <h5><i class="fas fa-plus-circle me-2" style="color: var(--primary-blue);"></i>Tambahkan Komentar</h5>
                        <form
                            action="{{ Auth::guard('siswa')->check() ? route('artikel-siswa.komentar.store', $artikel->id) : route('admin.komentar.store', $artikel->id) }}"
                            method="POST" id="commentForm">
                            @csrf
                            <input type="hidden" name="id_komentar_parent" value="">
                            <input type="hidden" name="depth" value="0">
                            <div class="form-group">
                                <textarea name="komentar" id="commentInput" class="form-control @error('komentar') is-invalid @enderror" rows="4"
                                    placeholder="Tulis komentar Anda..." required>{{ old('komentar') }}</textarea>
                                @error('komentar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary-custom mt-3">
                                <i class="fas fa-comment me-1"></i>Kirim Komentar
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Artikel -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Artikel
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <p class="fs-5">Apakah Anda yakin ingin menghapus artikel ini?</p>
                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger-custom no-loading" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Komentar -->
    <div class="modal fade" id="deleteCommentConfirmModal" tabindex="-1"
        aria-labelledby="deleteCommentConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCommentConfirmModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Komentar
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-comment-slash fa-3x text-danger mb-3"></i>
                    <p class="fs-5">Apakah Anda yakin ingin menghapus komentar ini?</p>
                    <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger-custom no-loading" id="confirmDeleteCommentBtn">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk rating
            $('#rating').select2({
                placeholder: 'Pilih Rating',
                allowClear: true,
                minimumResultsForSearch: Infinity
            });

            // AJAX untuk Rating
            $('#ratingForm').on('submit', function(e) {
                e.preventDefault();
                const rating = $('#rating').val();
                if (!rating) {
                    showAlert('error', 'Harap pilih rating terlebih dahulu.');
                    return;
                }

                $.ajax({
                    url: '{{ Auth::guard('siswa')->check() ? route('artikel-siswa.rate', $artikel->id) : route('admin.artikel.rate', $artikel->id) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        rating: rating
                    },
                    beforeSend: function() {
                        $('#ratingForm button').html(
                            '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);
                    },
                    success: function(response) {
                        showAlert('success', response.message);
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function(xhr) {
                        showAlert('error', xhr.responseJSON?.message || 'Gagal menyimpan rating.');
                    },
                    complete: function() {
                        $('#ratingForm button').html(
                            '<i class="fas fa-star me-1"></i>Simpan Rating').prop('disabled', false);
                    }
                });
            });

            // Konfirmasi Hapus Artikel
            window.confirmDelete = function(id) {
                $('#deleteConfirmModal').modal('show');
                $('#confirmDeleteBtn').off('click').on('click', function() {
                    const form = $('#deleteForm_' + id);
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        beforeSend: function() {
                            $('#confirmDeleteBtn').html(
                                '<i class="fas fa-spinner fa-spin"></i> Menghapus...');
                        },
                        success: function(response) {
                            $('#deleteConfirmModal').modal('hide');
                            showAlert('success', response.message);
                            setTimeout(() => window.location.href = response.redirect, 1500);
                        },
                        error: function(xhr) {
                            $('#deleteConfirmModal').modal('hide');
                            showAlert('error', xhr.responseJSON?.message || 'Gagal menghapus artikel.');
                        },
                        complete: function() {
                            $('#confirmDeleteBtn').html('<i class="fas fa-trash me-1"></i>Hapus');
                        }
                    });
                });
            };

            // Konfirmasi Hapus Komentar
            window.confirmDeleteComment = function(id) {
                $('#deleteCommentConfirmModal').modal('show');
                $('#confirmDeleteCommentBtn').off('click').on('click', function() {
                    const form = $('#deleteCommentForm_' + id);
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: form.serialize(),
                        beforeSend: function() {
                            $('#confirmDeleteCommentBtn').html(
                                '<i class="fas fa-spinner fa-spin"></i> Menghapus...');
                        },
                        success: function(response) {
                            $('#deleteCommentConfirmModal').modal('hide');
                            showAlert('success', response.message || 'Komentar berhasil dihapus!');
                            $('#comment_' + id).fadeOut(() => $('#comment_' + id).remove());
                        },
                        error: function(xhr) {
                            $('#deleteCommentConfirmModal').modal('hide');
                            showAlert('error', xhr.responseJSON?.message || 'Gagal menghapus komentar.');
                        },
                        complete: function() {
                            $('#confirmDeleteCommentBtn').html('<i class="fas fa-trash me-1"></i>Hapus');
                        }
                    });
                });
            };

            // Edit Komentar
            window.editComment = function(id) {
                $('#commentBody_' + id).addClass('d-none');
                $('#editCommentForm_' + id).removeClass('d-none');
            };

            window.cancelEditComment = function(id) {
                $('#commentBody_' + id).removeClass('d-none');
                $('#editCommentForm_' + id).addClass('d-none');
            };

            // Balas Komentar
            window.showReplyForm = function(id) {
                $('#replyForm_' + id).removeClass('d-none');
            };

            window.hideReplyForm = function(id) {
                $('#replyForm_' + id).addClass('d-none');
            };

            // Fungsi Alert dengan enhanced design
            function showAlert(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show custom-alert" role="alert">
                        <i class="fas ${iconClass} me-2"></i>${message}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('.custom-alert').remove();
                $('body').append(alertHtml);
                setTimeout(() => $('.custom-alert').fadeOut(() => $('.custom-alert').remove()), 5000);
            }

            // Tangani alert dari sesi
            @if (session('success'))
                showAlert('success', '{{ session('success') }}');
            @endif
            @if (session('error'))
                showAlert('error', '{{ session('error') }}');
            @endif

            // Enhanced scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.meta-item, .stats-item').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'all 0.6s ease';
                observer.observe(el);
            });

            // Smooth scroll for anchors
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();
                const target = $(this.getAttribute('href'));
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                }
            });

            // Enhanced hover effects for interactive elements
            $('.stats-item, .meta-item').hover(
                function() {
                    $(this).css('transform', 'translateY(-3px) scale(1.02)');
                },
                function() {
                    $(this).css('transform', 'translateY(0) scale(1)');
                }
            );

            // Parallax effect for background
            $(window).scroll(function() {
                const scrolled = $(this).scrollTop();
                const rate = scrolled * -0.5;
                $('body::before').css('transform', 'translateY(' + rate + 'px)');
            });

            // Add ripple effect to buttons (exclude buttons with no-loading class)
            $('.btn:not(.no-loading)').on('click', function(e) {
                const $btn = $(this);
                const ripple = $('<span class="ripple"></span>');
                $btn.append(ripple);

                const x = e.offsetX;
                const y = e.offsetY;

                ripple.css({
                    left: x + 'px',
                    top: y + 'px'
                });

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
@endsection