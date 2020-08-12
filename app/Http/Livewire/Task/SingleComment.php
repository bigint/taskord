<?php

namespace App\Http\Livewire\Task;

use App\Notifications\TaskCommentPraised;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->comment->user->id) {
                return session()->flash('error', 'You can\'t praise your own comment!');
            }
            if (Auth::user()->hasLiked($this->comment)) {
                Auth::user()->unlike($this->comment);
                $this->comment->refresh();
            } else {
                Auth::user()->like($this->comment);
                $this->comment->refresh();
                $this->comment->user->notify(new TaskCommentPraised($this->comment, Auth::id()));
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->comment->id;
    }

    public function deleteTaskComment()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::user()->staffShip or Auth::id() === $this->comment->user->id) {
                $this->comment->likes()->delete();
                $this->comment->delete();
                $this->emit('taskCommentDeleted');
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
