<?php

namespace App\Http\Livewire\Question;

use App\Models\Question;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Helper;
use Illuminate\Contracts\View\View;
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
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        Helper::toggleLike($this->question, 'QUESTION');
        $this->emit('questionLiked');

        return loggy(request(), 'Question', auth()->user(), "Toggled question like | Question ID: {$this->question->id}");
    }

    public function hide()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        Helper::hide($this->question);
        $this->emit('questionHidden');
        loggy(request(), 'Staff', auth()->user(), "Toggled hide question | Question ID: {$this->question->id}");

        return toast($this, 'success', 'Question is hidden from public!');
    }

    public function toggleSolve()
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        if (auth()->user()->spammy) {
            return toast($this, 'error', 'Your account is flagged!');
        }

        if (auth()->user()->staff_mode or auth()->user()->id === $this->question->user_id) {
            loggy(request(), 'Question', auth()->user(), "Toggled solve question | Question ID: {$this->question->id}");
            $this->question->solved = ! $this->question->solved;
            $this->question->save();

            return $this->emit('refreshSingleQuestion');
        }

        return toast($this, 'error', config('taskord.toast.deny'));
    }

    public function deleteQuestion()
    {
        if (Gate::denies('edit/delete', $this->question)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        loggy(request(), 'Question', auth()->user(), "Deleted a question | Question ID: {$this->question->id}");
        $this->question->delete();
        $this->emit('refreshQuestions');

        return redirect()->route('questions.newest');
    }

    public function render(): View
    {
        return view('livewire.question.single-question');
    }
}
