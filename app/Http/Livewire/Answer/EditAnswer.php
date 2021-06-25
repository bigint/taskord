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
        $answer = Answer::find($this->answerId);
        $answer->answer = $this->answer;
        $answer->save();
        $this->emit('answerEdited');

        loggy(request(), 'Answer', auth()->user(), "Edited a answer | Answer ID: {$this->answerId}");

        return toast($this, 'success', 'Answer has been edited!');
    }

    public function render()
    {
        return view('livewire.answer.create-answer');
    }
}
