<?php

namespace App\Http\Livewire\Question;

use App\Gamify\Points\QuestionCreated;
use Livewire\Component;

class CreateQuestion extends Component
{
    public $title;
    public $body;
    public $patronOnly;

    public function submit()
    {
        if (auth()->check()) {
            $this->validate([
                'title' => ['required', 'min:5', 'max:100'],
                'body' => ['required', 'min:3', 'max:10000'],
            ]);

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

            $patronOnly = ! $this->patronOnly ? false : true;

            $question = auth()->user()->questions()->create([
                'title' => $this->title,
                'body' => $this->body,
                'patronOnly' => $patronOnly,
            ]);
            auth()->user()->touch();

            givePoint(new QuestionCreated($question));
            loggy(request(), 'Question', auth()->user(), 'Created a new question | Question ID: '.$question->id);

            return redirect()->route('question.question', ['id' => $question->id]);
        } else {
            $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }
}
