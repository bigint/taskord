<?php

namespace App\Http\Livewire\Comment;

use App\Models\Comment;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
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

        if (Gate::denies('praise', $this->comment)) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        Helper::togglePraise($this->comment, 'COMMENT');

        return loggy(request(), 'Comment', auth()->user(), 'Toggled comment praise | Comment ID: '.$this->comment->id);
    }

    public function toggleCommentBox()
    {
        $this->showReplyBox = ! $this->showReplyBox;
    }

    public function hide()
    {
        if (Gate::denies('staff_mode')) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        Helper::hide($this->comment);
        loggy(request(), 'Staff', auth()->user(), 'Toggled hide comment | Comment ID: '.$this->comment->id);

        return toast($this, 'success', 'Comment is hidden from public!');
    }

    public function deleteComment()
    {
        if (Gate::denies('act', $this->comment)) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        loggy(request(), 'Comment', auth()->user(), 'Deleted a comment | Comment ID: '.$this->comment->id);
        $this->comment->delete();
        $this->emit('refreshComments');
        auth()->user()->touch();

        return toast($this, 'success', 'Comment has been deleted successfully!');
    }
}
