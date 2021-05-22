<?php

namespace App\Http\Livewire\Question;

use App\Gamify\Points\QuestionCreated;
use Livewire\Component;

class CreateQuestion extends Component
{
    public $title;
    public $body;
    public $solvable = true;
    public $patronOnly;

    public function submit()
    {
        if (auth()->check()) {
            $this->validate([
                'title' => ['required', 'min:5', 'max:100'], ['required', 'min:3', 'max:10000'],
            ]);

            if (! auth()->user()->hasVerifiedEmail()) {
                return toast($this, 'error', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return toast($this, 'error', 'Your account is flagged!');
            }

            $solvable = ! $this->solvable ? false : true;
            $patronOnly = ! $this->patronOnly ? false : true;

            $question = auth()->user()->questions()->create([
                'title' => $this->title, $this->body,
                'is_solvable' => $solvable,
                'patronOnly' => $patronOnly,
            ]);
            auth()->user()->touch();

            givePoint(new QuestionCreated($question));
            loggy(request(), 'Question', auth()->user(), 'Created a new question | Question ID: '.$question->id);

            return redirect()->route('question.question', ['id' => $question->id]);
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }
}
