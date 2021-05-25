<?php

namespace App\Http\Livewire\Comment;

use App\Models\Comment;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleComment extends Component
{
    public Comment $comment;
    public $showReplyBox = false;

    public function mount($comment)
    {
        $this->comment = $comment;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 30, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while praising the comment');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }

        if (auth()->user()->isFlagged) {
            return toast($this, 'error', 'Your account is flagged!');
        }
        if (auth()->user()->id === $this->comment->user->id) {
            return toast($this, 'error', 'You can\'t praise your own comment!');
        }
        Helper::togglePraise($this->comment, 'COMMENT');
        loggy(request(), 'Comment', auth()->user(), 'Toggled comment praise | Comment ID: '.$this->comment->id);
    }

    public function toggleCommentBox()
    {
        $this->showReplyBox = ! $this->showReplyBox;
    }

    public function hide()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (auth()->user()->isStaff and auth()->user()->staffShip) {
            Helper::hide($this->comment);
            loggy(request(), 'Staff', auth()->user(), 'Toggled hide comment | Comment ID: '.$this->comment->id);

            return toast($this, 'success', 'Comment is hidden from public!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function deleteComment()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (auth()->user()->isFlagged) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        if (auth()->user()->staffShip or auth()->user()->id === $this->comment->user->id) {
            loggy(request(), 'Comment', auth()->user(), 'Deleted a comment | Comment ID: '.$this->comment->id);
            $this->comment->delete();
            $this->emit('refreshComments');
            auth()->user()->touch();

            return toast($this, 'success', 'Comment has been deleted successfully!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }
}
