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

                        <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST"
                            enctype="multipart/form-data" id="edit-artikel-form">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Artikel <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="judul" id="judul" class="form-control"
                                    value="{{ old('judul', $artikel->judul) }}" required>
                                @error('judul')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="isi" class="form-label">Isi Artikel <span
                                        class="text-danger">*</span></label>
                                <textarea name="isi" id="edit_isi" class="form-control" rows="10" required>{{ old('isi', $artikel->isi) }}</textarea>
                                <div id="charCount" class="text-muted mt-1" style="font-size: 0.9em;">0/3000</div>
                                @error('isi')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Ganti Gambar (opsional)</label>
                                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                                <div id="imagePreview" class="mt-2" style="max-width: 200px;">
                                    @if ($artikel->gambar)
                                        <img src="{{ asset('storage/' . $artikel->gambar) }}"
                                            style="max-width: 200px; border-radius: 5px;">
                                    @endif
                                </div>
                                @error('gambar')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="id_kategori" class="form-label">Kategori <span
                                        class="text-danger">*</span></label>
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
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Penulis Artikel <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="penulis_type" id="penulis_admin"
                                        value="admin"
                                        {{ old('penulis_type', $artikel->penulis_type) == 'admin' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="penulis_admin">Admin</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="penulis_type" id="penulis_siswa"
                                        value="siswa"
                                        {{ old('penulis_type', $artikel->penulis_type) == 'siswa' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="penulis_siswa">Siswa</label>
                                </div>
                                @error('penulis_type')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="siswa-fields"
                                class="row {{ old('penulis_type', $artikel->penulis_type) == 'siswa' ? '' : 'd-none' }}">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="id_siswa" class="form-label">Cari Nama Siswa <span
                                                class="text-danger">*</span></label>
                                        <select name="id_siswa" id="id_siswa" class="form-control select2"
                                            style="width: 100%;">
                                            @if (old('id_siswa', $artikel->id_siswa))
                                                <option value="{{ old('id_siswa', $artikel->id_siswa) }}" selected>
                                                    {{ $artikel->siswa ? $artikel->siswa->nama . ' (' . $artikel->siswa->nis . ')' : 'Siswa Tidak Ditemukan' }}
                                                </option>
                                            @endif
                                        </select>
                                        @error('id_siswa')
                                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="kelas_siswa" class="form-label">Kelas</label>
                                        <input type="text" id="kelas_siswa" class="form-control"
                                            value="{{ old('kelas_siswa', $artikel->siswa->kelas ?? '') }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis <span class="text-danger">*</span></label>
                                <select name="jenis" id="jenis" class="form-select" required>
                                    <option value="bebas"
                                        {{ old('jenis', $artikel->jenis) == 'bebas' ? 'selected' : '' }}>Bebas</option>
                                    <option value="resensi_buku"
                                        {{ old('jenis', $artikel->jenis) == 'resensi_buku' ? 'selected' : '' }}>Resensi
                                        Buku</option>
                                    <option value="resensi_film"
                                        {{ old('jenis', $artikel->jenis) == 'resensi_film' ? 'selected' : '' }}>Resensi
                                        Film</option>
                                    <option value="video"
                                        {{ old('jenis', $artikel->jenis) == 'video' ? 'selected' : '' }}>Video</option>
                                </select>
                                @error('jenis')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span
                                        class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="menunggu"
                                        {{ old('status', $artikel->status) == 'menunggu' ? 'selected' : '' }}>Menunggu
                                    </option>
                                    <option value="draf"
                                        {{ old('status', $artikel->status) == 'draf' ? 'selected' : '' }}>Draf</option>
                                    <option value="disetujui"
                                        {{ old('status', $artikel->status) == 'disetujui' ? 'selected' : '' }}>Disetujui
                                    </option>
                                    <option value="ditolak"
                                        {{ old('status', $artikel->status) == 'ditolak' ? 'selected' : '' }}>Ditolak
                                    </option>
                                </select>
                                @error('status')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="alasan-penolakan-field"
                                class="mb-3 {{ old('status', $artikel->status) == 'ditolak' ? '' : 'd-none' }}">
                                <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
                                <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control" rows="3">{{ old('alasan_penolakan', $artikel->alasan_penolakan) }}</textarea>
                                @error('alasan_penolakan')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating Awal (opsional)</label>
                                <select name="rating" id="rating" class="form-select">
                                    <option value="">Belum ada</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('rating', $artikel->nilai_rata_rata) == $i ? 'selected' : '' }}>
                                            ⭐ {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
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
    <script src="https://cdn.tiny.cloud/1/4xazwn7uf3t198xvx4jq99bmdaj364wz6x88joubmdqdtlrn/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            // Initialize TinyMCE
            tinymce.init({
                selector: '#edit_isi', // Gunakan edit_isi untuk form edit
                height: 500,
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
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
                        if (charCount >= 3000 && e.keyCode !== 8 && e.keyCode !== 46) {
                            e.preventDefault();
                        }
                    });
                    editor.on('input change', updateCharCount);
                    editor.on('init', updateCharCount);
                }
            });

            // Initialize Select2
            const $idSiswa = $('#id_siswa').select2({
                placeholder: 'Ketik nama atau NIS siswa',
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.search.siswa') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data,
                            pagination: {
                                more: data.length === 10
                            }
                        };
                    },
                    cache: true
                }
            });

            $('#id_kategori').select2({
                placeholder: 'Pilih Kategori',
                allowClear: true
            });

            // Pre-select Student
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
                        const siswa = data.find(item => item.id == siswaId);
                        if (siswa) {
                            const option = new Option(siswa.text, siswa.id, true, true);
                            $idSiswa.append(option).trigger('change');
                            $('#kelas_siswa').val(siswa.kelas || '');
                        }
                    }
                });
            }

            // Author Type Logic
            $('input[name="penulis_type"]').change(function() {
                const isSiswa = this.value === 'siswa';
                $('#siswa-fields').toggleClass('d-none', !isSiswa);
                $('#id_siswa').prop('required', isSiswa).val(null).trigger('change');
                $('#kelas_siswa').val('');
            });

            // Update Student Class
            $idSiswa.on('select2:select', function(e) {
                const data = e.params.data;
                $('#kelas_siswa').val(data.kelas || '');
            });

            // Status Change Logic
            $('#status').change(function() {
                const isDitolak = $(this).val() === 'ditolak';
                $('#alasan-penolakan-field').toggleClass('d-none', !isDitolak);
                $('#alasan_penolakan').prop('required', isDitolak);
            });

            // Image Preview
            let initialImagePreview = '';
            @if ($artikel->gambar)
                initialImagePreview = '{{ asset('storage/' . $artikel->gambar) }}';
            @endif
            $('#gambar').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').html(
                            `<img src="${e.target.result}" style="max-width: 200px; border-radius: 5px;">`
                            );
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview').html(initialImagePreview ?
                        `<img src="${initialImagePreview}" style="max-width: 200px; border-radius: 5px;">` :
                        '');
                }
            });

            // AJAX Form Submission
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
                                    `<div class="alert alert-danger mt-1">${error[0]}</div>`
                                    );
                            });
                        }
                    },
                    complete: function() {
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                });
            });

            // Alert Function
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
        });
    </script>
@endsection
