<?php

namespace App\Http\Livewire\Tasks;

use App\Gamify\Points\TaskCompleted;
use App\Jobs\CheckGoal;
use App\Models\Task;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class SingleTask extends Component
{
    use WithRateLimiting;

    public $listeners = [
        'refreshSingleTask' => 'render',
    ];

    public Task $task;
    public $show_delete = true;

    public function mount($task)
    {
        $this->task = $task;
    }

    public function checkTask()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('check.task', $this->task)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        $this->task->done = ! $this->task->done;
        $this->task->done_at = carbon();
        auth()->user()->touch();
        givePoint(new TaskCompleted($this->task));
        $this->task->save();
        $this->emit('refreshTasks');
        if (auth()->user()->has_goal and $this->task->done) {
            auth()->user()->daily_goal_reached++;
            auth()->user()->save();
            CheckGoal::dispatch(auth()->user(), $this->task);
        }

        return loggy(request(), 'Task', auth()->user(), 'Updated a task as done | Task ID: '.$this->task->id);
    }

    public function deleteTask()
    {
        if (Gate::denies('act', $this->task)) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        loggy(request(), 'Task', auth()->user(), 'Deleted a task | Task ID: '.$this->task->id);
        foreach ($this->task->images ?? [] as $image) {
            Storage::delete($image);
        }
        $this->task->delete();
        $this->emitUp('refreshTasks');

        return auth()->user()->touch();
    }

    public function render()
    {
        return view('livewire.tasks.single-task');
    }
}
