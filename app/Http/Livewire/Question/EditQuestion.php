<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditQuestion extends Component
{
    public Question $question;
    public $title;
    public $body;
    public $patronOnly;

    public function mount($question)
    {
        $this->question = $question;
        $this->title = $question->title;
        $this->body = $question->body;
        $this->patronOnly = $question->patronOnly;
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'title' => 'required|min:5|max:100',
                'body' => 'required|min:3|max:10000',
            ]);
        } else {
            $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
          ]);
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'title' => 'required|min:5|max:100',
                'body' => 'required|min:3|max:10000',
            ]);

            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!', [
                    'showCancelButton' =>  false,
              ]);
            }

            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' =>  false,
              ]);
            }

            $question = Question::where('id', $this->question->id)->firstOrFail();

            $patronOnly = ! $this->patronOnly ? false : true;

            if (Auth::user()->staffShip or Auth::id() === $question->user_id) {
                $question->title = $this->title;
                $question->body = $this->body;
                $question->patronOnly = $this->patronOnly;
                $question->save();
                Auth::user()->touch();

                activity()
                    ->withProperties(['type' => 'Question'])
                    ->log('Question has been edited Q: '.$question->id);
                    $this->flash('success', 'Question has been edited!', [
                        'showCancelButton' =>  false,
                  ]);

                return redirect()->route('question.question', ['id' => $question->id]);
            } else {
                $this->alert('error', 'Forbidden!', [
                    'showCancelButton' =>  false,
              ]);
            }
        } else {
            $this->alert('error', 'Forbidden!', [
                'showCancelButton' =>  false,
          ]);
        }
    }
}
