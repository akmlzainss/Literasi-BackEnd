@extends('layouts.admin')

@section('title', 'Trash (Soft Delete)')
@section('page-title', 'Trash (Soft Delete)')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/siswa.css') }}">

    <div class="page-header">
        <h1 class="page-title">Trash (Soft Delete)</h1>
        <p class="page-subtitle">Kelola data yang telah dihapus sementara (soft delete)</p>
        <div class="action-buttons">
            <a href="{{ route('admin.pengaturan.index') }}" class="btn-outline-custom">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Pengaturan
            </a>
        </div>
    </div>

    <div class="main-card">
        <div class="card-header-custom">
            <div>
                <i class="bi bi-trash3-fill me-2"></i>Data Terhapus
            </div>
            <div class="d-flex align-items-center gap-2 text-white">
                <i class="fas fa-info-circle"></i>
                <span>Total: {{ $artikels->total() + $kategoris->total() + $siswas->total() + $penghargaan->total() }}
                    data</span>
            </div>
        </div>

        <div class="card-body-custom">
            <ul class="nav nav-tabs mb-4" id="trashTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active fw-semibold text-primary" id="artikel-tab" data-bs-toggle="tab"
                        href="#artikel" role="tab" aria-selected="true">
                        <i class="bi bi-file-earmark-text me-2"></i> Artikel
                        <span class="badge bg-secondary ms-2">{{ $artikels->total() }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-semibold text-primary" id="kategori-tab" data-bs-toggle="tab" href="#kategori"
                        role="tab" aria-selected="false">
                        <i class="bi bi-tags me-2"></i> Kategori
                        <span class="badge bg-secondary ms-2">{{ $kategoris->total() }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-semibold text-primary" id="siswa-tab" data-bs-toggle="tab" href="#siswa"
                        role="tab" aria-selected="false">
                        <i class="bi bi-people me-2"></i> Siswa
                        <span class="badge bg-secondary ms-2">{{ $siswas->total() }}</span>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link fw-semibold text-primary" id="penghargaan-tab" data-bs-toggle="tab"
                        href="#penghargaan" role="tab" aria-selected="false">
                        <i class="bi bi-award me-2"></i> Penghargaan
                        <span class="badge bg-secondary ms-2">{{ $penghargaan->total() }}</span>
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="trashTabsContent">
                <!-- Artikel -->
                <div class="tab-pane fade show active" id="artikel" role="tabpanel" aria-labelledby="artikel-tab">
                    <div class="students-table">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col">Penulis</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Deleted At</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($artikels as $index => $artikel)
                                        <tr>
                                            <td>{{ $artikels->firstItem() + $index }}</td>
                                            <td>
                                                <div class="student-name">{{ Str::limit($artikel->judul, 50) }}</div>
                                            </td>
                                            <td>
                                                <span class="class-badge">{{ $artikel->penulis_type }}</span>
                                            </td>
                                            <td>
                                                <span class="class-badge">{{ $artikel->kategori->nama ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="class-badge">{{ $artikel->status }}</span>
                                            </td>
                                            <td>
                                                <div class="student-email">{{ $artikel->deleted_at->format('d M Y H:i') }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="action-buttons-table">
                                                    <form
                                                        action="{{ route('admin.pengaturan.restore', ['model' => 'artikel', 'id' => $artikel->id]) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-action-table btn-view-table"
                                                            title="Restore Artikel">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="{{ route('admin.pengaturan.forceDelete', ['model' => 'artikel', 'id' => $artikel->id]) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus artikel ini secara permanen?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-action-table btn-delete-table"
                                                            title="Hapus Permanen">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada artikel terhapus.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($artikels->hasPages())
                            <div class="pagination-custom">
                                {{ $artikels->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Kategori -->
                <div class="tab-pane fade" id="kategori" role="tabpanel" aria-labelledby="kategori-tab">
                    <div class="students-table">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Deleted At</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kategoris as $index => $kategori)
                                        <tr>
                                            <td>{{ $kategoris->firstItem() + $index }}</td>
                                            <td>
                                                <div class="student-name">{{ $kategori->nama }}</div>
                                            </td>
                                            <td>
                                                <div class="student-email">
                                                    {{ $kategori->deleted_at->format('d M Y H:i') }}</div>
                                            </td>
                                            <td>
                                                <div class="action-buttons-table">
                                                    <form
                                                        action="{{ route('admin.pengaturan.restore', ['model' => 'kategori', 'id' => $kategori->id]) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-action-table btn-view-table"
                                                            title="Restore Kategori">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="{{ route('admin.pengaturan.forceDelete', ['model' => 'kategori', 'id' => $kategori->id]) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini secara permanen?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-action-table btn-delete-table"
                                                            title="Hapus Permanen">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada kategori terhapus.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($kategoris->hasPages())
                            <div class="pagination-custom">
                                {{ $kategoris->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Siswa -->
                <div class="tab-pane fade" id="siswa" role="tabpanel" aria-labelledby="siswa-tab">
                    <div class="students-table">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">NIS</th>
                                        <th scope="col">Nama Lengkap</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Kelas</th>
                                        <th scope="col">Deleted At</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($siswas as $index => $siswa)
                                        <tr>
                                            <td>{{ $siswas->firstItem() + $index }}</td>
                                            <td>{{ $siswa->nis }}</td>
                                            <td>
                                                <div class="student-name">{{ $siswa->nama }}</div>
                                            </td>
                                            <td>
                                                <div class="student-email">{{ $siswa->email }}</div>
                                            </td>
                                            <td>
                                                <span class="class-badge">{{ $siswa->kelas }}</span>
                                            </td>
                                            <td>
                                                <div class="student-email">{{ $siswa->deleted_at->format('d M Y H:i') }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="action-buttons-table">
                                                    <form
                                                        action="{{ route('admin.pengaturan.restore', ['model' => 'siswa', 'id' => $siswa->id]) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-action-table btn-view-table"
                                                            title="Restore Siswa">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="{{ route('admin.pengaturan.forceDelete', ['model' => 'siswa', 'id' => $siswa->id]) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus siswa ini secara permanen?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-action-table btn-delete-table"
                                                            title="Hapus Permanen">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada siswa terhapus.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($siswas->hasPages())
                            <div class="pagination-custom">
                                {{ $siswas->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Penghargaan -->
                <div class="tab-pane fade" id="penghargaan" role="tabpanel" aria-labelledby="penghargaan-tab">
                    <div class="students-table">
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Jenis</th>
                                        <th scope="col">Penerima</th>
                                        <th scope="col">Artikel</th>
                                        <th scope="col">Bulan/Tahun</th>
                                        <th scope="col">Deleted At</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penghargaan as $index => $item)
                                        <tr>
                                            <td>{{ $penghargaan->firstItem() + $index }}</td>
                                            <td>
                                                <span class="class-badge">{{ $item->jenis }}</span>
                                            </td>
                                            <td>
                                                <div class="student-name">{{ $item->siswa->nama ?? 'N/A' }}</div>
                                            </td>
                                            <td>
                                                <div class="student-name">
                                                    {{ Str::limit($item->artikel->judul ?? 'N/A', 40) }}</div>
                                            </td>
                                            <td>
                                                <span class="class-badge">{{ $item->bulan_tahun }}</span>
                                            </td>
                                            <td>
                                                <div class="student-email">{{ $item->deleted_at->format('d M Y H:i') }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="action-buttons-table">
                                                    <form
                                                        action="{{ route('admin.pengaturan.restore', ['model' => 'penghargaan', 'id' => $item->id]) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-action-table btn-view-table"
                                                            title="Restore Penghargaan">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="{{ route('admin.pengaturan.forceDelete', ['model' => 'penghargaan', 'id' => $item->id]) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus penghargaan ini secara permanen?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-action-table btn-delete-table"
                                                            title="Hapus Permanen">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada penghargaan terhapus.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($penghargaan->hasPages())
                            <div class="pagination-custom">
                                {{ $penghargaan->links() }}
                            </div>
                        @endif
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
        </style>
    @endpush
@endsection
