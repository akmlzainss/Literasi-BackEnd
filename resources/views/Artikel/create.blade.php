@extends('layouts.app')

@section('title', 'Tambah Artikel')
@section('page-title', 'Tambah Artikel Baru')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/artikel.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="main-card">
                    <!-- Card Header -->
                    <div class="card-header-custom">
                        <i class="fas fa-plus me-2"></i> Form Tambah Artikel
                    </div>
                    <!-- Card Body -->
                    <div class="card-body-custom">
                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- Success/Error Session Messages -->
                        @if (session('success'))
                            <div class="alert alert-success custom-alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger custom-alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <!-- Main Form -->
                        <form action="{{ route('admin.artikel.store') }}"
                              method="POST"
                              enctype="multipart/form-data"
                              id="create-artikel-form"
                              novalidate>
                            @csrf
                            <!-- Judul Artikel -->
                            <div class="mb-3">
                                <label for="judul" class="form-label">
                                    <i class="fas fa-heading me-2"></i>Judul Artikel <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       name="judul"
                                       id="judul"
                                       class="form-control"
                                       placeholder="Masukkan judul artikel..."
                                       value="{{ old('judul') }}"
                                       required>
                                @error('judul')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Isi Artikel -->
                            <div class="mb-3">
                                <label for="isi" class="form-label">
    <i class="fas fa-align-left me-2"></i>Isi Artikel <span class="text-danger">*</span>
</label>
<textarea name="isi"
          id="isi"
          class="form-control"
          rows="10"
          required>{{ old('isi') }}</textarea>
                                <div id="charCount" class="text-muted mt-1" style="font-size: 0.9em;">
                                    0/3000
                                </div>
                                @error('isi')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Gambar -->
                            <div class="mb-3">
                                <label for="gambar" class="form-label">
                                    <i class="fas fa-image me-2"></i>Gambar (opsional)
                                </label>
                                <input type="file"
                                       name="gambar"
                                       id="gambar"
                                       class="form-control"
                                       accept="image/*">
                                <div id="imagePreview" class="mt-2"></div>
                                @error('gambar')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Kategori -->
                            <div class="mb-3">
                                <label for="id_kategori" class="form-label">
                                    <i class="fas fa-tags me-2"></i>Kategori <span class="text-danger">*</span>
                                </label>
                                <select name="id_kategori" id="id_kategori" class="form-select select2" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}"
                                                {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kategori')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Penulis Artikel -->
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-user-edit me-2"></i>Penulis Artikel <span class="text-danger">*</span>
                                </label>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="penulis_type"
                                           id="penulis_admin"
                                           value="admin"
                                           {{ old('penulis_type', 'admin') == 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="penulis_admin">
                                        <i class="fas fa-user-shield me-2"></i>Admin
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="penulis_type"
                                           id="penulis_siswa"
                                           value="siswa"
                                           {{ old('penulis_type') == 'siswa' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="penulis_siswa">
                                        <i class="fas fa-user-graduate me-2"></i>Siswa
                                    </label>
                                </div>
                                @error('penulis_type')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Siswa Fields (Conditional) -->
                            <div id="siswa-fields" class="{{ old('penulis_type') == 'siswa' ? '' : 'd-none' }}">
                                <div class="row">
                                    <!-- Cari Nama Siswa -->
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="id_siswa" class="form-label">
                                                <i class="fas fa-search me-2"></i>Cari Nama Siswa <span class="text-danger">*</span>
                                            </label>
                                            <select name="id_siswa"
                                                    id="id_siswa"
                                                    class="form-control select2"
                                                    style="width: 100%;">
                                                <option value="">Ketik nama atau NIS siswa...</option>
                                            </select>
                                            @error('id_siswa')
                                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Kelas -->
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="kelas_siswa" class="form-label">
                                                <i class="fas fa-school me-2"></i>Kelas
                                            </label>
                                            <input type="text"
                                                   id="kelas_siswa"
                                                   class="form-control"
                                                   readonly
                                                   placeholder="Auto terisi">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Jenis -->
                            <div class="mb-3">
                                <label for="jenis" class="form-label">
                                    <i class="fas fa-list-alt me-2"></i>Jenis <span class="text-danger">*</span>
                                </label>
                                <select name="jenis" id="jenis" class="form-select" required>
                                    <option value="bebas"
                                            {{ old('jenis') == 'bebas' ? 'selected' : '' }}>
                                        Bebas
                                    </option>
                                    <option value="resensi_buku"
                                            {{ old('jenis') == 'resensi_buku' ? 'selected' : '' }}>
                                        Resensi Buku
                                    </option>
                                    <option value="resensi_film"
                                            {{ old('jenis') == 'resensi_film' ? 'selected' : '' }}>
                                        Resensi Film
                                    </option>
                                    <option value="video"
                                            {{ old('jenis') == 'video' ? 'selected' : '' }}>
                                        Video
                                    </option>
                                </select>
                                @error('jenis')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">
                                    <i class="fas fa-info-circle me-2"></i>Status <span class="text-danger">*</span>
                                </label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="menunggu"
                                            {{ old('status', 'menunggu') == 'menunggu' ? 'selected' : '' }}>
                                        Menunggu
                                    </option>
                                    <option value="draf"
                                            {{ old('status') == 'draf' ? 'selected' : '' }}>
                                        Draf
                                    </option>
                                    <option value="disetujui"
                                            {{ old('status') == 'disetujui' ? 'selected' : '' }}>
                                        Disetujui
                                    </option>
                                    <option value="ditolak"
                                            {{ old('status') == 'ditolak' ? 'selected' : '' }}>
                                        Ditolak
                                    </option>
                                </select>
                                @error('status')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Alasan Penolakan (Conditional) -->
                            <div id="alasan-penolakan-field"
                                 class="mb-3 {{ old('status') == 'ditolak' ? '' : 'd-none' }}">
                                <label for="alasan_penolakan" class="form-label">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Alasan Penolakan
                                </label>
                                <textarea name="alasan_penolakan"
                                          id="alasan_penolakan"
                                          class="form-control"
                                          rows="3"
                                          placeholder="Tuliskan alasan penolakan artikel...">{{ old('alasan_penolakan') }}</textarea>
                                @error('alasan_penolakan')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Rating Awal -->
                            <div class="mb-3">
                                <label for="rating" class="form-label">
                                    <i class="fas fa-star me-2"></i>Rating Awal (opsional)
                                </label>
                                <select name="rating" id="rating" class="form-select">
                                    <option value="">Belum ada</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}"
                                                {{ old('rating') == $i ? 'selected' : '' }}>
                                            ⭐ {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <!-- Submit Buttons -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-success" id="submitBtn">
                                    <i class="fas fa-save me-2"></i>Simpan Artikel
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.tiny.cloud/1/4xazwn7uf3t198xvx4jq99bmdaj364wz6x88joubmdqdtlrn/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        $(document).ready(function () {
            // ===================================
            // Initialize TinyMCE
            // ===================================
            tinymce.init({
                selector: '#isi',
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
            // Initialize Select2 for Student Search
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
                    data: function (params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.text,
                                    kelas: item.kelas
                                };
                            }),
                            pagination: { more: data.length === 10 }
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
            // Author Type Change Handler
            // ===================================
            $('input[name="penulis_type"]').on('change', function () {
                const isSiswa = $(this).val() === 'siswa';
                
                if (isSiswa) {
                    $('#siswa-fields').removeClass('d-none').hide().slideDown(400);
                    $('#id_siswa').prop('required', true);
                } else {
                    $('#siswa-fields').slideUp(400, function() {
                        $(this).addClass('d-none');
                    });
                    // Jangan set required false, tapi clear value saja
                    $('#id_siswa').val(null).trigger('change');
                    $('#kelas_siswa').val('');
                }
            });

            // ===================================
            // Update Student Class when Student is Selected
            // ===================================
            $idSiswa.on('select2:select', function (e) {
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
            // Status Change Handler
            // ===================================
            $('#status').on('change', function () {
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
            // Image Preview Handler
            // ===================================
            $('#gambar').on('change', function (e) {
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
                    reader.onload = function (e) {
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
                    $('#imagePreview').fadeOut(300, function() {
                        $(this).html('');
                    });
                }
            });

            // ===================================
            // AJAX Form Submission
            // ===================================
            $('#create-artikel-form').on('submit', function (e) {
                e.preventDefault();
                
                // Validate manually
                const penulisType = $('input[name="penulis_type"]:checked').val();
                const siswaId = $('#id_siswa').val();
                
                // Jika penulis siswa, id_siswa wajib diisi
                if (penulisType === 'siswa' && !siswaId) {
                    showAlert('error', 'Silakan pilih siswa terlebih dahulu!');
                    $('#id_siswa').focus();
                    return false;
                }
                
                // Jika penulis admin, hapus id_siswa dari form
                if (penulisType === 'admin') {
                    $('#id_siswa').val('').prop('required', false);
                }
                
                tinymce.triggerSave();
                const formData = new FormData(this);
                const submitBtn = $('#submitBtn');
                const originalText = submitBtn.html();
                
                submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...')
                         .prop('disabled', true);
                
                // Remove old error messages
                $('.alert-danger').not('.custom-alert').remove();
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        showAlert('success', response.message);
                        setTimeout(() => {
                            window.location.href = response.redirect;
                        }, 1500);
                    },
                    error: function (xhr) {
                        const errorMessage = xhr.responseJSON?.message || 'Gagal menyimpan artikel.';
                        showAlert('error', errorMessage);
                        
                        if (xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function (key, errors) {
                                const errorHtml = `<div class="alert alert-danger mt-2">${errors[0]}</div>`;
                                const $field = $(`[name="${key}"]`);
                                
                                // Remove old error for this field
                                $field.next('.alert-danger').remove();
                                
                                // Add new error
                                if ($field.length) {
                                    $field.after(errorHtml);
                                    $field.addClass('is-invalid');
                                }
                            });
                            
                            // Scroll to first error
                            const firstError = $('.is-invalid').first();
                            if (firstError.length) {
                                $('html, body').animate({
                                    scrollTop: firstError.offset().top - 100
                                }, 500);
                            }
                        }
                    },
                    complete: function () {
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
                setTimeout(() => {
                    $('.custom-alert').fadeOut(() => {
                        $('.custom-alert').remove();
                    });
                }, 5000);
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