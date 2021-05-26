<?php

namespace App\Http\Livewire\Question;

use App\Gamify\Points\QuestionCreated;
use Livewire\Component;

class CreateQuestion extends Component
{
    public $title;
    public $body;
    public $selectedTags;
    public $solvable = true;
    public $patronOnly;

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

        $this->validate([
            'title' => ['required', 'min:3', 'max:150'],
            'body' => ['required', 'min:3', 'max:20000'],
        ]);

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        $solvable = ! $this->solvable ? false : true;
        $patronOnly = ! $this->patronOnly ? false : true;

        $question = auth()->user()->questions()->create([
            'title' => $this->title,
            'body' => $this->body,
            'is_solvable' => $solvable,
            'patron_only' => $patronOnly,
        ]);

        $question->retag($this->selectedTags);
        auth()->user()->touch();

        givePoint(new QuestionCreated($question));
        loggy(request(), 'Question', auth()->user(), 'Created a new question | Question ID: '.$question->id);

        return redirect()->route('question.question', ['id' => $question->id]);
    }
}
