<?php

namespace App\Http\Livewire\Tasks;

use App\Gamify\Points\TaskCreated;
use App\Models\Task;
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
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited while creating a task');

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

            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!');
            }

            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!');
            }

            $users = Helper::getUsernamesFromMentions($this->task);

            if ($this->images) {
                $images = [];
                foreach ($this->images as $image) {
                    $img = Image::make($image)
                        ->encode('webp', 80);
                    $imageName = Str::random(32).'.png';
                    Storage::disk('public')->put('photos/'.$imageName, (string) $img);
                    $image = 'photos/'.$imageName;
                    array_push($images, $image);
                }
            } else {
                $images = null;
            }

            $product_id = Helper::getProductIDFromMention($this->task);

            $task = Task::create([
                'user_id' =>  Auth::id(),
                'product_id' =>  $product_id,
                'task' => $this->task,
                'done' => false,
                'images' => $images,
                'due_at' => $this->due_at,
                'type' => $product_id ? 'product' : 'user',
                'source' => 'Taskord for Web',
            ]);
            Helper::mentionUsers($users, $task, 'task');
            $this->emit('taskAdded');
            $this->reset();
            givePoint(new TaskCreated($task));
            activity()
                ->withProperties(['type' => 'Task'])
                ->log('New task has been created U: @'.$task->user->username.' T: '.$task->id);
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
