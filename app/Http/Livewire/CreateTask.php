<?php

namespace App\Http\Livewire;

use App\Actions\CreateNewTask;
use App\Jobs\CheckGoal;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateTask extends Component
{
    use WithFileUploads;

    public $task;
    public $images = [];
    public $due_at;
    public $product;
    public $show_latest_task = false;
    public $latest_task;

    public function mount($product = null)
    {
        $this->product = $product;
    }

    public function checkState()
    {
        if (auth()->check()) {
            auth()->user()->checkState = ! auth()->user()->checkState;
            auth()->user()->save();
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function updatedImage()
    {
        if (auth()->check()) {
            $this->validate([
                'images' => ['max:5'],
                'images.*' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:5000'],
            ]);
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function submit()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(auth()->user());
        }
        if (! $throttler->check()) {
            loggy(request(), 'Throttle', auth()->user(), 'Rate limited while creating a task');

            return toast($this, 'error', 'Your are rate limited, try again later!');
        }

        if (auth()->check()) {
            $this->validate([
                'task' => ['required', 'min:5', 'max:10000'],
                'images' => ['max:5'],
                'images.*' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:5000'],
            ]);

            if (! auth()->user()->hasVerifiedEmail()) {
                return toast($this, 'error', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return toast($this, 'error', 'Your account is flagged!');
            }

            if ($this->images) {
                $images = [];
                foreach ($this->images as $image) {
                    $img = Image::make($image)
                        ->encode('webp', 100);
                    $imageName = Str::orderedUuid().'.webp';
                    Storage::disk('public')->put('photos/'.$imageName, (string) $img);
                    $image = 'photos/'.$imageName;
                    array_push($images, $image);
                }
            } else {
                $images = null;
            }

            $state = auth()->user()->checkState;

            if ($state) {
                $done_at = carbon();
            } else {
                $done_at = null;
            }

            if (! $this->product) {
                $product_id = Helper::getProductIDFromMention($this->task, auth()->user());
            } else {
                $product_id = $this->product->id;
            }

            $task = (new CreateNewTask(auth()->user(), [
                'product_id' =>  $product_id,
                'task' => $this->task,
                'done' => $state,
                'done_at' => $done_at,
                'images' => $images,
                'due_at' => $this->due_at,
                'type' => $product_id ? 'product' : 'user',
            ]))();

            $this->emit('refreshTasks');
            $this->reset(['task', 'images', 'due_at']);
            if (auth()->user()->hasGoal and $task->done) {
                auth()->user()->daily_goal_reached++;
                auth()->user()->save();
                CheckGoal::dispatch(auth()->user(), $task);
            }
            $this->latest_task = $task;

            return toast($this, 'success', 'Task has been created!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }
}
