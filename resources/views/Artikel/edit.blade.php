@extends('layouts.app')

@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel Literasi Akhlak')

@section('content')
    <!-- External Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/artikel.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="main-card">
                    <!-- Card Header -->
                    <div class="card-header-custom">
                        <div>
                            <i class="fas fa-edit me-2"></i> Form Edit Artikel
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body-custom">
                        <!-- Error and Success Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <!-- Form -->
                        <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST"
                            enctype="multipart/form-data" id="edit-artikel-form">
                            @csrf
                            @method('PUT')

                            <!-- Article Title -->
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Artikel</label>
                                <input type="text" name="judul" id="judul" class="form-control"
                                    value="{{ old('judul', $artikel->judul) }}" required>
                            </div>

                            <!-- Article Content -->
                            <div class="mb-3">
                                <label for="isi" class="form-label">Isi Artikel</label>
                                <textarea name="isi" id="edit_isi" class="form-control" rows="10" required>{{ old('isi', $artikel->isi) }}</textarea>
                                <div id="charCount" class="text-muted mt-1" style="font-size: 0.9em;">0/3000</div>
                            </div>

                            <!-- Article Image -->
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Ganti Gambar (opsional)</label>
                                <input type="file" name="gambar" id="gambar" class="form-control">
                                @if ($artikel->gambar)
                                    <div class="mt-2">
                                        <small>Gambar Saat Ini:</small><br>
                                        <img src="{{ asset('storage/' . $artikel->gambar) }}" alt="Gambar Saat Ini"
                                            style="max-width: 200px; margin-top: 5px; border-radius: 5px;">
                                    </div>
                                @endif
                            </div>

                            <!-- Category Selection -->
                            <div class="mb-3">
                                <label for="id_kategori" class="form-label">Kategori</label>
                                <select name="id_kategori" id="id_kategori" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach (\App\Models\Kategori::all() as $kategori)
                                        <option value="{{ $kategori->id }}"
                                            {{ old('id_kategori', $artikel->id_kategori) == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Author Type Selection -->
                            <div class="mb-3">
                                <label class="form-label">Penulis Artikel</label>
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
                            </div>

                            <!-- Student Fields (Conditional) -->
                            <div id="siswa-fields"
                                class="row {{ old('penulis_type', $artikel->penulis_type) == 'siswa' ? '' : 'd-none' }}">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="id_siswa" class="form-label">Cari Nama Siswa</label>
                                        <select name="id_siswa" id="id_siswa" class="form-control"
                                            {{ old('penulis_type', $artikel->penulis_type) == 'siswa' ? 'required' : '' }}>
                                            @if (old('id_siswa', $artikel->id_siswa))
                                                <option value="{{ old('id_siswa', $artikel->id_siswa) }}" selected>
                                                    {{ $artikel->siswa ? $artikel->siswa->nama . ' (' . $artikel->siswa->nis . ')' : 'Siswa Tidak Ditemukan' }}
                                                </option>
                                            @endif
                                        </select>
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

                            <!-- Article Type -->
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis</label>
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
                            </div>

                            <!-- Article Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
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
                            </div>

                            <!-- Reason for Rejection (Conditional) -->
                            <div id="alasan-penolakan-field"
                                class="mb-3 {{ old('status', $artikel->status) == 'ditolak' ? '' : 'd-none' }}">
                                <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
                                <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control" rows="3">{{ old('alasan_penolakan', $artikel->alasan_penolakan) }}</textarea>
                            </div>
                            <!-- Initial Rating (optional) -->
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating Awal (opsional)</label>
                                <select name="rating" id="rating" class="form-select">
                                    <option value="">Belum ada</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('rating', $artikel->rating) == $i ? 'selected' : '' }}>
                                            ⭐ {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>


                            <!-- Form Actions -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- External Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/4xazwn7uf3t198xvx4jq99bmdaj364wz6x88joubmdqdtlrn/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function() {
            // === TinyMCE Editor Initialization ===
            tinymce.init({
                selector: 'textarea#edit_isi',
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
                },
                file_picker_callback: function(cb, value, meta) {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.onchange = function() {
                        const file = this.files[0];
                        const reader = new FileReader();
                        reader.onload = function() {
                            const id = 'blobid' + (new Date()).getTime();
                            const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                            const base64 = reader.result.split(',')[1];
                            const blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);
                            cb(blobInfo.blobUri(), {
                                title: file.name
                            });
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
                }
            });

            // === Select2 Initialization for Student Search ===
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

            // === Select2 Initialization for Category ===
            $('#id_kategori').select2({
                placeholder: 'Pilih Kategori',
                allowClear: true
            });

            // === Initialize Form State ===
            const penulisType = '{{ old('penulis_type', $artikel->penulis_type) }}';
            const siswaId = '{{ old('id_siswa', $artikel->id_siswa) }}';
            const kategoriId = '{{ old('id_kategori', $artikel->id_kategori) }}';

            // Pre-select Category
            if (kategoriId) {
                $('#id_kategori').val(kategoriId).trigger('change');
            }

            // Pre-select Student if penulis_type is 'siswa'
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

            // === Author Type Radio Button Logic ===
            $('input[type=radio][name=penulis_type]').change(function() {
                if (this.value === 'siswa') {
                    $('#siswa-fields').removeClass('d-none');
                    $('#id_siswa').prop('required', true);
                    if (!$idSiswa.val()) {
                        $idSiswa.val(null).trigger(
                        'change'); // Ensure dropdown is cleared and re-initialized
                    }
                } else {
                    $('#siswa-fields').addClass('d-none');
                    $idSiswa.val(null).trigger('change').prop('required', false);
                    $('#kelas_siswa').val('');
                }
            });

            // === Update Student Class on Selection ===
            $idSiswa.on('select2:select', function(e) {
                const data = e.params.data;
                $('#kelas_siswa').val(data.kelas || '');
            });

            // === Clear Student Selection ===
            $idSiswa.on('select2:clear', function() {
                $('#kelas_siswa').val('');
            });

            // === Status Change Logic for Rejection Reason ===
            $('#status').change(function() {
                if ($(this).val() === 'ditolak') {
                    $('#alasan-penolakan-field').removeClass('d-none');
                    $('#alasan_penolakan').prop('required', true);
                } else {
                    $('#alasan-penolakan-field').addClass('d-none');
                    $('#alasan_penolakan').prop('required', false).val('');
                }
            });

            // === Form Submission Validation ===
            $('#edit-artikel-form').on('submit', function(e) {
                tinymce.triggerSave();
                const kategoriId = $('#id_kategori').val();
                if (!kategoriId) {
                    e.preventDefault();
                    alert('Silakan pilih kategori terlebih dahulu.');
                    return false;
                }
                if ($('#penulis_siswa').is(':checked') && !$idSiswa.val()) {
                    e.preventDefault();
                    alert('Silakan pilih siswa terlebih dahulu.');
                    return false;
                }
            });
        });
    </script>
@endsection
