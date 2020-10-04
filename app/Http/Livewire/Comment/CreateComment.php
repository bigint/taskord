<?php

namespace App\Http\Livewire\Comment;

use App\Gamify\Points\CommentCreated;
use App\Models\Comment;
use App\Notifications\Commented;
use App\Notifications\TelegramLogger;
use Helper;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateComment extends Component
{
    public $comment;
    public $task;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'comment' => 'required',
            ]);
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'comment' => 'required',
            ]);

            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            $users = Helper::getUserIDFromMention($this->comment);

            $comment = Comment::create([
                'user_id' =>  Auth::id(),
                'task_id' =>  $this->task->id,
                'comment' => $this->comment,
            ]);
            Auth::user()->touch();

            $this->emit('commentAdded');
            $this->comment = '';
            Helper::mentionUsers($users, $comment, 'comment');
            if (Auth::id() !== $this->task->user->id) {
                $this->task->user->notify(new Commented($comment));
                givePoint(new CommentCreated($comment));
            }

            return session()->flash('success', 'Comment has been added!');
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.comment.create-comment');
    }
}
