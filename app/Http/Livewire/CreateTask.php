<?php

namespace App\Http\Livewire;

use App\Gamify\Points\TaskCreated;
use App\Jobs\CheckGoal;
use App\Models\Task;
use Carbon\Carbon;
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
            Auth::user()->checkState = ! Auth::user()->checkState;
            Auth::user()->save();
        } else {
            return session()->flash('error', 'Forbidden!');
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
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function submit()
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (count($throttler) > 30) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while creating a task');
            return session()->flash('error', 'Your are rate limited, try again later!');
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

            if (! Auth::user()->hasVerifiedEmail()) {
                return session()->flash('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return session()->flash('error', 'Your account is flagged!');
            }

            $users = Helper::getUserIDFromMention($this->task);

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

            $state = Auth::user()->checkState;

            if ($state) {
                $done_at = Carbon::now();
            } else {
                $done_at = null;
            }

            if (! $this->product) {
                $product_id = Helper::getProductIDFromMention($this->task);
            } else {
                $product_id = $this->product->id;
            }

            $task = Task::create([
                'user_id' =>  Auth::id(),
                'product_id' =>  $product_id,
                'task' => $this->task,
                'done' => $state,
                'done_at' => $done_at,
                'images' => $images,
                'due_at' => $this->due_at,
                'type' => $product_id ? 'product' : 'user',
                'source' => 'Taskord for Web',
            ]);

            $this->emit('taskAdded');
            $this->resetInputFields();
            Helper::mentionUsers($users, $task, 'task');
            givePoint(new TaskCreated($task));
            if (Auth::user()->hasGoal and $task->done) {
                Auth::user()->daily_goal_reached++;
                Auth::user()->save();
                CheckGoal::dispatch(Auth::user(), $task);
            }
            activity()
                ->withProperties(['type' => 'Task'])
                ->log('New task has been created U: @'.$task->user->username.' T: '.$task->id);

            return session()->flash('success', 'Task has been created!');
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.create-task');
    }
}
