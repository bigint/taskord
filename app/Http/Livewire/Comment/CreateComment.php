<?php

namespace App\Http\Livewire\Comment;

use App\Gamify\Points\CommentCreated;
use App\Models\Task;
use App\Notifications\Comment\Commented;
use Helper;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreateComment extends Component
{
    public $comment = '';
    public Task $task;

    protected $rules = [
        'comment' => ['required', 'min:3', 'max:20000'],
        'task' => ['required'],
    ];

    public function mount($task)
    {
        $this->task = $task;
    }

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate();

        $users = Helper::getUsernamesFromMentions($this->comment);

        if ($users) {
            $this->comment = Helper::parseUserMentionsToMarkdownLinks($this->comment, $users);
        }

        $comment = auth()->user()->comments()->create([
            'task_id' => $this->task->id,
            'comment' => $this->comment,
        ]);
        $this->emit('refreshComments');

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
        loggy(request(), 'Comment', auth()->user(), "Created a new comment | Comment ID: {$comment->id}");

        return toast($this, 'success', 'Comment has been added!');
    }

    public function render(): View
    {
        return view('livewire.comment.create-comment');
    }
}
