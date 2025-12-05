@extends('layouts.app')

@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel Literasi Akhlak')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/artikel.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="main-card">
                    <div class="card-header-custom">
                        <i class="fas fa-edit me-2"></i> Form Edit Artikel
                    </div>

                    <div class="card-body-custom">
                        {{-- Error & Success Alert --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success custom-alert">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger custom-alert">{{ session('error') }}</div>
                        @endif

                        {{-- Form --}}
                        <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST"
                            enctype="multipart/form-data" id="edit-artikel-form">
                            @csrf
                            @method('PUT')

                            {{-- Judul --}}
                            <div class="mb-3">
                                <label for="judul" class="form-label">
                                    <i class="fas fa-heading me-2"></i>Judul Artikel <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="judul" id="judul" class="form-control"
                                    placeholder="Masukkan judul artikel..." value="{{ old('judul', $artikel->judul) }}" required>
                                @error('judul')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Isi Artikel --}}
                            <div class="mb-3">
                                <label for="edit_isi" class="form-label">
                                    <i class="fas fa-align-left me-2"></i>Isi Artikel <span class="text-danger">*</span>
                                </label>
                                <textarea name="isi" id="edit_isi" class="form-control" rows="10" required>{{ old('isi', $artikel->isi) }}</textarea>
                                <div id="charCount" class="text-muted mt-1" style="font-size: 0.9em;">0/3000</div>
                                @error('isi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Gambar --}}
                            <div class="mb-3">
                                <label for="gambar" class="form-label">
                                    <i class="fas fa-image me-2"></i>Ganti Gambar (opsional)
                                </label>
                                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                                <div id="imagePreview" class="mt-2">
                                    @if ($artikel->gambar)
                                        <div class="text-center">
                                            <img src="{{ asset('storage/' . $artikel->gambar) }}"
                                                style="max-width: 100%; max-height: 250px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"
                                                alt="Current Image">
                                            <p class="mt-2 text-muted small">
                                                <i class="fas fa-info-circle me-1"></i>Gambar saat ini
                                            </p>
                                        </div>
                                    @endif
                                </div>
                                @error('gambar')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kategori --}}
                            <div class="mb-3">
                                <label for="id_kategori" class="form-label">
                                    <i class="fas fa-tags me-2"></i>Kategori <span class="text-danger">*</span>
                                </label>
                                <select name="id_kategori" id="id_kategori" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}"
                                            {{ old('id_kategori', $artikel->id_kategori) == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kategori')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Penulis --}}
                            <div class="mb-3">
                                <label class="form-label d-block">
                                    <i class="fas fa-user-edit me-2"></i>Penulis Artikel <span class="text-danger">*</span>
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="penulis_type" id="penulis_admin"
                                        value="admin"
                                        {{ old('penulis_type', $artikel->penulis_type) == 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="penulis_admin">
                                        <i class="fas fa-user-shield me-2"></i>Admin
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="penulis_type" id="penulis_siswa"
                                        value="siswa"
                                        {{ old('penulis_type', $artikel->penulis_type) == 'siswa' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="penulis_siswa">
                                        <i class="fas fa-user-graduate me-2"></i>Siswa
                                    </label>
                                </div>
                                @error('penulis_type')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Siswa Fields --}}
                            <div id="siswa-fields"
                                class="{{ old('penulis_type', $artikel->penulis_type) == 'siswa' ? '' : 'd-none' }}">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="id_siswa" class="form-label">
                                                <i class="fas fa-search me-2"></i>Cari Nama Siswa <span class="text-danger">*</span>
                                            </label>
                                            <select name="id_siswa" id="id_siswa" class="form-control select2" style="width: 100%;">
                                                <option value="">Ketik nama atau NIS siswa...</option>
                                                @if (old('id_siswa', $artikel->id_siswa))
                                                    <option value="{{ old('id_siswa', $artikel->id_siswa) }}" selected>
                                                        {{ $artikel->siswa ? $artikel->siswa->nama . ' (' . $artikel->siswa->nis . ')' : 'Siswa Tidak Ditemukan' }}
                                                    </option>
                                                @endif
                                            </select>
                                            @error('id_siswa')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="kelas_siswa" class="form-label">
                                                <i class="fas fa-school me-2"></i>Kelas
                                            </label>
                                            <input type="text" id="kelas_siswa" class="form-control"
                                                value="{{ old('kelas_siswa', $artikel->siswa->kelas ?? '') }}" readonly
                                                placeholder="Auto terisi">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Jenis --}}
                            <div class="mb-3">
                                <label for="jenis" class="form-label">
                                    <i class="fas fa-list-alt me-2"></i>Jenis <span class="text-danger">*</span>
                                </label>
                                <select name="jenis" id="jenis" class="form-select" required>
                                    <option value="bebas" {{ old('jenis', $artikel->jenis) == 'bebas' ? 'selected' : '' }}>Bebas</option>
                                    <option value="resensi_buku" {{ old('jenis', $artikel->jenis) == 'resensi_buku' ? 'selected' : '' }}>Resensi Buku</option>
                                    <option value="resensi_film" {{ old('jenis', $artikel->jenis) == 'resensi_film' ? 'selected' : '' }}>Resensi Film</option>
                                    <option value="video" {{ old('jenis', $artikel->jenis) == 'video' ? 'selected' : '' }}>Video</option>
                                </select>
                                @error('jenis')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="mb-3">
                                <label for="status" class="form-label">
                                    <i class="fas fa-info-circle me-2"></i>Status <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="menunggu" {{ old('status', $artikel->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="draf" {{ old('status', $artikel->status) == 'draf' ? 'selected' : '' }}>Draf</option>
                                    <option value="disetujui" {{ old('status', $artikel->status) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="ditolak" {{ old('status', $artikel->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                @error('status')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alasan Penolakan --}}
                            <div id="alasan-penolakan-field"
                                class="mb-3 {{ old('status', $artikel->status) == 'ditolak' ? '' : 'd-none' }}">
                                <label for="alasan_penolakan" class="form-label">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Alasan Penolakan
                                </label>
                                <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control" rows="3"
                                    placeholder="Tuliskan alasan penolakan artikel...">{{ old('alasan_penolakan', $artikel->alasan_penolakan) }}</textarea>
                                @error('alasan_penolakan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Rating --}}
                            <div class="mb-3">
                                <label for="rating" class="form-label">
                                    <i class="fas fa-star me-2"></i>Rating Awal (opsional)
                                </label>
                                <select name="rating" id="rating" class="form-select">
                                    <option value="">Belum ada</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('rating', $artikel->nilai_rata_rata) == $i ? 'selected' : '' }}>⭐ {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="mt-4">
                                <button type="submit" class="btn btn-success" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/4xazwn7uf3t198xvx4jq99bmdaj364wz6x88joubmdqdtlrn/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function() {
            // ===================================
            // Initialize TinyMCE
            // ===================================
            tinymce.init({
                selector: '#edit_isi',
                height: 500,
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
                toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                setup: function(editor) {
                    const updateCharCount = () => {
                        const charCount = editor.getContent({
                            format: 'text'
                        }).length;
                        $('#charCount').text(`${charCount}/3000`);
                        $('#charCount').css('color', charCount > 3000 ? 'red' : 'inherit');
                    };
                    editor.on('keydown', function(e) {
                        const charCount = editor.getContent({
                            format: 'text'
                        }).length;
                        if (charCount >= 3000 && e.keyCode !== 8 && e.keyCode !== 46) e
                            .preventDefault();
                    });
                    editor.on('input change', updateCharCount);
                    editor.on('init', updateCharCount);
                }
            });


            // ===================================
            // Initialize Select2 for Category
            // ===================================
            $('#id_kategori').select2({
                placeholder: 'Pilih Kategori',
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: Infinity
            });

            // ===================================
            // Initialize Select2 for Student
            // ===================================
            const $idSiswa = $('#id_siswa').select2({
                placeholder: 'Ketik nama atau NIS siswa...',
                allowClear: true,
                width: '100%',
                minimumInputLength: 2,
                ajax: {
                    url: '{{ route('admin.search.siswa') }}',
                    dataType: 'json',
                    delay: 300,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.text,
                                    kelas: item.kelas
                                };
                            }),
                            pagination: {
                                more: data.length === 10
                            }
                        };
                    },
                    cache: true
                },
                language: {
                    inputTooShort: function() {
                        return 'Ketik minimal 2 karakter untuk mencari...';
                    },
                    searching: function() {
                        return 'Mencari siswa...';
                    },
                    noResults: function() {
                        return 'Siswa tidak ditemukan';
                    }
                }
            });

            // ===================================
            // Pre-select Siswa for Edit
            // ===================================
            const penulisType = '{{ old('penulis_type', $artikel->penulis_type) }}';
            const siswaId = '{{ old('id_siswa', $artikel->id_siswa) }}';
            if (penulisType === 'siswa' && siswaId) {
                $.ajax({
                    url: '{{ route('admin.search.siswa') }}',
                    data: {
                        term: siswaId
                    },
                    dataType: 'json',
                    success: function(data) {
                        let siswa = null;

                        // Jika data adalah array
                        if (Array.isArray(data)) {
                            siswa = data.find(item => item.id == siswaId);
                        }
                        // Jika data adalah objek tunggal
                        else if (data && typeof data === 'object') {
                            siswa = data.id == siswaId ? data : null;
                        }

                        if (siswa) {
                            const option = new Option(siswa.text, siswa.id, true, true);
                            option.kelas = siswa.kelas;
                            $idSiswa.append(option).trigger('change');
                            $('#kelas_siswa').val(siswa.kelas || '');
                        }
                    }
                });
            }

            // ===================================
            // Penulis Logic
            // ===================================
            $('input[name="penulis_type"]').on('change', function() {
                const isSiswa = this.value === 'siswa';

                if (isSiswa) {
                    $('#siswa-fields').removeClass('d-none').hide().slideDown(400);
                    $('#id_siswa').prop('required', true);
                } else {
                    $('#siswa-fields').slideUp(400, function() {
                        $(this).addClass('d-none');
                    });
                    $('#id_siswa').prop('required', false).val(null).trigger('change');
                    $('#kelas_siswa').val('');
                }
            });

            // ===================================
            // Update Kelas Otomatis
            // ===================================
            $idSiswa.on('select2:select', function(e) {
                const data = e.params.data;
                $('#kelas_siswa').val(data.kelas || '-').addClass('text-success');

                // Animasi feedback
                $('#kelas_siswa').css('background-color', '#d1fae5');
                setTimeout(function() {
                    $('#kelas_siswa').css('background-color', '#f1f5f9');
                }, 1000);
            });

            $idSiswa.on('select2:clear', function() {
                $('#kelas_siswa').val('').removeClass('text-success');
            });

            // ===================================
            // Status Logic
            // ===================================
            $('#status').on('change', function() {
                const isDitolak = $(this).val() === 'ditolak';

                if (isDitolak) {
                    $('#alasan-penolakan-field').removeClass('d-none').hide().slideDown(400);
                    $('#alasan_penolakan').prop('required', true);
                } else {
                    $('#alasan-penolakan-field').slideUp(400, function() {
                        $(this).addClass('d-none');
                    });
                    $('#alasan_penolakan').prop('required', false);
                }
            });

            // ===================================
            // Preview Gambar
            // ===================================
            let initialImagePreview = '';
            @if ($artikel->gambar)
                initialImagePreview = '{{ asset('storage/' . $artikel->gambar) }}';
            @endif

            $('#gambar').on('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    // Validasi tipe file
                    if (!file.type.match('image.*')) {
                        alert('File harus berupa gambar!');
                        $(this).val('');
                        return;
                    }

                    // Validasi ukuran (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran gambar maksimal 2MB!');
                        $(this).val('');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').html(`
                            <div class="text-center" style="animation: fadeIn 0.5s;">
                                <img src="${e.target.result}" 
                                     style="max-width: 100%; max-height: 250px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"
                                     alt="Preview">
                                <p class="mt-2 text-muted small">
                                    <i class="fas fa-info-circle me-1"></i>
                                    ${file.name} (${(file.size / 1024).toFixed(2)} KB)
                                </p>
                            </div>
                        `).hide().fadeIn(500);
                    };
                    reader.readAsDataURL(file);
                } else {
                    if (initialImagePreview) {
                        $('#imagePreview').html(`
                            <div class="text-center">
                                <img src="${initialImagePreview}" 
                                     style="max-width: 100%; max-height: 250px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"
                                     alt="Current Image">
                                <p class="mt-2 text-muted small">
                                    <i class="fas fa-info-circle me-1"></i>Gambar saat ini
                                </p>
                            </div>
                        `);
                    } else {
                        $('#imagePreview').fadeOut(300, function() {
                            $(this).html('');
                        });
                    }
                }
            });

            // ===================================
            // Submit AJAX
            // ===================================
            $('#edit-artikel-form').on('submit', function(e) {
                e.preventDefault();
                tinymce.triggerSave();
                const formData = new FormData(this);
                const submitBtn = $('#submitBtn');
                const originalText = submitBtn.html();

                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...').prop('disabled',
                    true);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        showAlert('success', response.message);
                        setTimeout(() => window.location.href = response.redirect, 1500);
                    },
                    error: function(xhr) {
                        showAlert('error', xhr.responseJSON?.message ||
                            'Gagal memperbarui artikel.');
                        if (xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(key, error) {
                                $(`[name="${key}"]`).after(
                                    `<div class="alert alert-danger mt-2">${error[0]}</div>`
                                );
                            });
                        }
                    },
                    complete: function() {
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                });
            });

            // ===================================
            // Alert Function
            // ===================================
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
                $('.card-body-custom').prepend(alertHtml);
                setTimeout(() => $('.custom-alert').fadeOut(() => $('.custom-alert').remove()), 5000);
            }

            // ===================================
            // Form Validation Enhancement
            // ===================================
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            });

            // ===================================
            // Smooth Scroll untuk Error
            // ===================================
            if ($('.alert-danger').length) {
                $('html, body').animate({
                    scrollTop: $('.alert-danger').first().offset().top - 100
                }, 800);
            }
        });

        // ===================================
        // CSS Animation
        // ===================================
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .is-invalid {
                border-color: #ef4444 !important;
                animation: shake 0.5s;
            }
            
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
            
            .invalid-feedback {
                display: block !important;
                color: #ef4444 !important;
                font-size: 0.875rem !important;
                margin-top: 0.25rem !important;
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection
