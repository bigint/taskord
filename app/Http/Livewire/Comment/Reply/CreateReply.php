<?php

namespace App\Http\Livewire\Comment\Reply;

use App\Models\Comment;
use App\Notifications\Comment\Reply\Replied;
use Helper;
use Livewire\Component;

class CreateReply extends Component
{
    public $reply;
    public Comment $comment;

    protected $rules = [
        'reply' => ['required', 'max:20000'],
    ];

    public function mount($comment)
    {
        $this->comment = $comment;
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

        $reply = auth()->user()->comment_replies()->create([
            'comment_id' =>  $this->comment->id,
            'reply' => $this->reply,
        ]);
        auth()->user()->touch();
        $this->emit('refreshReplies');
        $this->reset('reply');

        $users = Helper::getUsernamesFromMentions($this->reply);

        if ($users) {
            $this->reply = Helper::parseUserMentionsToMarkdownLinks($this->reply, $users);
        }

        Helper::mentionUsers($users, $reply, auth()->user(), 'comment_reply');
        if (auth()->user()->id !== $this->comment->user->id) {
            $this->comment->user->notify(new Replied($reply));
        }

        loggy(request(), 'Reply', auth()->user(), 'Created a new comment reply | Reply ID: '.$reply->id);

        return toast($this, 'success', 'Reply has been added!');
    }

    public function render()
    {
        return view('livewire.comment.reply.create-reply');
    }
}
