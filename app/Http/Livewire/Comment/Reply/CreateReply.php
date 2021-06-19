<?php

namespace App\Http\Livewire\Comment\Reply;

use App\Models\Comment;
use App\Notifications\Comment\Reply\Replied;
use Helper;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreateReply extends Component
{
    public $reply = '';
    public Comment $comment;

    protected $rules = [
        'reply' => ['required', 'min:3', 'max:20000'],
        'comment' => ['required'],
    ];

    public function mount($comment)
    {
        $this->comment = $comment;
    }

    public function updated($field)
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validateOnly($field);
    }

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate();

        $users = Helper::getUsernamesFromMentions($this->reply);

        if ($users) {
            $this->reply = Helper::parseUserMentionsToMarkdownLinks($this->reply, $users);
        }

        $reply = auth()->user()->commentReplies()->create([
            'comment_id' => $this->comment->id,
            'reply' => $this->reply,
        ]);
        $this->emit('refreshReplies');
        $this->reset('reply');

        Helper::mentionUsers($users, $reply, auth()->user(), 'comment_reply');
        if (auth()->user()->id !== $this->comment->user->id) {
            $this->comment->user->notify(new Replied($reply));
        }

        loggy(request(), 'Reply', auth()->user(), "Created a new comment reply | Reply ID: {$reply->id}");

        return toast($this, 'success', 'Reply has been added!');
    }

    public function render()
    {
        return view('livewire.comment.reply.create-reply');
    }
}
