<?php

namespace App\Http\Livewire\Answer\Reply;

use App\Models\Answer;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Replies extends Component
{
    public $listeners = [
        'refreshReplies' => 'render',
    ];

    public Answer $answer;

    public function getReplies()
    {
        return $this->answer->replies()
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
        return view('livewire.answer.reply.replies', [
            'replies' => $this->getReplies(),
        ]);
    }
}
