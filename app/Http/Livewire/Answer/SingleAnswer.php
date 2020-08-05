<?php

namespace App\Http\Livewire\Answer;

use App\AnswerPraise;
use App\Gamify\Points\PraiseCreated;
use App\Notifications\AnswerPraised;
use Auth;
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
            $isPraised = AnswerPraise::where([
                ['user_id', Auth::id()],
                ['answer_id', $this->answer->id],
            ])->count();
            if ($isPraised === 1) {
                $praise = AnswerPraise::where([
                    ['user_id', Auth::id()],
                    ['answer_id', $this->answer->id],
                ])->first();
                $praise->delete();
                $this->answer->refresh();
            } else {
                $praise = AnswerPraise::create([
                    'user_id' => Auth::id(),
                    'answer_id' => $this->answer->id,
                ]);
                $this->answer->refresh();
                $this->answer->user->notify(new AnswerPraised($this->answer, Auth::id()));
                givePoint(new PraiseCreated($praise));
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
