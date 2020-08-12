<?php

namespace App\Http\Livewire\Answer;

use App\Gamify\Points\PraiseCreated;
use App\Notifications\AnswerPraised;
use App\Notifications\Slack\NewPraise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
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
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->answer->user->id) {
                return session()->flash('error', 'You can\'t praise your own answer!');
            }
            if (Auth::user()->hasLiked($this->answer)) {
                Auth::user()->unlike($this->answer);
                $this->answer->refresh();
            } else {
                Auth::user()->like($this->answer);
                $this->answer->refresh();
                $this->answer->user->notify(new AnswerPraised($this->answer, Auth::id()));
                givePoint(new PraiseCreated($this->answer));
                Notification::route('slack', config('app.slack_hook_url'))
                    ->notify(new NewPraise('ANSWER', $this->answer, Auth::user()));
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
