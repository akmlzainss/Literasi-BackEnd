<?php

namespace App\View\Components;

use App\Models\KomentarArtikel;
use Illuminate\View\Component;
use Illuminate\View\View;

class CommentCard extends Component
{
    public $comment;
    public $depth;
    public $artikel;

    public function __construct(KomentarArtikel $comment, int $depth, $artikel)
    {
        $this->comment = $comment;
        $this->depth = $depth;
        $this->artikel = $artikel;
    }

    public function render(): View
    {
        return view('components.comment-card');
    }
}