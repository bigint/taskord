<?php

namespace App\Http\Livewire\Notification\Type\Comment\Reply;

use App\Models\CommentReply;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ReplyLiked extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render(): View
    {
        $reply = CommentReply::find($this->data['reply_id']);

        return view('livewire.notification.type.comment.reply.reply-liked', [
            'reply' => $reply,
        ]);
    }
}
