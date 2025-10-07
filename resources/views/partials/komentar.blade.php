{{-- Ganti seluruh isi file ini dengan kode di bawah --}}
<div class="komentar-item" id="komentar-{{ $komentar->id }}" data-id="{{ $komentar->id }}">
<div class="komentar-item mb-4" id="komentar-{{ $komentar->id }}" data-id="{{ $komentar->id }}">
    <div class="d-flex align-items-start">
        <div class="author-avatar-siswa flex-shrink-0 me-3">
            {{ strtoupper(substr($komentar->siswa->nama ?? ($komentar->admin->nama ?? 'U'), 0, 2)) }}
        </div>
        <div class="komentar-body w-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="name">
                        {{ $komentar->siswa->nama ?? ($komentar->admin->nama ?? 'Pengguna') }}
                        @if ($komentar->admin)
                            <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill ms-1" style="font-size: 0.7rem;">Admin</span>
                        @endif
                    </span>
                    <p class="date">
                        {{ $komentar->created_at ? $komentar->created_at->diffForHumans() : 'Beberapa waktu lalu' }}
                    </p>
                </div>
                {{-- Tombol aksi dipindahkan ke sini --}}
                <div class="comment-actions">
                    @auth('siswa')
                        <button class="btn btn-outline-secondary btn-sm btn-reply" data-id="{{ $komentar->id }}" title="Balas komentar">
                            <i class="fas fa-reply"></i> Balas
                        </button>
                        @if ((Auth::guard('siswa')->check() && Auth::guard('siswa')->id() == $komentar->id_siswa) || Auth::guard('admin')->check() || Auth::guard('web')->check())
                            <button class="btn btn-outline-danger btn-sm delete-comment" data-id="{{ $komentar->id }}" title="Hapus komentar">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        @endif
                    @endauth
                </div>
            </div>

            <p class="komentar-text mt-2">{{ $komentar->komentar }}</p>

            @auth('siswa')
                <form action="{{ route('komentar.reply', ['id' => $konten->id, 'parentId' => $komentar->id]) }}"
                    method="POST"
                    class="reply-form"
                    data-parent-id="{{ $komentar->id }}"
                    style="display: none;">
            <p class="meta mb-1">
                <strong>
                    {{ $komentar->siswa->nama ?? ($komentar->admin->nama ?? 'Pengguna') }}
                    @if ($komentar->admin)
                        <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill ms-1" style="font-size: 0.7rem;">Admin</span>
                    @endif
                </strong>
                <span class="text-muted ms-2" style="font-size: 0.8rem;">
                    {{ $komentar->created_at ? $komentar->created_at->diffForHumans() : 'Beberapa waktu lalu' }}
                </span>
            </p>
            <p class="mb-1">{{ $komentar->komentar }}</p>

            <div class="comment-actions mt-2">
                @auth('siswa')
                    <button class="btn btn-outline-secondary btn-sm btn-reply" data-id="{{ $komentar->id }}">
                        <i class="fas fa-reply"></i> Balas
                    </button>
                    @if (Auth::guard('siswa')->id() == $komentar->id_siswa || Auth::guard('admin')->check() || Auth::guard('web')->check())
                        <button class="btn btn-outline-secondary btn-sm delete-comment" data-id="{{ $komentar->id }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    @endif
                @endauth
            </div>

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

    @if($komentar->replies->isNotEmpty())
        <div class="komentar-replies">
            @foreach($komentar->replies as $balasan)
                @include('partials.komentar', ['komentar' => $balasan, 'konten' => $konten])
            @endforeach
        </div>
    @endif
</div>