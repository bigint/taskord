<?php

namespace App\Http\Livewire\Answer;

use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleAnswer extends Component
{
    public $answer;
    public $confirming;

    public function mount($answer)
    {
        $this->answer = $answer;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            return session()->flash('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('warning', 'Your email is not verified!');
            }
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->answer->user->id) {
                return session()->flash('error', 'You can\'t praise your own answer!');
            }
            Helper::togglePraise($this->answer, 'ANSWER');
            activity()
                ->withProperties(['type' => 'Answer'])
                ->log('Answer praise was toggled A: '.$this->answer->id);
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function hide()
    {
        if (Auth::check()) {
            if (Auth::user()->isStaff and Auth::user()->staffShip) {
                Helper::hide($this->answer);
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Answer hide was toggled A: '.$this->answer->id);
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function confirmDelete()
    {
        $this->confirming = $this->answer->id;
    }

    public function deleteAnswer()
    {
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            if (Auth::user()->staffShip or Auth::id() === $this->answer->user->id) {
                activity()
                    ->withProperties(['type' => 'Answer'])
                    ->log('Answer was deleted A: '.$this->answer->id);
                $this->answer->delete();
                $this->emit('answerDeleted');
                Auth::user()->touch();
            } else {
                session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.answer.single-answer');
    }
}
