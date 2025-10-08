<div class="komentar-item mb-4" id="komentar-{{ $komentar->id }}">
    <div class="d-flex align-items-start">
        <div class="author-avatar-siswa flex-shrink-0 me-3">
            {{ strtoupper(substr($komentar->siswa->nama ?? ($komentar->admin->nama ?? 'U'), 0, 2)) }}
        </div>

        <div class="komentar-body w-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="name fw-semibold">
                        {{ $komentar->siswa->nama ?? ($komentar->admin->nama ?? 'Pengguna') }}
                        @if ($komentar->admin)
                            <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill ms-1" style="font-size: 0.7rem;">Admin</span>
                        @endif
                    </span>
                    <p class="date text-muted small mb-1">
                        {{ $komentar->created_at ? $komentar->created_at->diffForHumans() : 'Beberapa waktu lalu' }}
                    </p>
                </div>

                <div class="comment-actions">
                    @auth('siswa')
                        <button class="btn btn-outline-secondary btn-sm btn-reply" data-id="{{ $komentar->id }}">
                            <i class="fas fa-reply"></i> Balas
                        </button>
                        @if ((Auth::guard('siswa')->check() && Auth::guard('siswa')->id() == $komentar->id_siswa)
                            || Auth::guard('admin')->check())
                            <button class="btn btn-outline-danger btn-sm delete-comment" data-id="{{ $komentar->id }}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        @endif
                    @endauth
                </div>
            </div>

            <p class="komentar-text mt-2 mb-2">{{ $komentar->komentar }}</p>

            {{-- Tombol & daftar balasan --}}
            @if ($komentar->replies->isNotEmpty())
                <button class="btn btn-link text-decoration-none text-muted p-0 lihat-balasan-btn"
                        data-id="{{ $komentar->id }}">
                    Lihat {{ $komentar->replies->count() }} balasan ▼
                </button>

                <div class="balasan-list mt-3 ms-4" id="balasan-{{ $komentar->id }}" style="display: none;">
                    @foreach ($komentar->replies as $balasan)
                        <div class="balasan border-start ps-3 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="author-avatar-siswa me-2">
                                    {{ strtoupper(substr($balasan->siswa->nama ?? 'U', 0, 2)) }}
                                </div>
                                <div>
                                    <p class="mb-0 fw-semibold">{{ $balasan->siswa->nama ?? 'User' }}</p>
                                    <p class="text-muted small mb-1">
                                        {{ $balasan->created_at?->diffForHumans() ?? 'Beberapa waktu lalu' }}
                                    </p>
                                    <p class="mb-2">{{ $balasan->komentar }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Form balas komentar --}}
            @auth('siswa')
                <form action="{{ route('komentar.reply', ['id' => $konten->id, 'parentId' => $komentar->id]) }}"
                      method="POST"
                      class="reply-form mt-3"
                      data-parent-id="{{ $komentar->id }}"
                      style="display: none;">
                    @csrf
                    <div class="mb-2">
                        <textarea class="form-control" name="komentar" rows="2" placeholder="Tulis balasan Anda..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Kirim Balasan</button>
                    <button type="button" class="btn btn-secondary btn-sm btn-cancel-reply">Batal</button>
                </form>
            @endauth
        </div>
    </div>
</div>
