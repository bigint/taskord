<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Livewire\Component;

class EditQuestion extends Component
{
    public Question $question;
    public $title;
    public $body;
    public $selectedTags;
    public $solvable;
    public $patronOnly;

    protected $rules = [
        'title' => ['required', 'min:5', 'max:150'],
        'body' => ['required', 'min:3', 'max:20000'],
    ];

    public function mount($question)
    {
        $this->question = $question;
        $this->title = $question->title;
        $this->body = $question->body;
        $this->selectedTags = $question->tagNames();
        $this->solvable = $question->is_solvable;
        $this->patronOnly = $question->patron_only;
    }

    public function updated($field)
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        $this->validateOnly($field);
    }

    public function updatedSelectedTags()
    {
        if (count($this->selectedTags) > 5) {
            $this->addError('tags', 'Only 5 tags are allowed!');
        }
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
        $patronOnly = ! $this->patronOnly ? false : true;

        if (auth()->user()->staff_mode or auth()->user()->id === $question->user_id) {
            $question->title = $this->title;
            $question->body = $this->body;
            $question->is_solvable = $solvable;
            $question->patron_only = $patronOnly;
            $question->save();
            $question->retag($this->selectedTags);
            auth()->user()->touch();

            loggy(request(), 'Question', auth()->user(), 'Updated a question | Question ID: '.$question->id);

            return redirect()->route('question.question', ['id' => $question->id]);
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }
}
