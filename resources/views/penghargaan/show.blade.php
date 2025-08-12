@extends('layouts.app')

@section('title', 'Detail Penghargaan')
@section('page-title', 'Detail Penghargaan Literasi Akhlak')

@section('content')
<link rel="stylesheet" href="{{ asset('css/penghargaan.css') }}">

<div class="page-header">
    <h1 class="page-title">Detail Penghargaan</h1>
    <p class="page-subtitle">Informasi lengkap tentang penghargaan</p>
</div>

<div class="main-card">
    <div class="card-body-custom">
        <div class="award-card fade-in">
            <div class="award-header" style="background: linear-gradient(135deg, {{ $penghargaan->jenis == 'bulanan' ? '#f59e0b, #d97706' : '#8b5cf6, #7c3aed' }});">
                <h5 class="award-title">{{ $penghargaan->deskripsi_penghargaan }}</h5>
                <span class="award-status {{ \Carbon\Carbon::parse($penghargaan->bulan_tahun)->isPast() ? 'status-inactive' : 'status-active' }}">
                    {{ \Carbon\Carbon::parse($penghargaan->bulan_tahun)->isPast() ? 'Nonaktif' : 'Aktif' }}
                </span>
            </div>
            <div class="award-content">
                <p><strong>Deskripsi:</strong> {{ $penghargaan->deskripsi_penghargaan }}</p>
                <p><strong>Jenis:</strong> {{ ucfirst($penghargaan->jenis) }}</p>
                <p><strong>Bulan/Tahun:</strong> {{ \Carbon\Carbon::parse($penghargaan->bulan_tahun)->translatedFormat('F Y') }}</p>
                <p><strong>Siswa:</strong> {{ $penghargaan->siswa ? $penghargaan->siswa->nama : 'Siswa tidak ditemukan' }}</p>
                <p><strong>Artikel:</strong> {{ $penghargaan->artikel ? $penghargaan->artikel->judul : 'Tidak ada artikel' }}</p>
                <p><strong>Diberikan oleh:</strong> {{ $penghargaan->admin ? $penghargaan->admin->nama : 'Admin tidak ditemukan' }}</p>
                <p><strong>Tanggal Dibuat:</strong> {{ \Carbon\Carbon::parse($penghargaan->dibuat_pada)->translatedFormat('d F Y H:i') }}</p>
                <div class="award-actions">
                    <button class="btn-action-card btn-edit-card" data-id="{{ $penghargaan->id }}" data-bs-toggle="modal" data-bs-target="#modalEditPenghargaan">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('penghargaan.destroy', $penghargaan->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action-card btn-delete-card" onclick="return confirm('Apakah Anda yakin ingin menghapus penghargaan ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Penghargaan -->
<div class="modal fade" id="modalEditPenghargaan" tabindex="-1" aria-labelledby="modalEditPenghargaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editPenghargaanForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPenghargaanLabel">Edit Penghargaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_id_artikel" class="form-label">Artikel (Opsional)</label>
                        <select name="id_artikel" id="edit_id_artikel" class="form-control">
                            <option value="">Pilih Artikel</option>
                            <!-- Artikel akan diisi oleh JavaScript -->
                        </select>
                        @error('id_artikel')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_id_siswa" class="form-label">Siswa</label>
                        <select name="id_siswa" id="edit_id_siswa" class="form-control" required>
                            <option value="">Pilih Siswa</option>
                            @foreach ($siswa as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @error('id_siswa')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_jenis" class="form-label">Jenis Penghargaan</label>
                        <select name="jenis" id="edit_jenis" class="form-control" required>
                            <option value="bulanan">Bulanan</option>
                            <option value="spesial">Spesial</option>
                        </select>
                        @error('jenis')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_bulan_tahun" class="form-label">Bulan dan Tahun</label>
                        <input type="date" name="bulan_tahun" id="edit_bulan_tahun" class="form-control" required>
                        @error('bulan_tahun')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi_penghargaan" class="form-label">Deskripsi Penghargaan</label>
                        <textarea name="deskripsi_penghargaan" id="edit_deskripsi_penghargaan" class="form-control" rows="4" required></textarea>
                        @error('deskripsi_penghargaan')
                            <div class="text-danger">{{ $message }}</div>
                        @error
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Perbarui Penghargaan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButton = document.querySelector('.btn-edit-card');
    if (editButton) {
        editButton.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            fetch(`/penghargaan/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    const form = document.getElementById('editPenghargaanForm');
                    form.action = `/penghargaan/${id}`;
                    document.getElementById('edit_id').value = data.penghargaan.id || '';
                    document.getElementById('edit_id_artikel').value = data.penghargaan.id_artikel || '';
                    document.getElementById('edit_id_siswa').value = data.penghargaan.id_siswa || '';
                    document.getElementById('edit_jenis').value = data.penghargaan.jenis || '';
                    document.getElementById('edit_bulan_tahun').value = data.penghargaan.bulan_tahun || '';
                    document.getElementById('edit_deskripsi_penghargaan').value = data.penghargaan.deskripsi_penghargaan || '';
                    // Update dropdown artikel
                    const select = document.getElementById('edit_id_artikel');
                    select.innerHTML = '<option value="">Pilih Artikel</option>';
                    if (data.highestRatedArtikel) {
                        select.innerHTML += `<option value="${data.highestRatedArtikel.id}">${data.highestRatedArtikel.judul} (Rating Tertinggi: ${data.highestRatedArtikel.nilai_rata_rata})</option>`;
                    }
                    data.artikel.forEach(artikel => {
                        if (!data.highestRatedArtikel || artikel.id != data.highestRatedArtikel.id) {
                            select.innerHTML += `<option value="${artikel.id}">${artikel.judul} (Rating: ${artikel.nilai_rata_rata})</option>`;
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    }
});
</script>
@endsection