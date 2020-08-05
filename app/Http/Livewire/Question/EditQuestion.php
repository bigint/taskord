<?php

namespace App\Http\Livewire\Question;

use App\Question;
use Auth;
use Livewire\Component;

class EditQuestion extends Component
{
    public $question;
    public $title;
    public $body;

    public function mount($question)
    {
        $this->question = $question;
        $this->title = $question->title;
        $this->body = $question->body;
    }

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

            $question = Question::where('id', $this->question->id)->firstOrFail();

            if (Auth::user()->staffShip or Auth::id() === $question->user_id) {
                $question->title = $this->title;
                $question->body = $this->body;
                $question->save();

                session()->flash('question_edited', 'Question has been edited!');

                return redirect()->route('question.question', ['id' => $question->id]);
            } else {
                session()->flash('error', 'Forbidden!');
            }
        } else {
            session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.question.edit-question');
    }
}
