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
        if (auth()->check()) {
            if (auth()->user()->isFlagged) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your account is flagged!',
                ]);
            }
            if (auth()->user()->staffShip or auth()->user()->id === $this->reply->user->id) {
                loggy(request(), 'Reply', auth()->user(), 'Deleted a reply | Reply ID: '.$this->reply->id);
                $this->reply->delete();
                $this->emit('refreshReplies');
                auth()->user()->touch();

                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'success',
                    'body' => 'Reply has been deleted successfully!',
                ]);
            } else {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.comment.reply.single-reply');
    }
}
