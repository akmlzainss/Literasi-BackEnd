@extends('layouts.app')

@section('title', 'Tambah Penghargaan')

@section('content')
<link rel="stylesheet" href="{{ asset('css/penghargaan.css') }}">

<div class="page-header">
    <h1 class="page-title">Tambah Penghargaan Baru</h1>
    <p class="page-subtitle">
        Bulan: <strong>{{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }}</strong> | {{ ucfirst($preSelectedType) }}
    </p>
    <a href="{{ route('admin.penghargaan.index', ['bulan_tahun' => $bulanTahun, 'active_tab' => $activeTab]) }}" 
       class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="main-card">
    <div class="card-body-custom">
        @if ($topItems->isEmpty())
            <div class="alert alert-warning">
                Tidak ada {{ $preSelectedType }} untuk bulan 
                <strong>{{ \Carbon\Carbon::parse($selectedMonth)->translatedFormat('F Y') }}</strong>.
                <a href="{{ route('admin.penghargaan.index', ['bulan_tahun' => $bulanTahun, 'active_tab' => $activeTab]) }}" 
                   class="alert-link">Kembali</a>.
            </div>
        @else
            <form action="{{ route('admin.penghargaan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ $preSelectedType }}">
                <input type="hidden" name="active_tab" value="{{ $activeTab }}">
                
                {{-- SOLUSI UTAMA UNTUK 'id_item is required' --}}
                @if(isset($preSelectedId))
                    {{-- Input Hidden ini akan mengirimkan nilai id_item meskipun SELECT di bawahnya disabled --}}
                    <input type="hidden" name="id_item" value="{{ $preSelectedId }}">
                @endif
                {{-- END SOLUSI UTAMA --}}

                {{-- Pilih Item --}}
                <div class="mb-3">
                    <label class="form-label">Pilih {{ ucfirst($preSelectedType) }} (Top 5)</label>
                    {{-- SELECT dipertahankan disabled agar tidak bisa diubah jika ada preSelectedId --}}
                    <select name="id_item" id="id_item" class="form-control" {{ isset($preSelectedId) ? 'disabled' : '' }} required>
                        <option value="">-- Pilih --</option>
                        @foreach ($topItems as $item)
                            <option value="{{ $item->id }}" {{ $preSelectedId == $item->id ? 'selected' : '' }}
                                data-judul="{{ $item->judul }}" 
                                data-nama="{{ $item->nama }}" 
                                data-kelas="{{ $item->kelas }}"
                                {{-- PERBAIKAN 1: Tambahkan data-item-type ke data-foto, dan gunakan default jika kosong --}}
                                data-foto="{{ $item->foto_url ?? ($preSelectedType === 'artikel' ? asset('images/default-buku.jpg') : asset('images/default-kamera.jpg')) }}"
                                data-rating="{{ $item->rating }}"
                                data-item-type="{{ $preSelectedType }}">
                                {{ $item->judul }} ({{ $preSelectedType == 'artikel' ? 'Rating' : 'Like' }}: 
                                {{ $preSelectedType == 'artikel' ? number_format($item->rating, 1) : $item->rating }})
                            </option>
                        @endforeach
                    </select>
                    {{-- Error message akan tetap muncul karena validasi di controller membaca input hidden --}}
                    @error('id_item') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Preview --}}
                <div class="mb-3" id="itemInfo" style="display: {{ isset($preSelectedId) ? 'block' : 'none' }};">
                    <div class="card shadow-sm border-0" style="max-width: 500px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                {{-- PERBAIKAN 2: Set default image yang lebih spesifik --}}
                                @php
                                    $defaultImg = $preSelectedType === 'artikel' ? asset('images/default-buku.jpg') : asset('images/default-kamera.jpg');
                                    $initialFoto = '';
                                    if(isset($preSelectedId)) {
                                        $selectedItem = $topItems->firstWhere('id', $preSelectedId);
                                        $initialFoto = $selectedItem ? ($selectedItem->foto_url ?? $defaultImg) : $defaultImg;
                                    } else {
                                        $initialFoto = $defaultImg;
                                    }
                                @endphp
                                <img id="itemFoto" src="{{ $initialFoto }}" 
                                     class="img-fluid rounded-start" alt="Item Image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title mb-1" id="itemJudul"></h5>
                                    <p class="card-text mb-1"><strong>Penulis:</strong> <span id="itemPenulis"></span></p>
                                    <p class="card-text mb-1"><strong>Kelas:</strong> <span id="itemKelas"></span></p>
                                    <p class="card-text mb-1">
                                        <strong id="itemLabel"></strong> 
                                        <span id="itemRating"></span>
                                        <span id="itemStars" class="ms-2"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bulan & Tahun --}}
                <div class="mb-3">
                    <label class="form-label">Bulan dan Tahun <span class="text-danger">*</span></label>
                    <input type="date" name="bulan_tahun" class="form-control" 
                           value="{{ old('bulan_tahun', \Carbon\Carbon::parse($selectedMonth)->format('Y-m-01')) }}" required>
                    @error('bulan_tahun') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Jenis --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Penghargaan</label>
                    <select name="jenis" class="form-control" required>
                        <option value="bulanan" {{ old('jenis', 'bulanan') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        <option value="spesial">Spesial</option>
                    </select>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi_penghargaan" id="deskripsi_penghargaan" class="form-control" rows="4" required>{{ old('deskripsi_penghargaan') }}</textarea>
                    @error('deskripsi_penghargaan') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Tombol --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('admin.penghargaan.index', ['bulan_tahun' => $bulanTahun, 'active_tab' => $activeTab]) }}" 
                       class="btn btn-secondary">Batal</a>
                </div>
            </form>
        @endif
    </div>
</div>

{{-- Alerts --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('id_item');
    if (!select) return;

    // Definisikan gambar default
    const defaultImageArtikel = '{{ asset('images/default-buku.jpg') }}';
    const defaultImageVideo = '{{ asset('images/default-kamera.jpg') }}';

    const updatePreview = (option) => {
        const itemInfo = document.getElementById('itemInfo');
        if (!itemInfo) return;

        if (option.value) {
            itemInfo.style.display = 'block';
            
            const itemType = option.dataset.itemType;
            const isArtikel = itemType === 'artikel';
            
            // PERBAIKAN 3: Gunakan default image yang sesuai jika data-foto kosong/null
            let fotoUrl = option.dataset.foto;
            if (!fotoUrl || fotoUrl === '{{ asset('images/default.jpg') }}') {
                fotoUrl = isArtikel ? defaultImageArtikel : defaultImageVideo;
            }
            
            document.getElementById('itemFoto').src = fotoUrl;
            document.getElementById('itemJudul').textContent = option.dataset.judul;
            document.getElementById('itemPenulis').textContent = option.dataset.nama;
            document.getElementById('itemKelas').textContent = option.dataset.kelas;

            const rating = parseFloat(option.dataset.rating) || 0;
            
            // Label & Format
            document.getElementById('itemLabel').innerHTML = `<strong>${isArtikel ? 'Rating' : 'Like'}:</strong>`;
            document.getElementById('itemRating').textContent = isArtikel ? rating.toFixed(1) : Math.round(rating);

            // Stars/Hearts
            let starsHtml = '';
            if (isArtikel) {
                // Stars untuk artikel (1 desimal)
                for (let i = 1; i <= 5; i++) {
                    starsHtml += i <= Math.round(rating) ? '⭐' : '☆';
                }
            } else {
                // Hearts untuk video (integer)
                const hearts = Math.round(rating);
                starsHtml = `<i class="fas fa-heart text-danger"></i> x${hearts}`;
            }
            
            document.getElementById('itemStars').innerHTML = starsHtml;

            // Auto-fill deskripsi
            const deskripsi = document.getElementById('deskripsi_penghargaan');
            if (deskripsi && !deskripsi.value.trim()) {
                deskripsi.value = `Penghargaan untuk "${option.dataset.judul}"`;
            }
        } else {
            itemInfo.style.display = 'none';
        }
    };

    select.addEventListener('change', function() {
        updatePreview(this.options[this.selectedIndex]);
    });

    @if(isset($preSelectedId))
        // Panggil updatePreview setelah DOM siap untuk menampilkan preselected item
        setTimeout(() => {
            const selectedOption = select.querySelector('option[value="{{ $preSelectedId }}"]');
            if (selectedOption) updatePreview(selectedOption);
        }, 100);
    @endif
});
</script>
@endsection