<div class="comment-card" id="comment_{{ $comment->id }}" style="margin-left: {{ $depth * 20 }}px;">
    <div class="comment-header d-flex align-items-center justify-content-between">
        <div class="comment-author d-flex align-items-center">
            <div class="author-avatar">
                {{ $comment->siswa ? strtoupper(substr($comment->siswa->nama, 0, 2)) : 'AD' }}
            </div>
            <div class="author-info">
                <div class="author-name">
                    {{ $comment->siswa ? $comment->siswa->nama : 'Admin' }}
                </div>
                <div class="author-role">
                    {{ $comment->siswa ? $comment->siswa->kelas : 'Administrator' }}
                </div>
            </div>
        </div>
        <div class="comment-meta">
            <small>{{ $comment->dibuat_pada->format('d M Y H:i') }}</small>
        </div>
    </div>
    <div class="comment-body" id="commentBody_{{ $comment->id }}">
        <p class="mb-0">{{ $comment->komentar }}</p>
    </div>
    @if (Auth::guard('admin')->check())
        <div class="comment-edit-form d-none" id="editCommentForm_{{ $comment->id }}">
            <form action="{{ route('admin.komentar.update', $comment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <textarea name="komentar" class="form-control mb-2 @error('komentar') is-invalid @enderror" rows="3" required>{{ old('komentar', $comment->komentar) }}</textarea>
                @error('komentar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-primary-custom btn-sm">
                    <i class="fas fa-save me-1"></i>Simpan
                </button>
                <button type="button" class="btn btn-secondary btn-sm" onclick="cancelEditComment({{ $comment->id }})">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
            </form>
        </div>
    @endif
    <div class="comment-actions mt-2">
        @if ($comment->depth < 2 && (Auth::guard('admin')->check() || Auth::guard('siswa')->check()))
            <button class="btn btn-outline-custom btn-sm" onclick="showReplyForm({{ $comment->id }})">
                <i class="fas fa-reply me-1"></i>Balas
            </button>
        @endif
        @if (Auth::guard('admin')->check())
            <button class="btn btn-outline-custom btn-sm" onclick="editComment({{ $comment->id }})">
                <i class="fas fa-edit me-1"></i>Edit
            </button>
            <form action="{{ route('admin.komentar.destroy', $comment->id) }}" method="POST" style="display:inline;" id="deleteCommentForm_{{ $comment->id }}">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger-custom btn-sm no-loading" onclick="confirmDeleteComment({{ $comment->id }})">
                    <i class="fas fa-trash me-1"></i>Hapus
                </button>
            </form>
        @endif
    </div>
    <div class="comment-reply-form d-none" id="replyForm_{{ $comment->id }}" style="margin-left: {{ ($depth + 1) * 20 }}px;">
        <form action="{{ Auth::guard('siswa')->check() ? route('artikel-siswa.komentar.store', $artikel->id) : route('admin.komentar.store', $artikel->id) }}" method="POST">
            @csrf
            <input type="hidden" name="id_komentar_parent" value="{{ $comment->id }}">
            <input type="hidden" name="depth" value="{{ $comment->depth + 1 }}">
            <textarea name="komentar" class="form-control mb-2 @error('komentar') is-invalid @enderror" rows="3" placeholder="Tulis balasan Anda..." required>{{ old('komentar') }}</textarea>
            @error('komentar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-primary-custom btn-sm">
                <i class="fas fa-comment me-1"></i>Kirim Balasan
            </button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="hideReplyForm({{ $comment->id }})">
                <i class="fas fa-times me-1"></i>Batal
            </button>
        </form>
    </div>
    @foreach ($comment->replies as $reply)
        <x-comment-card :comment="$reply" :depth="$depth + 1" :artikel="$artikel" />
    @endforeach
</div>