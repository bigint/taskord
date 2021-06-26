<?php

namespace App\Http\Livewire\Tasks;

use App\Gamify\Points\TaskCompleted;
use App\Jobs\CheckGoal;
use App\Models\Task;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
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

        if (Gate::denies('task.check', $this->task)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->task->done = ! $this->task->done;
        $this->task->done_at = carbon();
        givePoint(new TaskCompleted($this->task));
        $this->task->save();
        $this->emit('refreshTasks');
        if (auth()->user()->has_goal and $this->task->done) {
            auth()->user()->daily_goal_reached += 1;
            auth()->user()->save();
            CheckGoal::dispatch(auth()->user(), $this->task);
        }

        return loggy(request(), 'Task', auth()->user(), "Updated a task as done | Task ID: {$this->task->id}");
    }

    public function deleteTask()
    {
        if (Gate::denies('edit/delete', $this->task)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        loggy(request(), 'Task', auth()->user(), "Deleted a task | Task ID: {$this->task->id}");
        foreach ($this->task->images ?? [] as $image) {
            Storage::delete($image);
        }
        if ($this->task->oembed) {
            $this->task->oembed->delete();
        }
        $this->task->delete();

        return $this->emitUp('refreshTasks');
    }

    public function render(): View
    {
        return view('livewire.tasks.single-task');
    }
}
