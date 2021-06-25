<?php

namespace App\Http\Livewire\Answer;

use App\Models\Answer;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EditAnswer extends Component
{
    public $answer;
    public $answerId;

    protected $rules = [
        'answer' => ['required', 'min:3', 'max:20000'],
    ];

    public function mount($answer)
    {
        $this->answer = $answer->answer;
        $this->answerId = $answer->id;
    }

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate();
        $comment = Comment::find($this->commentId);
        $comment->comment = $this->comment;
        $comment->save();
        $this->emit('commentEdited');

        loggy(request(), 'Comment', auth()->user(), "Edited a comment | Comment ID: {$this->commentId}");

        return toast($this, 'success', 'Comment has been edited!');
    }

    public function render()
    {
        return view('livewire.comment.create-comment');
    }
}
