<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Helper;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SingleQuestion extends Component
{
    use WithRateLimiting;

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

    public function toggleLike()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('like/subscribe', $this->question)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::toggleLike($this->question, 'QUESTION');

        return loggy(request(), 'Question', auth()->user(), 'Toggled question like | Question ID: '.$this->question->id);
    }

    public function hide()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        Helper::hide($this->question);
        loggy(request(), 'Staff', auth()->user(), 'Toggled hide question | Question ID: '.$this->question->id);

        return toast($this, 'success', 'Question is hidden from public!');
    }

    public function toggleSolve()
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.error.deny'));
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
        }

        return toast($this, 'error', config('taskord.error.deny'));
    }

    public function deleteQuestion()
    {
        if (Gate::denies('edit/delete', $this->question)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        loggy(request(), 'Question', auth()->user(), 'Deleted a question | Question ID: '.$this->question->id);
        $this->question->delete();
        auth()->user()->touch();

        return redirect()->route('questions.newest');
    }

    public function render()
    {
        return view('livewire.question.single-question');
    }
}
