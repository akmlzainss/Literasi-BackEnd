@extends('layouts.app')

@section('title', 'Persetujuan Video - SMKN 11 Bandung')

@section('content')
<div class="page-header">
    <div>
        <h2 class="page-title">Persetujuan Video</h2>
        <p class="page-subtitle">Kelola video yang menunggu persetujuan</p>
    </div>
</div>

<div class="search-filter-section">
    <form action="{{ route('admin.video.persetujuan') }}" method="GET">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="search" class="form-label">Cari Video</label>
                <input type="text" name="search" id="search" class="form-control search-input" placeholder="Cari judul video..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select name="kategori" id="kategori" class="form-select filter-select">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\Kategori::all() as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="siswa" class="form-label">Siswa</label>
                <select name="siswa" id="siswa" class="form-select filter-select">
                    <option value="">Semua Siswa</option>
                    @foreach(\App\Models\Siswa::all() as $siswa)
                        <option value="{{ $siswa->id }}" {{ request('siswa') == $siswa->id ? 'selected' : '' }}>{{ $siswa->nama }} ({{ $siswa->nis }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary-custom w-100"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </div>
    </form>
</div>

<div class="main-card">
    <div class="card-header-custom">
        <span>Daftar Video Menunggu Persetujuan</span>
    </div>
    <div class="card-body-custom">
        <div class="articles-grid">
            @forelse($videos as $video)
            <div class="article-card fade-in">
                <div class="article-image">
                    <img src="{{ asset('storage/' . $video->thumbnail_path) }}" alt="Thumbnail {{ $video->judul }}" />
                    <div class="article-overlay">
                        <div class="article-actions">
                            <a href="{{ asset('storage/' . $video->video_path) }}" target="_blank" class="btn-action-card btn-view-card" title="Lihat Video">
                                <i class="fas fa-play"></i>
                            </a>
                            <button type="button" class="btn-action-card btn-edit-card" data-bs-toggle="modal" data-bs-target="#persetujuanModal{{ $video->id }}" title="Setujui/Tolak">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </div>
                    </div>
                    <div class="article-status">
                        <span class="status-badge status-menunggu">Menunggu</span>
                    </div>
                </div>
                <div class="article-content">
                    <div class="article-category">
                        <span class="category-tag">{{ $video->kategori->nama ?? 'Tanpa Kategori' }}</span>
                    </div>
                    <h5 class="article-title-card">{{ Str::limit($video->judul, 50) }}</h5>
                    <p class="article-excerpt-card">{{ Str::limit($video->deskripsi, 100) }}</p>
                    <div class="article-author-card">
                        <div class="author-avatar">{{ Str::upper(substr($video->siswa->nama ?? 'Anonim', 0, 1)) }}</div>
                        <div class="author-info">
                            <div class="author-name">{{ $video->siswa->nama ?? 'Anonim' }}</div>
                            <div class="author-role">{{ $video->siswa->nis ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="article-meta-card">
                        <div class="meta-stats">
                            <span><i class="fas fa-eye"></i> {{ $video->jumlah_dilihat ?? 0 }}</span>
                            <span><i class="fas fa-heart"></i> {{ $video->interaksi()->where('jenis', 'suka')->count() }}</span>
                        </div>
                        <div class="article-date">{{ $video->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Modal Persetujuan -->
            <div class="modal fade" id="persetujuanModal{{ $video->id }}" tabindex="-1" aria-labelledby="persetujuanModalLabel{{ $video->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="persetujuanModalLabel{{ $video->id }}">Persetujuan Video: {{ Str::limit($video->judul, 30) }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.video.update', $video->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="status{{ $video->id }}" class="form-label">Status</label>
                                    <select name="status" id="status{{ $video->id }}" class="form-select" onchange="toggleAlasan(this.value, 'alasan{{ $video->id }}')">
                                        <option value="disetujui">Disetujui</option>
                                        <option value="ditolak">Ditolak</option>
                                    </select>
                                </div>
                                <div class="mb-3" id="alasan{{ $video->id }}" style="display: none;">
                                    <label for="alasan_penolakan{{ $video->id }}" class="form-label">Alasan Penolakan</label>
                                    <textarea name="alasan_penolakan" id="alasan_penolakan{{ $video->id }}" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary-custom">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <h5>Tidak ada video yang menunggu persetujuan.</h5>
                <p class="text-muted">Semua video sudah diproses atau belum ada pengajuan baru.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pagination-custom">
            {{ $videos->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleAlasan(status, alasanId) {
    document.getElementById(alasanId).style.display = status === 'ditolak' ? 'block' : 'none';
}
</script>
@endsection