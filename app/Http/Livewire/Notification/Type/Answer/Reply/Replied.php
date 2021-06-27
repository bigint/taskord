<?php

namespace App\Http\Livewire\Notification\Type\Answer\Reply;

use App\Models\AnswerReply;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Replied extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render(): View
    {
        $reply = AnswerReply::find($this->data['reply_id']);

        return view('livewire.notification.type.answer.reply.replied', [
            'reply' => $reply,
        ]);
    }
}
