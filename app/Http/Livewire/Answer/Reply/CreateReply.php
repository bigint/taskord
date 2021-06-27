<?php

namespace App\Http\Livewire\Answer\Reply;

use App\Models\Answer;
use App\Notifications\Answer\Reply\Replied;
use Helper;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreateReply extends Component
{
    public $reply = '';
    public Answer $answer;

    protected $rules = [
        'reply' => ['required', 'min:3', 'max:20000'],
        'answer' => ['required'],
    ];

    public function mount($answer)
    {
        $this->answer = $answer;
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

        $reply = auth()->user()->answerReplies()->create([
            'answer_id' => $this->answer->id,
            'reply' => $this->reply,
        ]);
        $this->emit('refreshReplies');
        $this->reset('reply');

        Helper::mentionUsers($users, $reply, auth()->user(), 'answer_reply');
        if (auth()->user()->id !== $this->answer->user->id) {
            $this->answer->user->notify(new Replied($reply));
        }

        loggy(request(), 'Reply', auth()->user(), "Created a new answer reply | Reply ID: {$reply->id}");

        return toast($this, 'success', 'Reply has been added!');
    }

    public function render(): View
    {
        return view('livewire.answer.reply.create-reply');
    }
}
