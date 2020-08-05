<?php

namespace App\Http\Livewire\Question;

use App\Gamify\Points\QuestionCreated;
use App\Question;
use Auth;
use Livewire\Component;

class CreateQuestion extends Component
{
    public $title;
    public $body;

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'title' => 'required|profanity|min:5|max:100',
                'body' => 'required|profanity|min:3|max:10000',
            ],
            [
                'title.profanity' => 'Please check your words!',
                'body.profanity' => 'Please check your words!',
            ]);
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $validatedData = $this->validate([
                'title' => 'required|profanity|min:5|max:100',
                'body' => 'required|profanity|min:3|max:10000',
            ],
            [
                'title.profanity' => 'Please check your words!',
                'body.profanity' => 'Please check your words!',
            ]);

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            $question = Question::create([
                'user_id' =>  Auth::id(),
                'title' => $this->title,
                'body' => $this->body,
            ]);

            session()->flash('question_created', 'Question has been created!');
            givePoint(new QuestionCreated($question));

            return redirect()->route('question.question', ['id' => $question->id]);
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.question.create-question');
    }
}
