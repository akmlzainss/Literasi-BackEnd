<div class="comment-item" data-comment-id="{{ $komentar->id }}">
    <div class="comment-author">
        <span class="comment-author-avatar">
            {{ Str::substr($komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'U'), 0, 1) }}
        </span>
        <span>{{ $komentar->siswa ? $komentar->siswa->nama : ($komentar->admin ? $komentar->admin->nama : 'Unknown') }}</span>
    </div>
    <p class="comment-text">{{ $komentar->komentar }}</p>
    <div class="comment-meta">
        <span>{{ $komentar->created_at->diffForHumans() }}</span>
        @auth('siswa')
            @if ((Auth::guard('siswa')->check() && $komentar->id_siswa == Auth::guard('siswa')->id()) || Auth::guard('admin')->check() || Auth::guard('web')->check())
                <button class="btn btn-outline-secondary btn-sm delete-comment" data-id="{{ $komentar->id }}">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            @endif
        @endauth
    </div>
</div>