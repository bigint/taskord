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
        if (auth()->check()) {
            $this->validateOnly($field);
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (auth()->check()) {
            $this->validate();

            if (! auth()->user()->hasVerifiedEmail()) {
                return toast($this, 'error', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return toast($this, 'error', 'Your account is flagged!');
            }

            $users = Helper::getUsernamesFromMentions($this->reply);

            if ($users) {
                $this->reply = Helper::parseUserMentionsToMarkdownLinks($this->reply, $users);
            }

            $reply = auth()->user()->comment_replies()->create([
                'comment_id' =>  $this->comment->id,
                'reply' => $this->reply,
            ]);
            auth()->user()->touch();

            $this->emit('refreshReplies');
            $this->reset('reply');

            Helper::mentionUsers($users, $reply, auth()->user(), 'comment_reply');
            if (auth()->user()->id !== $this->comment->user->id) {
                $this->comment->user->notify(new Replied($reply));
            }

            loggy(request(), 'Reply', auth()->user(), 'Created a new comment reply | Reply ID: '.$reply->id);

            return toast($this, 'success', 'Reply has been added!');
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.comment.reply.create-reply');
    }
}
