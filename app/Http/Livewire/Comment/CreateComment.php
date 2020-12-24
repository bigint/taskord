<?php

namespace App\Http\Livewire\Comment;

use App\Gamify\Points\CommentCreated;
use App\Models\Comment;
use App\Models\Task;
use App\Notifications\Commented;
use Helper;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateComment extends Component
{
    public $comment;
    public Task $task;

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
            $this->alert('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'comment' => 'required',
            ]);

            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
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
            Helper::notifySubscribers($comment->task->subscribers, $comment, 'comment');
            if (! Auth::user()->hasSubscribed($comment->task)) {
                Auth::user()->subscribe($comment->task);
                $this->emit('taskSubscribed');
            }
            if (Auth::id() !== $this->task->user->id) {
                $this->task->user->notify(new Commented($comment));
                givePoint(new CommentCreated($comment));
            }
            activity()
                ->withProperties(['type' => 'Comment'])
                ->log('New comment has been created T: '.$this->task->user->id.' C: '.$comment->id);

            return $this->alert('success', 'Comment has been added!');
        } else {
            $this->alert('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.comment.create-comment');
    }
}
