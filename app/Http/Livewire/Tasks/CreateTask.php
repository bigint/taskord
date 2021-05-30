<?php

namespace App\Http\Livewire\Tasks;

use App\Actions\CreateNewTask;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Helper;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateTask extends Component
{
    use WithFileUploads;
    use WithRateLimiting;

    public $task;
    public $images = [];
    public $dueAt;

    public function updatedImage()
    {
        if (! auth()->check()) {
            return toast($this, 'error', config('taskord.error.deny'));
        }

        $this->validate([
            'images' => ['max:5'],
            'images.*' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:5000'],
        ]);
    }

    public function submit()
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return toast($this, 'error', config('taskord.error.rate-limit'));
        }

        $this->validate([
            'task' => ['required', 'min:5', 'max:10000'],
            'images' => ['max:5'],
            'images.*' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:5000'],
        ]);

        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.error.deny'));
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

        $product_id = Helper::getProductIDFromMention($this->task, auth()->user());

        $task = (new CreateNewTask(auth()->user(), [
            'product_id' => $product_id,
            'task' => $this->task,
            'done' => false,
            'images' => $images,
            'due_at' => $this->dueAt,
            'type' => $product_id ? 'product' : 'user',
        ]))();

        $this->emit('refreshTasks');

        return $this->reset();
    }
}
