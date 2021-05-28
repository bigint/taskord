<?php

namespace App\Http\Livewire\Question;

use App\Gamify\Points\QuestionCreated;
use Illuminate\Support\Facades\Gate;
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
        if (Gate::denies('create')) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        $this->validate([
            'title' => ['required', 'min:3', 'max:150'],
            'body' => ['required', 'min:3', 'max:20000'],
        ]);

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
