{{-- File: resources/views/partials/komentar.blade.php --}}

<div class="komentar-item mb-4" id="komentar-{{ $komentar->id }}" data-id="{{ $komentar->id }}">
    <div class="d-flex align-items-start">
        <div class="author-avatar-siswa flex-shrink-0 me-3">
            {{ strtoupper(substr($komentar->siswa->nama ?? ($komentar->admin->nama ?? 'U'), 0, 2)) }}
        </div>
        <div class="komentar-body w-100">
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

            {{-- Tombol dan Form Balasan ditempatkan di sini --}}
            @auth('siswa')
                <div class="comment-actions mt-2">
                    <button class="btn btn-outline-secondary btn-sm btn-reply" data-id="{{ $komentar->id }}">
                        <i class="fas fa-reply"></i> Balas
                    </button>
                </div>

                {{-- PERBAIKAN: Form ini sekarang menggunakan route 'komentar.reply' yang benar --}}
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

    {{-- Kode untuk menampilkan balasan dari balasan (rekursif) --}}
    @if($komentar->replies->isNotEmpty())
        <div class="komentar-replies" style="margin-left: 50px; margin-top: 1rem; border-left: 2px solid #e9ecef; padding-left: 15px;">
            @foreach($komentar->replies as $balasan)
                @include('partials.komentar', ['komentar' => $balasan, 'konten' => $konten])
            @endforeach
        </div>
    @endif
</div>  

{{-- Tambahkan skrip JavaScript untuk menangani tombol balas --}}