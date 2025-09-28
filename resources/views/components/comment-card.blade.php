<div class="comment-card mb-3" id="comment_{{ $comment->id }}" style="margin-left: {{ $depth * 20 }}px;">
    <div class="comment-header">
        <div class="comment-author">
            <div class="author-avatar">
                {{ $comment->siswa ? strtoupper(substr($comment->siswa->nama, 0, 2)) : ($comment->admin ? 'AD' : 'AN') }}
            </div>
            <div class="author-info">
                <div class="author-name">
                    {{ $comment->siswa ? $comment->siswa->nama : ($comment->admin ? 'Admin' : 'Anonim') }}
                </div>
                <div class="comment-date">
                    {{ $comment->dibuat_pada ? $comment->dibuat_pada->format('d M Y H:i') : 'N/A' }}
                </div>
            </div>
        </div>
        @if (Auth::guard('admin')->check())
            <div class="comment-actions">
                <button class="btn btn-sm btn-outline-primary me-2" onclick="editComment({{ $comment->id }})">
                    <i class="fas fa-edit"></i>
                </button>
                <form action="{{ route('admin.komentar.destroy', $comment->id) }}" method="POST"
                    style="display:inline;" id="deleteCommentForm_{{ $comment->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="confirmDeleteComment({{ $comment->id }})">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        @endif
        @if ((Auth::guard('admin')->check() || Auth::guard('siswa')->check()) && $comment->depth < 2)
            <button class="btn btn-sm btn-outline-secondary mt-2" onclick="showReplyForm({{ $comment->id }})">
                <i class="fas fa-reply me-1"></i>Balas
            </button>
        @endif
    </div>
    <div class="comment-body" id="commentBody_{{ $comment->id }}">
        {{ $comment->komentar }}
    </div>
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
    <div class="comment-reply-form d-none" id="replyForm_{{ $comment->id }}"
        style="margin-left: {{ ($depth + 1) * 20 }}px;">
        <form
            action="{{ Auth::guard('siswa')->check() ? route('artikel-siswa.komentar.store', $artikel->id) : route('admin.komentar.store', $artikel->id) }}"
            method="POST">
            @csrf
            <input type="hidden" name="id_komentar_parent" value="{{ $comment->id }}">
            <input type="hidden" name="depth" value="{{ $comment->depth + 1 }}">
            <textarea name="komentar" class="form-control mb-2 @error('komentar') is-invalid @enderror" rows="3"
                placeholder="Tulis balasan Anda..." required>{{ old('komentar') }}</textarea>
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
    @if ($comment->replies->isNotEmpty())
        @foreach ($comment->replies as $reply)
            <x-comment-card :comment="$reply" :depth="$depth + 1" :artikel="$artikel" />
        @endforeach
    @endif
</div>
