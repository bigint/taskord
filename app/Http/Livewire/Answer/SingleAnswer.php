<?php

namespace App\Http\Livewire\Answer;

use App\Models\Answer;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Gate;
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

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (Gate::denies('praise', $this->answer)) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        Helper::togglePraise($this->answer, 'ANSWER');

        return loggy(request(), 'Answer', auth()->user(), 'Toggled answer praise | Answer ID: '.$this->answer->id);
    }

    public function hide()
    {
        if (Gate::denies('staff_mode')) {
            return toast($this, 'error', "Oops! You can't perform this action");
        }

        Helper::hide($this->answer);
        loggy(request(), 'Staff', auth()->user(), 'Toggled hide answer | Answer ID: '.$this->answer->id);

        return toast($this, 'success', 'Answer is hidden from public!');
    }

    public function deleteAnswer()
    {
        if (Gate::denies('act', $this->answer)) {
            return toast($this, 'success', 'Answer has been deleted successfully!');
        }

        loggy(request(), 'Answer', auth()->user(), 'Deleted an answer | Answer ID: '.$this->answer->id);
        $this->answer->delete();
        $this->emit('refreshAnswers');

        return auth()->user()->touch();
    }
}
