<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
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

        if (Gate::denies('praise', $this->question)) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        auth()->user()->toggleSubscribe($this->question);
        $this->question->refresh();
        auth()->user()->touch();

        return loggy(request(), 'Question', auth()->user(), 'Toggled question subscribe | Question ID: '.$this->question->id);
    }

    public function render()
    {
        return view('livewire.question.subscribe');
    }
}
