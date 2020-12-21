<?php

namespace App\Http\Livewire\Question;

use App\Gamify\Points\QuestionCreated;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateQuestion extends Component
{
    public $title;
    public $body;
    public $patronOnly;

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'title' => 'required|min:5|max:100',
                'body' => 'required|min:3|max:10000',
            ]);

            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!', [
                    'showCancelButton' => true,
                ]);
            }

            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' => true,
                ]);
            }

            $patronOnly = ! $this->patronOnly ? false : true;

            $question = Question::create([
                'user_id' =>  Auth::id(),
                'title' => $this->title,
                'body' => $this->body,
                'patronOnly' => $patronOnly,
            ]);
            Auth::user()->touch();

            $this->alert('success', 'Question has been created!', [
                'showCancelButton' => true,
            ]);
            givePoint(new QuestionCreated($question));
            activity()
                ->withProperties(['type' => 'Question'])
                ->log('New question has been created Q: '.$question->id);

            return redirect()->route('question.question', ['id' => $question->id]);
        } else {
            $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.question.create-question');
    }
}
