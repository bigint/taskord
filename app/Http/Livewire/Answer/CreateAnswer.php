<?php

namespace App\Http\Livewire\Answer;

use App\Answer;
use App\Gamify\Points\CommentCreated;
use App\Notifications\Answered;
use Auth;
use Livewire\Component;

class CreateAnswer extends Component
{
    public $answer;
    public $question;

    public function mount($question)
    {
        $this->question = $question;
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'answer' => 'required|profanity',
            ],
            [
                'answer.profanity' => 'Please check your words!',
            ]);
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $validatedData = $this->validate([
                'answer' => 'required|profanity',
            ],
            [
                'answer.profanity' => 'Please check your words!',
            ]);

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            $answer = Answer::create([
                'user_id' =>  Auth::id(),
                'question_id' =>  $this->question->id,
                'answer' => $this->answer,
            ]);

            $this->emit('answerAdded');
            $this->answer = '';

            if (Auth::id() !== $this->question->user->id) {
                $this->question->user->notify(new Answered($answer));
                givePoint(new CommentCreated($answer));
            }

            return session()->flash('success', 'Answer has been added!');
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.answer.create-answer');
    }
}
