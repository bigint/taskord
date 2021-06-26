<?php

namespace App\Http\Livewire\Notification\Type\Comment;

use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Commented extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render(): View
    {
        $comment = Comment::find($this->data['comment_id']);

        return view('livewire.notification.type.comment.commented', [
            'comment' => $comment,
        ]);
    }
}
