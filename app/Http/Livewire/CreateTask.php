<?php

namespace App\Http\Livewire;

use App\Actions\CreateNewTask;
use App\Gamify\Points\TaskCreated;
use App\Jobs\CheckGoal;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
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

    public function mount($product = null)
    {
        $this->product = $product;
    }

    private function resetInputFields()
    {
        $this->task = '';
        $this->images = '';
    }

    public function checkState()
    {
        if (Auth::check()) {
            auth()->user()->checkState = ! auth()->user()->checkState;
            auth()->user()->save();
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function updatedImage()
    {
        if (Auth::check()) {
            $this->validate([
                'images' => 'max:5',
                'images.*' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048',
            ],
            [
                'images.max' => 'Only 5 Images are allowed!',
            ]);
        } else {
            return $this->alert('error', 'Forbidden!');
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
            loggy('Throttle', auth()->user(), 'Rate limited while creating a task');

            return $this->alert('error', 'Your are rate limited, try again later!');
        }

        if (Auth::check()) {
            $this->validate([
                'task' => 'required|min:5|max:10000',
                'images' => 'max:5',
                'images.*' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048',
            ],
            [
                'images.max' => 'Only 5 Images are allowed!',
            ]);

            if (! auth()->user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            $users = Helper::getUsernamesFromMentions($this->task);

            if ($this->images) {
                $images = [];
                foreach ($this->images as $image) {
                    $img = Image::make($image)
                        ->encode('jpg', 80);
                    $imageName = Str::random(32).'.png';
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
                $product_id = Helper::getProductIDFromMention($this->task);
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

            $this->emit('taskAdded');
            $this->resetInputFields();
            Helper::mentionUsers($users, $task, 'task');
            givePoint(new TaskCreated($task));
            if (auth()->user()->hasGoal and $task->done) {
                auth()->user()->daily_goal_reached++;
                auth()->user()->save();
                CheckGoal::dispatch(auth()->user(), $task);
            }

            return $this->alert('success', 'Task has been created!');
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
