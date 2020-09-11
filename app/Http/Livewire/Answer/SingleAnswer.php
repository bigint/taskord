<?php

namespace App\Http\Livewire\Answer;

use App\Gamify\Points\PraiseCreated;
use App\Notifications\AnswerPraised;
use App\Notifications\TelegramLogger;
use GrahamCampbell\Throttle\Facades\Throttle;
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
        $throttler = Throttle::get(Request::instance(), 50, 5);
        $throttler->hit();
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
            if (Auth::user()->hasLiked($this->answer)) {
                Auth::user()->unlike($this->answer);
                $this->answer->refresh();
                undoPoint(new PraiseCreated($this->answer));
                $this->answer->user->notify(
                    new TelegramLogger(
                        '*👏 Answer was un-praised* by @'
                        .Auth::user()->username."\n\n"
                        .$this->answer->answer."\n\nhttps://taskord.com/question/"
                        .$this->answer->question->id
                    )
                );
            } else {
                Auth::user()->like($this->answer);
                $this->answer->refresh();
                $this->answer->user->notify(new AnswerPraised($this->answer, Auth::id()));
                givePoint(new PraiseCreated($this->answer));
                $this->answer->user->notify(
                    new TelegramLogger(
                        '*👏 Answer was praised* by @'
                        .Auth::user()->username."\n\n"
                        .$this->answer->answer."\n\nhttps://taskord.com/question/"
                        .$this->answer->question->id
                    )
                );
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
                $this->answer->delete();
                $this->emit('answerDeleted');
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
