<?php

namespace App\Http\Livewire\Question;

use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleQuestion extends Component
{
    public $question;
    public $type;
    public $confirming;

    public function mount($question, $type)
    {
        $this->question = $question;
        $this->type = $type;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while praising the question');

            return $this->alert('warning', 'Your are rate limited, try again later!', [
                'showCancelButton' => true,
            ]);
        }

        if (Auth::check()) {
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
            if (Auth::id() === $this->question->user->id) {
                return $this->alert('warning', 'You can\'t praise your own question!', [
                    'showCancelButton' => true,
                ]);
            }
            Helper::togglePraise($this->question, 'QUESTION');
            activity()
                ->withProperties(['type' => 'Question'])
                ->log('Question praise was toggled Q: '.$this->question->id);
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function hide()
    {
        if (Auth::check()) {
            if (Auth::user()->isStaff and Auth::user()->staffShip) {
                Helper::hide($this->question);
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Question hide was toggled Q: '.$this->question->id);
            } else {
                return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->question->id;
    }

    public function deleteQuestion()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' => true,
                ]);
            }

            if (Auth::user()->staffShip or Auth::id() === $this->question->user_id) {
                activity()
                    ->withProperties(['type' => 'Question'])
                    ->log('Question was deleted Q: '.$this->question->id);
                $this->question->delete();
                Auth::user()->touch();
                session()->flash('question_deleted', 'Question has been deleted!');

                return redirect()->route('questions.newest');
            } else {
                session()->flash('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.question.single-question');
    }
}
