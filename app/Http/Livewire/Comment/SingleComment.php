<?php

namespace App\Http\Livewire\Comment;

use App\Models\Comment;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleComment extends Component
{
    public Comment $comment;
    public $confirming;

    public function mount($comment)
    {
        $this->comment = $comment;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while praising the comment');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (! user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->comment->user->id) {
                return $this->alert('warning', 'You can\'t praise your own comment!');
            }
            Helper::togglePraise($this->comment, 'COMMENT');
            activity()
                ->withProperties(['type' => 'Comment'])
                ->log('Toggled comment praise | Comment ID: '.$this->comment->id);
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function hide()
    {
        if (Auth::check()) {
            if (user()->isStaff and user()->staffShip) {
                Helper::hide($this->comment);
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Toggled hide comment | Comment ID: '.$this->comment->id);

                return $this->alert('success', 'Comment is hidden from public!');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->comment->id;
    }

    public function deleteComment()
    {
        if (Auth::check()) {
            if (user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }
            if (user()->staffShip or Auth::id() === $this->comment->user->id) {
                activity()
                    ->withProperties(['type' => 'Comment'])
                    ->log('Deleted a comment | Comment ID: '.$this->comment->id);
                $this->comment->delete();
                $this->emit('commentDeleted');
                user()->touch();

                return $this->alert('success', 'Comment has been deleted successfully!');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
