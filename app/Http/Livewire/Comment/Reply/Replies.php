<?php

namespace App\Http\Livewire\Comment\Reply;

use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Replies extends Component
{
    public $listeners = [
        'refreshReplies' => 'render',
    ];

    public Comment $comment;

    public function getReplies()
    {
        return $this->comment->replies()
            ->with(['user'])
            ->whereHas('user', function ($q) {
                $q->where([
                    ['spammy', false],
                ]);
            })
            ->get();
    }

    public function render(): View
    {
        return view('livewire.comment.reply.replies', [
            'replies' => $this->getReplies(),
        ]);
    }
}
