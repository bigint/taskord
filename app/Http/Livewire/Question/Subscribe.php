<?php

namespace App\Http\Livewire\Question;

use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class Subscribe extends Component
{
    public $listeners = [
        'questionSubscribed' => 'render',
    ];

    public $question;

    public function mount($question)
    {
        $this->question = $question;
    }

    public function subscribeQuestion()
    {
        $throttler = Throttle::get(Request::instance(), 10, 5);
        $throttler->hit();
        if (count($throttler) > 20) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while subscribing to the question');

            return $this->alert('error', 'Your are rate limited, try again later!', [
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
                return $this->alert('warning', 'You can\'t subscribe your own question!', [
                    'showCancelButton' => true,
                ]);
            } else {
                Auth::user()->toggleSubscribe($this->question);
                $this->question->refresh();
                Auth::user()->touch();
                activity()
                    ->withProperties(['type' => 'Question'])
                    ->log('Question subscribe was toggled Q: '.$this->question->id);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.question.subscribe');
    }
}
