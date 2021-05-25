<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleQuestion extends Component
{
    public $listeners = [
        'refreshSingleQuestion' => 'render',
    ];

    public Question $question;
    public $type;

    public function mount($question, $type)
    {
        $this->question = $question;
        $this->type = $type;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 30, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while praising the question');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (! auth()->user()->hasVerifiedEmail()) {
            return toast($this, 'error', 'Your email is not verified!');
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }
        if (auth()->user()->id === $this->question->user->id) {
            return toast($this, 'error', 'You can\'t praise your own question!');
        }
        Helper::togglePraise($this->question, 'QUESTION');
        loggy(request(), 'Question', auth()->user(), 'Toggled question praise | Question ID: '.$this->question->id);
    }

    public function hide()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (auth()->user()->is_staff and auth()->user()->staff_mode) {
            Helper::hide($this->question);
            loggy(request(), 'Staff', auth()->user(), 'Toggled hide question | Question ID: '.$this->question->id);

            return toast($this, 'success', 'Question is hidden from public!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function toggleSolve()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        if (auth()->user()->staff_mode or auth()->user()->id === $this->question->user_id) {
            loggy(request(), 'Question', auth()->user(), 'Toggled solve question | Question ID: '.$this->question->id);
            $this->question->solved = ! $this->question->solved;
            $this->question->save();
            auth()->user()->touch();

            return $this->emit('refreshSingleQuestion');
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }

    public function deleteQuestion()
    {
        if (! auth()->check()) {
            return toast($this, 'error', 'Forbidden!');
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        if (auth()->user()->staff_mode or auth()->user()->id === $this->question->user_id) {
            loggy(request(), 'Question', auth()->user(), 'Deleted a question | Question ID: '.$this->question->id);
            $this->question->delete();
            auth()->user()->touch();

            return redirect()->route('questions.newest');
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.question.single-question');
    }
}
