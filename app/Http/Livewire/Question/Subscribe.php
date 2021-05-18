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
        'questionSubscribed' => 'render',
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

            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Your are rate limited, try again later!',
            ]);
        }

        if (auth()->check()) {
            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your email is not verified!',
                ]);
            }
            if (auth()->user()->isFlagged) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your account is flagged!',
                ]);
            }
            if (auth()->user()->id === $this->question->user->id) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'You can\'t subscribe your own question!',
                ]);
            } else {
                auth()->user()->toggleSubscribe($this->question);
                $this->question->refresh();
                auth()->user()->touch();
                loggy(request(), 'Question', auth()->user(), 'Toggled question subscribe | Question ID: '.$this->question->id);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.question.subscribe');
    }
}
