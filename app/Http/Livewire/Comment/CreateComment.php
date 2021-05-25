<?php

namespace App\Http\Livewire\Comment;

use App\Gamify\Points\CommentCreated;
use App\Models\Task;
use App\Notifications\Comment\Commented;
use Helper;
use Livewire\Component;

class CreateComment extends Component
{
    public $comment;
    public Task $task;

    protected $rules = [
        'comment' => ['required', 'max:20000'],
    ];

    public function mount($task)
    {
        $this->task = $task;
    }

    public function updated($field)
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        $this->validateOnly($field);
    }

    public function submit()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        $this->validate();

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        $comment = auth()->user()->comments()->create([
            'task_id' =>  $this->task->id,
            'comment' => $this->comment,
        ]);
        auth()->user()->touch();
        $this->emit('refreshComments');

        $users = Helper::getUsernamesFromMentions($this->comment);

        if ($users) {
            $this->comment = Helper::parseUserMentionsToMarkdownLinks($this->comment, $users);
        }

        $this->reset('comment');
        Helper::mentionUsers($users, $comment, auth()->user(), 'comment');
        Helper::notifySubscribers($comment->task->subscribers, $comment, 'comment');
        if (auth()->user()->id !== $this->task->user->id) {
            if (! auth()->user()->hasSubscribed($comment->task)) {
                auth()->user()->subscribe($comment->task);
                $this->emit('refreshTaskSubscribed');
            }
            $this->task->user->notify(new Commented($comment));
            givePoint(new CommentCreated($comment));
        }
        loggy(request(), 'Comment', auth()->user(), 'Created a new comment | Comment ID: '.$comment->id);

        return toast($this, 'success', 'Comment has been added!');
    }

    public function render()
    {
        return view('livewire.comment.create-comment');
    }
}
