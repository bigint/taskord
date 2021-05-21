<?php

namespace App\Http\Livewire\Notification\Type\Comment\Reply;

use App\Models\CommentReply;
use Livewire\Component;

class Replied extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        $reply = CommentReply::find($this->data['reply_id']);

        return view('livewire.notification.type.comment.reply.replied', [
            'reply' => $reply,
        ]);
    }
}
