<?php

namespace App\Http\Livewire\Comment;

use App\Models\Comment;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Helper;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SingleComment extends Component
{
    use WithRateLimiting;

    public Comment $comment;
    public $showReplyBox = false;

    public function mount($comment)
    {
        $this->comment = $comment;
    }

    public function toggleLike()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('like/subscribe', $this->comment)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        Helper::toggleLike($this->comment, 'COMMENT');
        $this->emit('commentLiked');

        return loggy(request(), 'Comment', auth()->user(), "Toggled comment like | Comment ID: {$this->comment->id}");
    }

    public function toggleCommentBox()
    {
        $this->showReplyBox = ! $this->showReplyBox;
    }

    public function hide()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        Helper::hide($this->comment);
        $this->emit('commentHidden');
        loggy(request(), 'Staff', auth()->user(), "Toggled hide comment | Comment ID: {$this->comment->id}");

        return toast($this, 'success', 'Comment is hidden from public!');
    }

    public function deleteComment()
    {
        if (Gate::denies('edit/delete', $this->comment)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        loggy(request(), 'Comment', auth()->user(), "Deleted a comment | Comment ID: {$this->comment->id}");
        $this->comment->delete();
        $this->emit('refreshComments');

        return toast($this, 'success', 'Comment has been deleted successfully!');
    }
}
