<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Livewire\Component;

class EditQuestion extends Component
{
    public Question $question;
    public $title;
    public $body;
    public $solvable;
    public $patron_only;

    protected $rules = [
        'title' => ['required', 'min:5', 'max:150'],
        'body' => ['required', 'min:3', 'max:20000'],
    ];

    public function mount($question)
    {
        $this->question = $question;
        $this->title = $question->title;
        $this->body = $question->body;
        $this->solvable = $question->is_solvable;
        $this->patron_only = $question->patron_only;
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

        $question = Question::where('id', $this->question->id)->firstOrFail();

        $solvable = ! $this->solvable ? false : true;
        $patron_only = ! $this->patron_only ? false : true;

        if (auth()->user()->staff_mode or auth()->user()->id === $question->user_id) {
            $question->title = $this->title;
            $question->body = $this->body;
            $question->is_solvable = $this->solvable;
            $question->patron_only = $this->patron_only;
            $question->save();
            auth()->user()->touch();

            loggy(request(), 'Question', auth()->user(), 'Updated a question | Question ID: '.$question->id);

            return redirect()->route('question.question', ['id' => $question->id]);
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }
}
