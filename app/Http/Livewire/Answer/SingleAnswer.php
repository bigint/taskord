<?php

namespace App\Http\Livewire\Answer;

use App\Models\Answer;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Livewire\Component;

class SingleAnswer extends Component
{
    public Answer $answer;

    public function mount($answer)
    {
        $this->answer = $answer;
    }

    public function togglePraise()
    {
        $throttler = Throttle::get(Request::instance(), 30, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while praising the answer');

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
            if (auth()->user()->id === $this->answer->user->id) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'You can\'t praise your own answer!',
                ]);
            }
            Helper::togglePraise($this->answer, 'ANSWER');
            loggy(request(), 'Answer', auth()->user(), 'Toggled answer praise | Answer ID: '.$this->answer->id);
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function hide()
    {
        if (auth()->check()) {
            if (auth()->user()->isStaff and auth()->user()->staffShip) {
                Helper::hide($this->answer);
                loggy(request(), 'Admin', auth()->user(), 'Toggled hide answer | Answer ID: '.$this->answer->id);

                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'success',
                    'body' => 'Answer is hidden from public!',
                ]);
            } else {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }

    public function deleteAnswer()
    {
        if (auth()->check()) {
            if (auth()->user()->isFlagged) {
                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Your account is flagged!',
                ]);
            }

            if (auth()->user()->staffShip or auth()->user()->id === $this->answer->user->id) {
                loggy(request(), 'Answer', auth()->user(), 'Deleted an answer | Answer ID: '.$this->answer->id);
                $this->answer->delete();
                $this->emit('answerDeleted');
                auth()->user()->touch();

                return $this->dispatchBrowserEvent('toast', [
                    'type' => 'success',
                    'body' => 'Answer has been deleted successfully!',
                ]);
            } else {
                $this->dispatchBrowserEvent('toast', [
                    'type' => 'error',
                    'body' => 'Forbidden!',
                ]);
            }
        } else {
            return $this->dispatchBrowserEvent('toast', [
                'type' => 'error',
                'body' => 'Forbidden!',
            ]);
        }
    }
}
