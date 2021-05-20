<?php

namespace App\Http\Livewire\Comment\Reply;

use App\Models\Comment;
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
            $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function submit()
    {
        if (auth()->check()) {
            $this->validate();

            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your email is not verified!',
                ]);
            }

            if (auth()->user()->isFlagged) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your account is flagged!',
                ]);
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
            // TODO: Notify the comment user

            return $this->dispatchBrowserEvent('toast', [
                'type' => 'success',
                'body' => 'Reply has been added!',
            ]);
        } else {
            $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.comment.reply.create-reply');
    }
}
