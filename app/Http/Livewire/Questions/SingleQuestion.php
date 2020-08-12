<?php

namespace App\Http\Livewire\Questions;

use App\Gamify\Points\PraiseCreated;
use App\Models\QuestionPraise;
use App\Notifications\QuestionPraised;
use App\Notifications\Slack\NewPraise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
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
        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }
            if (Auth::id() === $this->question->user->id) {
                return session()->flash('error', 'You can\'t praise your own question!');
            }
            if (Auth::user()->hasLiked($this->question)) {
                Auth::user()->unlike($this->question);
                $this->question->refresh();
            } else {
                Auth::user()->like($this->question);
                $this->question->refresh();
                $this->question->user->notify(new QuestionPraised($this->question, Auth::id()));
                givePoint(new PraiseCreated($this->question));
                Notification::route('slack', config('app.slack_hook_url'))
                    ->notify(new NewPraise('QUESTION', $this->question, Auth::user()));
            }
        } else {
            return session()->flash('error', 'Forbidden!');
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
                return session()->flash('error', 'Your account is flagged!');
            }

            if (Auth::user()->staffShip or Auth::id() === $this->question->user_id) {
                $this->question->delete();
                session()->flash('question_deleted', 'Question has been deleted!');

                return redirect()->route('questions.newest');
            } else {
                session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.questions.single-question');
    }
}
