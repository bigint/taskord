<?php

namespace App\Http\Livewire\Task;

use App\Gamify\Points\PraiseCreated;
use App\Notifications\CommentPraised;
use App\Notifications\TelegramLogger;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleComment extends Component
{
    public $comment;
    public $confirming;

    public function mount($comment)
    {
        $this->comment = $comment;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return session()->flash('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->comment->user->id) {
                return session()->flash('error', 'You can\'t praise your own comment!');
            }
            if (Auth::user()->hasLiked($this->comment)) {
                Auth::user()->unlike($this->comment);
                $this->comment->refresh();
                undoPoint(new PraiseCreated($this->comment));
                Auth::user()->touch();
                $this->comment->user->notify(
                    new TelegramLogger(
                        '*👏 Comment was un-praised* by @'
                        .Auth::user()->username."\n\n"
                        .$this->comment->comment."\n\nhttps://taskord.com/task/"
                        .$this->comment->task->id
                    )
                );
            } else {
                Auth::user()->like($this->comment);
                $this->comment->refresh();
                $this->comment->user->notify(new CommentPraised($this->comment, Auth::id()));
                givePoint(new PraiseCreated($this->comment));
                Auth::user()->touch();
                $this->comment->user->notify(
                    new TelegramLogger(
                        '*👏 Comment was praised* by @'
                        .Auth::user()->username."\n\n"
                        .$this->comment->comment."\n\nhttps://taskord.com/task/"
                        .$this->comment->task->id
                    )
                );
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->comment->id;
    }

    public function deleteComment()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::user()->staffShip or Auth::id() === $this->comment->user->id) {
                $this->comment->delete();
                $this->emit('commentDeleted');
                Auth::user()->touch();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.task.single-comment');
    }
}
