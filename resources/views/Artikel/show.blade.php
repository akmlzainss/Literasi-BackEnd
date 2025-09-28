@extends('layouts.app')

@section('title', 'Detail Artikel - ' . $artikel->judul)
@section('page-title', 'Detail Artikel Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/artikel.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="page-header">
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
                    <button type="button" class="btn btn-danger-custom" onclick="confirmDelete({{ $artikel->id }})">
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
                        style="max-width: 100%; border-radius: 8px;">
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
                    <h5>Rating Artikel</h5>
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
                                <label for="rating">Beri Rating:</label>
                                <select name="rating" id="rating" class="form-select w-auto d-inline-block">
                                    <option value="">Pilih Rating</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">⭐ {{ $i }}</option>
                                    @endfor
                                </select>
                                <button type="submit" class="btn btn-primary-custom ms-2">
                                    <i class="fas fa-star me-1"></i>Simpan Rating
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
            <div class="article-comments mt-5">
                <h5>Komentar ({{ $artikel->komentarArtikel->where('id_komentar_parent', null)->count() }})</h5>
                @php
                    $rootComments = $artikel->komentarArtikel->where('id_komentar_parent', null);
                @endphp
                @if ($rootComments->isEmpty())
                    <p class="text-muted">Belum ada komentar untuk artikel ini.</p>
                @else
                    @foreach ($rootComments as $comment)
                        <x-comment-card :comment="$comment" :depth="0" :artikel="$artikel" />
                    @endforeach
                @endif
                @if (Auth::guard('admin')->check() || Auth::guard('siswa')->check())
                    <div class="comment-form mt-4">
                        <h5>Tambahkan Komentar</h5>
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
                            <button type="submit" class="btn btn-primary-custom mt-2">
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
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Hapus Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
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
                    <h5 class="modal-title" id="deleteCommentConfirmModalLabel">Konfirmasi Hapus Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus komentar ini? Tindakan ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteCommentBtn">Hapus</button>
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
                    url: '{{ route('admin.artikel.rate', $artikel->id) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        rating: rating
                    },
                    beforeSend: function() {
                        $('#ratingForm button').html(
                            '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop(
                            'disabled', true);
                    },
                    success: function(response) {
                        showAlert('success', response.message);
                        setTimeout(() => location.reload(), 1500);
                    },
                    error: function(xhr) {
                        showAlert('error', xhr.responseJSON?.message ||
                            'Gagal menyimpan rating.');
                    },
                    complete: function() {
                        $('#ratingForm button').html(
                            '<i class="fas fa-star me-1"></i>Simpan Rating').prop(
                            'disabled', false);
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
                            setTimeout(() => window.location.href = response.redirect,
                            1500);
                        },
                        error: function(xhr) {
                            $('#deleteConfirmModal').modal('hide');
                            showAlert('error', xhr.responseJSON?.message ||
                                'Gagal menghapus artikel.');
                        },
                        complete: function() {
                            $('#confirmDeleteBtn').html('Hapus');
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
                            showAlert('success', response.message ||
                                'Komentar berhasil dihapus!');
                            $('#comment_' + id).fadeOut(() => $('#comment_' + id).remove());
                        },
                        error: function(xhr) {
                            $('#deleteCommentConfirmModal').modal('hide');
                            showAlert('error', xhr.responseJSON?.message ||
                                'Gagal menghapus komentar.');
                        },
                        complete: function() {
                            $('#confirmDeleteCommentBtn').html('Hapus');
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

            // Fungsi Alert
            function showAlert(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show custom-alert" role="alert">
                        <i class="fas ${iconClass} me-2"></i>${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
        });
    </script>
@endsection
