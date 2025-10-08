<div class="komentar-item mb-4" id="komentar-{{ $komentar->id }}" data-created-at="{{ $komentar->dibuat_pada ? $komentar->dibuat_pada->toIso8601String() : now()->toIso8601String() }}">
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
                    <p class="date text-muted small mb-1" id="comment-time-{{ $komentar->id }}">
                        @php
                            $now = now();
                            $createdAt = $komentar->dibuat_pada ?? $now;
                            $diffInMonths = $now->diffInMonths($createdAt);
                            if ($diffInMonths >= 1) {
                                echo $createdAt->format('d-m-Y');
                            } else {
                                echo $createdAt->diffForHumans();
                            }
                        @endphp
                    </p>
                </div>

                <div class="comment-actions">
                    @auth('siswa')
                        <button class="btn btn-outline-secondary btn-sm btn-reply" data-id="{{ $komentar->id }}">
                            <i class="fas fa-reply"></i> Balas
                        </button>
                        @if ((Auth::guard('siswa')->check() && Auth::guard('siswa')->id() == $komentar->id_siswa) || Auth::guard('admin')->check())
                            <button class="btn btn-outline-danger btn-sm delete-comment" data-id="{{ $komentar->id }}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        @endif
                    @endauth
                </div>
            </div>

            <p class="komentar-text mt-2 mb-2">{{ $komentar->komentar }}</p>

            @if ($komentar->replies->isNotEmpty())
                <button class="btn btn-link text-decoration-none text-muted p-0 lihat-balasan-btn" data-id="{{ $komentar->id }}">
                    Lihat {{ $komentar->replies->count() }} balasan ▼
                </button>

                <div class="balasan-list mt-3 ms-4" id="balasan-{{ $komentar->id }}" style="display: none;">
                    @foreach ($komentar->replies as $balasan)
                        <div class="balasan border-start ps-3 mb-3" id="komentar-{{ $balasan->id }}" data-created-at="{{ $balasan->dibuat_pada ? $balasan->dibuat_pada->toIso8601String() : now()->toIso8601String() }}">
                            <div class="d-flex align-items-start">
                                <div class="author-avatar-siswa me-2">
                                    {{ strtoupper(substr($balasan->siswa->nama ?? 'U', 0, 2)) }}
                                </div>
                                <div class="komentar-body w-100">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="name fw-semibold">{{ $balasan->siswa->nama ?? 'User' }}</span>
                                            <p class="date text-muted small mb-1" id="comment-time-{{ $balasan->id }}">
                                                @php
                                                    $now = now();
                                                    $createdAt = $balasan->dibuat_pada ?? $now;
                                                    $diffInMonths = $now->diffInMonths($createdAt);
                                                    if ($diffInMonths >= 1) {
                                                        echo $createdAt->format('d-m-Y');
                                                    } else {
                                                        echo $createdAt->diffForHumans();
                                                    }
                                                @endphp
                                            </p>
                                        </div>
                                        <div class="comment-actions">
                                            @auth('siswa')
                                                <button class="btn btn-outline-secondary btn-sm btn-reply" data-id="{{ $balasan->id }}">
                                                    <i class="fas fa-reply"></i> Balas
                                                </button>
                                                @if ((Auth::guard('siswa')->check() && Auth::guard('siswa')->id() == $balasan->id_siswa) || Auth::guard('admin')->check())
                                                    <button class="btn btn-outline-danger btn-sm delete-comment" data-id="{{ $balasan->id }}">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                    <p class="komentar-text mb-2">{{ $balasan->komentar }}</p>

                                    @if ($balasan->replies->isNotEmpty())
                                        <button class="btn btn-link text-decoration-none text-muted p-0 lihat-balasan-btn" data-id="{{ $balasan->id }}">
                                            Lihat {{ $balasan->replies->count() }} balasan ▼
                                        </button>
                                        <div class="balasan-list mt-3 ms-4" id="balasan-{{ $balasan->id }}" style="display: none;">
                                            @foreach ($balasan->replies as $subBalasan)
                                                @include('partials.komentar', ['komentar' => $subBalasan, 'konten' => $konten])
                                            @endforeach
                                        </div>
                                    @endif

                                    @auth('siswa')
                                        <form action="{{ route('komentar.reply', ['id' => $konten->id, 'parentId' => $balasan->id]) }}"
                                              method="POST"
                                              class="reply-form mt-3"
                                              data-parent-id="{{ $balasan->id }}"
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
                    @endforeach
                </div>
            @endif

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