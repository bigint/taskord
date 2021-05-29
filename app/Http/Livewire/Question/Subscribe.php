<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Subscribe extends Component
{
    use WithRateLimiting;

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
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('praise', $this->question)) {
            return toast($this, 'error', config('taskord.error.deny'));
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
