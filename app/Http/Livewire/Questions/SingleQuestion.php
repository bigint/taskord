<?php

namespace App\Http\Livewire\Questions;

use App\Gamify\Points\PraiseCreated;
use App\Notifications\QuestionPraised;
use App\Notifications\TelegramLogger;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use App\Models\Question;

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
            if (Auth::id() === $this->question->user->id) {
                return session()->flash('error', 'You can\'t praise your own question!');
            }
            if (Auth::user()->hasLiked($this->question)) {
                Auth::user()->unlike($this->question);
                $this->question->refresh();
                undoPoint(new PraiseCreated($this->question));
                $this->question->user->notify(
                    new TelegramLogger(
                        '*👏 Question was un-praised* by @'
                        .Auth::user()->username."\n\n"
                        .$this->question->title."\n\nhttps://taskord.com/question/"
                        .$this->question->id
                    )
                );
            } else {
                Auth::user()->like($this->question);
                $this->question->refresh();
                $this->question->user->notify(new QuestionPraised($this->question, Auth::id()));
                givePoint(new PraiseCreated($this->question));
                $this->question->user->notify(
                    new TelegramLogger(
                        '*👏 Question was praised* by @'
                        .Auth::user()->username."\n\n"
                        .$this->question->title."\n\nhttps://taskord.com/question/"
                        .$this->question->id
                    )
                );
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
                Question::flushQueryCache(['questions:all']);
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
