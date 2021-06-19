<?php

namespace App\Http\Livewire\Task;

use App\Gamify\Points\TaskCompleted;
use App\Jobs\CheckGoal;
use App\Models\Task;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Helper;
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
    public $launched;
    public $showComments;

    public function mount($task, $showComments = true)
    {
        $this->task = $task;
        $this->showComments = $showComments;
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

        if ($this->task->done) {
            $this->task->done_at = carbon();
            loggy(request(), 'Task', auth()->user(), "Updated a task as pending | Task ID: {$this->task->id}");
        } else {
            $this->task->done_at = carbon();
            if (auth()->user()->has_goal) {
                auth()->user()->daily_goal_reached += 1;
                auth()->user()->save();
                CheckGoal::dispatch(auth()->user(), $this->task);
            }
            givePoint(new TaskCompleted($this->task));
            loggy(request(), 'Task', auth()->user(), "Updated a task as done | Task ID: {$this->task->id}");
        }
        $this->task->done = ! $this->task->done;
        $this->task->save();

        return $this->emit('refreshTasks');
    }

    public function toggleLike()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        if (Gate::denies('like/subscribe', $this->task)) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        Helper::toggleLike($this->task, 'TASK');
        $this->emit('taskLiked');

        return loggy(request(), 'Task', auth()->user(), "Toggled task like | Task ID: {$this->task->id}");
    }

    public function hide()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        Helper::hide($this->task);
        $this->emit('taskHidden');
        loggy(request(), 'Staff', auth()->user(), "Toggled task hide | Task ID: {$this->task->id}");

        return toast($this, 'success', 'Task is hidden from public!');
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
        $this->task->delete();
        $this->emitUp('refreshTasks');

        return toast($this, 'success', 'Task has been deleted successfully!');
    }

    public function render()
    {
        $this->launched = false;
        $launchList = [
            'launched',
            'launch',
            'shipped',
            'ship',
        ];

        $launchFound = false;
        foreach ($launchList as $keyword) {
            if (preg_match("/\b${keyword}\b/", strtolower($this->task->task))) {
                $launchFound = true;
                break;
            }
        }

        if (($launchFound and (bool) $this->task->done)) {
            $this->launched = true;
        }

        return view('livewire.task.single-task');
    }
}
