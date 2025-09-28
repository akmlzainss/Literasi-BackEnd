@extends('layouts.app')

@section('title', 'Trash (Soft Delete)')
@section('page-title', 'Trash (Soft Delete)')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4 text-primary fw-bold">
            <i class="bi bi-trash3-fill me-2"></i> Trash (Soft Delete)
        </h1>

        <a href="{{ route('admin.pengaturan.index') }}" class="btn btn-outline-primary mb-4">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Pengaturan
        </a>

        <ul class="nav nav-tabs" id="trashTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active fw-semibold text-primary" id="artikel-tab" data-bs-toggle="tab" href="#artikel" role="tab" aria-selected="true">
                    <i class="bi bi-file-earmark-text me-2"></i> Artikel
                    <span class="badge bg-secondary ms-2">{{ $artikels->count() }}</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link fw-semibold text-primary" id="kategori-tab" data-bs-toggle="tab" href="#kategori" role="tab" aria-selected="false">
                    <i class="bi bi-tags me-2"></i> Kategori
                    <span class="badge bg-secondary ms-2">{{ $kategoris->count() }}</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link fw-semibold text-primary" id="siswa-tab" data-bs-toggle="tab" href="#siswa" role="tab" aria-selected="false">
                    <i class="bi bi-people me-2"></i> Siswa
                    <span class="badge bg-secondary ms-2">{{ $siswas->count() }}</span>
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link fw-semibold text-primary" id="penghargaan-tab" data-bs-toggle="tab" href="#penghargaan" role="tab" aria-selected="false">
                    <i class="bi bi-award me-2"></i> Penghargaan
                    <span class="badge bg-secondary ms-2">{{ $penghargaan->count() }}</span>
                </a>
            </li>
        </ul>

       <div class="tab-content mt-4" id="trashTabsContent">

    {{-- Artikel --}}
    <div class="tab-pane fade show active" id="artikel" role="tabpanel" aria-labelledby="artikel-tab">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="card-title text-primary mb-3">
                    <i class="bi bi-file-earmark-text me-2"></i> Artikel Terhapus
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>ID Siswa</th>
                                <th>ID Kategori</th>
                                <th>Judul</th>
                                <th>Gambar</th>
                                <th>Isi</th>
                                <th>Penulis Type</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Alasan Penolakan</th>
                                <th>Diterbitkan Pada</th>
                                <th>Updated At</th>
                                <th>Jumlah Dilihat</th>
                                <th>Jumlah Suka</th>
                                <th>Nilai Rata-rata</th>
                                <th>Riwayat Persetujuan</th>
                                <th>Usulan Kategori</th>
                                <th>Created At</th>
                                <th>Deleted At</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($artikels as $artikel)
                                <tr>
                                    <td>{{ $artikel->id }}</td>
                                    <td>{{ $artikel->id_siswa }}</td>
                                    <td>{{ $artikel->id_kategori }}</td>
                                    <td>{{ $artikel->judul }}</td>
                                    <td>{{ $artikel->gambar }}</td>
                                    <td>{{ $artikel->isi }}</td>
                                    <td>{{ $artikel->penulis_type }}</td>
                                    <td>{{ $artikel->jenis }}</td>
                                    <td>{{ $artikel->status }}</td>
                                    <td>{{ $artikel->alasan_penolakan }}</td>
                                    <td>{{ $artikel->diterbitkan_pada }}</td>
                                    <td>{{ $artikel->updated_at }}</td>
                                    <td>{{ $artikel->jumlah_dilihat }}</td>
                                    <td>{{ $artikel->jumlah_suka }}</td>
                                    <td>{{ $artikel->nilai_rata_rata }}</td>
                                    <td>{{ $artikel->riwayat_persetujuan }}</td>
                                    <td>{{ $artikel->usulan_kategori }}</td>
                                    <td>{{ $artikel->created_at }}</td>
                                    <td>{{ $artikel->deleted_at }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('pengaturan.restore', ['model' => 'artikel', 'id' => $artikel->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success me-2" title="Restore Artikel">
                                                <i class="bi bi-arrow-counterclockwise"></i> Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('pengaturan.forceDelete', ['model' => 'artikel', 'id' => $artikel->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Permanen">
                                                <i class="bi bi-x-circle"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="20" class="text-center text-muted py-3">Tidak ada artikel terhapus</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Kategori --}}
    <div class="tab-pane fade" id="kategori" role="tabpanel" aria-labelledby="kategori-tab">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="card-title text-primary mb-3">
                    <i class="bi bi-tags me-2"></i> Kategori Terhapus
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Dibuat Pada</th>
                                <th>Deleted At</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategoris as $kategori)
                                <tr>
                                    <td>{{ $kategori->id }}</td>
                                    <td>{{ $kategori->nama }}</td>
                                    <td>{{ $kategori->deskripsi }}</td>
                                    <td>{{ $kategori->dibuat_pada }}</td>
                                    <td>{{ $kategori->deleted_at }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('pengaturan.restore', ['model' => 'kategori', 'id' => $kategori->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success me-2" title="Restore Kategori">
                                                <i class="bi bi-arrow-counterclockwise"></i> Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('pengaturan.forceDelete', ['model' => 'kategori', 'id' => $kategori->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Permanen">
                                                <i class="bi bi-x-circle"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-3">Tidak ada kategori terhapus</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Siswa --}}
    <div class="tab-pane fade" id="siswa" role="tabpanel" aria-labelledby="siswa-tab">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="card-title text-primary mb-3">
                    <i class="bi bi-people me-2"></i> Siswa Terhapus
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>NIS</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Kelas</th>
                                <th>Status Aktif</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Deleted At</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswas as $siswa)
                                <tr>
                                    <td>{{ $siswa->id }}</td>
                                    <td>{{ $siswa->nis }}</td>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>{{ $siswa->email }}</td>
                                    <td>{{ $siswa->password }}</td>
                                    <td>{{ $siswa->kelas }}</td>
                                    <td>{{ $siswa->status_aktif }}</td>
                                    <td>{{ $siswa->created_at }}</td>
                                    <td>{{ $siswa->updated_at }}</td>
                                    <td>{{ $siswa->deleted_at }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('pengaturan.restore', ['model' => 'siswa', 'id' => $siswa->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success me-2" title="Restore Siswa">
                                                <i class="bi bi-arrow-counterclockwise"></i> Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('pengaturan.forceDelete', ['model' => 'siswa', 'id' => $siswa->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus siswa ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Permanen">
                                                <i class="bi bi-x-circle"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="11" class="text-center text-muted py-3">Tidak ada siswa terhapus</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Penghargaan --}}
    <div class="tab-pane fade" id="penghargaan" role="tabpanel" aria-labelledby="penghargaan-tab">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="card-title text-primary mb-3">
                    <i class="bi bi-award me-2"></i> Penghargaan Terhapus
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>ID Artikel</th>
                                <th>ID Siswa</th>
                                <th>ID Admin</th>
                                <th>Jenis</th>
                                <th>Bulan/Tahun</th>
                                <th>Deskripsi Penghargaan</th>
                                <th>Dibuat Pada</th>
                                <th>Deleted At</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penghargaan as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->id_artikel }}</td>
                                    <td>{{ $item->id_siswa }}</td>
                                    <td>{{ $item->id_admin }}</td>
                                    <td>{{ $item->jenis }}</td>
                                    <td>{{ $item->bulan_tahun }}</td>
                                    <td>{{ $item->deskripsi_penghargaan }}</td>
                                    <td>{{ $item->dibuat_pada }}</td>
                                    <td>{{ $item->deleted_at }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('pengaturan.restore', ['model' => 'penghargaan', 'id' => $item->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success me-2" title="Restore Penghargaan">
                                                <i class="bi bi-arrow-counterclockwise"></i> Restore
                                            </button>
                                        </form>
                                        <form action="{{ route('pengaturan.forceDelete', ['model' => 'penghargaan', 'id' => $item->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus penghargaan ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Permanen">
                                                <i class="bi bi-x-circle"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="10" class="text-center text-muted py-3">Tidak ada penghargaan terhapus</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
    <style>
        .nav-tabs .nav-link {
            border-radius: 0.25rem;
            margin-right: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .nav-tabs .nav-link.active {
            background-color: var(--primary-blue, #2563eb);
            color: white !important;
            border-color: var(--primary-blue, #2563eb);
        }
        .nav-tabs .nav-link:hover {
            background-color: var(--light-blue, #60a5fa);
            color: white !important;
        }
        .table-responsive {
            border-radius: 0.25rem;
            overflow-x: auto;
        }
        .btn-success, .btn-danger {
            min-width: 100px;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }
        .text-muted {
            font-size: 0.9rem;
        }
    </style>
@endpush
@endsection