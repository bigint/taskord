<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Subscribe extends Component
{
    public $listeners = [
        'refreshQuestionSubscribe' => 'render',
    ];

    public Question $question;

    public function mount($question)
    {
        $this->question = $question;
    }

    public function subscribeQuestion()
    {
        $throttler = Throttle::get(Request::instance(), 10, 5);
        $throttler->hit();
        if (count($throttler) > 20) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while subscribing a question');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (auth()->check()) {
            if (! auth()->user()->hasVerifiedEmail()) {
                return toast($this, 'error', 'Your email is not verified!');
            }
            if (auth()->user()->isFlagged) {
                return toast($this, 'error', 'Your account is flagged!');
            }
            if (auth()->user()->id === $this->question->user->id) {
                return toast($this, 'error', 'You can\'t subscribe your own question!');
            } else {
                auth()->user()->toggleSubscribe($this->question);
                $this->question->refresh();
                auth()->user()->touch();
                loggy(request(), 'Question', auth()->user(), 'Toggled question subscribe | Question ID: '.$this->question->id);
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.question.subscribe');
    }
}
