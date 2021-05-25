<?php

namespace App\Http\Livewire\Comment\Reply;

use App\Models\CommentReply;
use Livewire\Component;

class SingleReply extends Component
{
    public CommentReply $reply;

    public function mount($reply)
    {
        $this->reply = $reply;
    }

    public function deleteReply()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        if (auth()->user()->staff_mode or auth()->user()->id === $this->reply->user->id) {
            loggy(request(), 'Reply', auth()->user(), 'Deleted a reply | Reply ID: '.$this->reply->id);
            $this->reply->delete();
            $this->emit('refreshReplies');
            auth()->user()->touch();

            return toast($this, 'success', 'Reply has been deleted successfully!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.comment.reply.single-reply');
    }
}
