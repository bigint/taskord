<?php

namespace App\Http\Livewire\Answer;

use App\Models\Answer;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Helper;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class SingleAnswer extends Component
{
    use WithRateLimiting;

    protected $listeners = ['answerEdited' => 'answerEdited'];

    public Answer $answer;
    public $showReplyBox = false;
    public $edit = false;

    public function mount($answer)
    {
        $this->answer = $answer;
    }

    public function toggleLike()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('like/subscribe', $this->answer)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        Helper::toggleLike($this->answer, 'ANSWER');
        $this->emit('answerLiked');

        return loggy(request(), 'Answer', auth()->user(), "Toggled answer like | Answer ID: {$this->answer->id}");
    }

    public function toggleReplyBox()
    {
        $this->showReplyBox = ! $this->showReplyBox;
    }

    public function hide()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        Helper::hide($this->answer);
        $this->emit('answersHidden');
        loggy(request(), 'Staff', auth()->user(), "Toggled hide answer | Answer ID: {$this->answer->id}");

        return toast($this, 'success', 'Answer is hidden from public!');
    }

    public function editAnswer()
    {
        if (Gate::denies('edit/delete', $this->answer)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->edit = ! $this->edit;
    }

    public function answerEdited()
    {
        $this->edit = false;
    }

    public function deleteAnswer()
    {
        if (Gate::denies('edit/delete', $this->answer)) {
            return toast($this, 'success', 'Answer has been deleted successfully!');
        }

        loggy(request(), 'Answer', auth()->user(), "Deleted an answer | Answer ID: {$this->answer->id}");
        $this->answer->delete();

        return $this->emit('refreshAnswers');
    }
}
