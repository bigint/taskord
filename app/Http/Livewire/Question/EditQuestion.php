<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Illuminate\Support\Facades\Gate;
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
        'title' => ['required', 'min:3', 'max:150'],
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
        $this->validate();

        if (Gate::denies('edit/delete', $this->question)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        $question = Question::where('id', $this->question->id)->firstOrFail();

        $solvable = ! $this->solvable ? false : true;
        $patronOnly = ! $this->patronOnly ? false : true;

        $question->title = $this->title;
        $question->body = $this->body;
        $question->is_solvable = $solvable;
        $question->patron_only = $patronOnly;
        $question->save();
        $question->retag($this->selectedTags);
        auth()->user()->touch();
        $this->emit('refreshQuestion');

        loggy(request(), 'Question', auth()->user(), "Updated a question | Question ID: {$question->id}");

        return redirect()->route('question.question', ['id' => $question->id]);
    }
}
