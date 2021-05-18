<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Livewire\Component;

class EditQuestion extends Component
{
    public Question $question;
    public $title;
    public $body;
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
        $this->patronOnly = $question->patronOnly;
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

            $question = Question::where('id', $this->question->id)->firstOrFail();

            $patronOnly = ! $this->patronOnly ? false : true;

            if (auth()->user()->staffShip or auth()->user()->id === $question->user_id) {
                $question->title = $this->title;
                $question->body = $this->body;
                $question->patronOnly = $this->patronOnly;
                $question->save();
                auth()->user()->touch();

                loggy(request(), 'Question', auth()->user(), 'Updated a question | Question ID: '.$question->id);

                return redirect()->route('question.question', ['id' => $question->id]);
            } else {
                $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }
}
