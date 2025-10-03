@extends('layouts.app')

@section('title', 'Tambah Penghargaan')
@section('page-title', 'Tambah Penghargaan Literasi Akhlak')

@section('content')
<link rel="stylesheet" href="{{ asset('css/penghargaan.css') }}">

<div class="page-header">
    <h1 class="page-title">Tambah Penghargaan Baru</h1>
    <p class="page-subtitle">Isi formulir berikut untuk menambahkan penghargaan baru</p>
    <a href="{{ route('admin.penghargaan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Penghargaan
    </a>
</div>

<div class="main-card">
    <div class="card-body-custom">
        @if ($topItems->isEmpty())
            <div class="alert alert-warning">
                Tidak ada {{ $preSelectedType ?? 'artikel' }} tersedia untuk bulan ini. Silakan unggah konten terlebih dahulu atau pilih bulan lain.
                <a href="{{ route('admin.penghargaan.index') . '?month=' . $selectedMonth }}" class="alert-link">Kembali ke daftar</a>.
            </div>
        @else
            <form action="{{ route('admin.penghargaan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ $preSelectedType ?? 'artikel' }}">

                {{-- Pilih Item (Artikel/Video) --}}
                <div class="mb-3">
                    <label for="id_item" class="form-label">Pilih {{ ucfirst($preSelectedType ?? 'Artikel') }} (Top 5 {{ $preSelectedType ?? 'artikel' === 'artikel' ? 'Rating' : 'Like' }})</label>
                    <select name="id_item" class="form-control" id="id_item" {{ isset($preSelectedId) ? 'disabled' : '' }} required>
                        <option value="">-- Pilih {{ ucfirst($preSelectedType ?? 'Artikel') }} --</option>
                        @foreach ($topItems as $item)
                            <option value="{{ $item->id }}" {{ $preSelectedId == $item->id ? 'selected' : '' }}
                                data-judul="{{ $item->judul }}"
                                data-nama="{{ $item->siswa_nama ?? 'Unknown' }}"
                                data-kelas="{{ $item->siswa_kelas ?? '-' }}"
                                data-foto="{{ $item->gambar ? asset('storage/' . ($item->type === 'artikel' ? 'artikel/' : 'videos/') . $item->gambar) : asset('images/default.jpg') }}"
                                data-rating="{{ $item->rating ?? 0 }}"
                                data-type="{{ $item->type }}">
                                {{ $item->judul }} ({{ $item->type === 'artikel' ? 'Rating' : 'Like' }}: {{ number_format($item->rating ?? 0, 1) }})
                            </option>
                        @endforeach
                    </select>

                    {{-- =============================================== --}}
                    {{-- || PERBAIKAN DITAMBAHKAN DI SINI            || --}}
                    {{-- =============================================== --}}
                    @if(isset($preSelectedId))
                        <input type="hidden" name="id_item" value="{{ $preSelectedId }}">
                    @endif
                    {{-- =============================================== --}}
                    {{-- || AKHIR DARI PERBAIKAN                      || --}}
                    {{-- =============================================== --}}

                    @error('id_item')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Info Preview --}}
                <div class="mb-3" id="itemInfo" style="display: {{ isset($preSelectedId) ? 'block' : 'none' }};">
                    <div class="card shadow-sm border-0" style="max-width: 500px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img id="itemFoto" src="" class="img-fluid rounded-start" alt="Item Image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title mb-1" id="itemJudul"></h5>
                                    <p class="card-text mb-1"><strong>Penulis:</strong> <span id="itemPenulis"></span></p>
                                    <p class="card-text mb-1"><strong>Kelas:</strong> <span id="itemKelas"></span></p>
                                    <p class="card-text mb-1">
                                        <strong id="itemLabel">Rating:</strong> <span id="itemRating"></span>
                                        <span id="itemStars" class="ms-2"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bulan & Tahun --}}
                <div class="mb-3">
                    <label for="bulan_tahun" class="form-label">Bulan dan Tahun</label>
                    <input type="date" name="bulan_tahun" id="bulan_tahun" class="form-control"
                        value="{{ old('bulan_tahun', \Carbon\Carbon::parse($selectedMonth)->format('Y-m-d')) }}" required>
                    @error('bulan_tahun')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis --}}
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Penghargaan</label>
                    <select name="jenis" id="jenis" class="form-control" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="bulanan" {{ old('jenis', 'bulanan') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        <option value="spesial" {{ old('jenis') == 'spesial' ? 'selected' : '' }}>Spesial</option>
                    </select>
                    @error('jenis')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="deskripsi_penghargaan" class="form-label">Deskripsi Penghargaan</label>
                    <textarea name="deskripsi_penghargaan" id="deskripsi_penghargaan" class="form-control" rows="4" required>{{ old('deskripsi_penghargaan') }}</textarea>
                    @error('deskripsi_penghargaan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Submit --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Simpan Penghargaan</button>
                    <a href="{{ route('admin.penghargaan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        @endif
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const itemSelect = document.getElementById('id_item');
    const itemInfo = document.getElementById('itemInfo');
    const itemFoto = document.getElementById('itemFoto');
    const itemJudul = document.getElementById('itemJudul');
    const itemPenulis = document.getElementById('itemPenulis');
    const itemKelas = document.getElementById('itemKelas');
    const itemRating = document.getElementById('itemRating');
    const itemStars = document.getElementById('itemStars');
    const itemLabel = document.getElementById('itemLabel');
    const deskripsi = document.getElementById('deskripsi_penghargaan');

    const updatePreview = (selected) => {
        if (selected && selected.value) {
            itemInfo.style.display = 'block';
            itemFoto.src = selected.dataset.foto;
            itemJudul.textContent = selected.dataset.judul;
            itemPenulis.textContent = selected.dataset.nama;
            itemKelas.textContent = selected.dataset.kelas;
            
            const ratingValue = parseFloat(selected.dataset.rating || 0);
            itemRating.textContent = ratingValue.toFixed(1);

            const type = selected.dataset.type;
            itemLabel.innerHTML = type === 'artikel' ? '<strong>Rating:</strong>' : '<strong>Like:</strong>';
            
            let starsHtml = '';
            if (type === 'artikel') {
                for (let i = 1; i <= 5; i++) {
                    starsHtml += (i <= ratingValue) ? '⭐' : '☆';
                }
            } else {
                starsHtml = `<i class="fas fa-heart text-danger me-1"></i>`;
            }
            itemStars.innerHTML = starsHtml;

            if (!deskripsi.value.trim()) {
                deskripsi.value = `Penghargaan untuk ${type} terbaik: "${selected.dataset.judul}"`;
            }
        } else {
            itemInfo.style.display = 'none';
        }
    };

    if (itemSelect) {
        itemSelect.addEventListener('change', function () {
            updatePreview(this.options[this.selectedIndex]);
        });

        @if(isset($preSelectedId))
            setTimeout(() => {
                const selectedOption = itemSelect.querySelector('option[value="{{ $preSelectedId }}"]');
                if (selectedOption) {
                    updatePreview(selectedOption);
                }
            }, 100);
        @endif
    }
});
</script>
@endsection