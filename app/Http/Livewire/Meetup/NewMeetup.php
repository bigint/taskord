<?php

namespace App\Http\Livewire\Meetup;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewMeetup extends Component
{
    use WithFileUploads;

    public $name;
    public $slug;
    public $cover;
    public $tagline;
    public $description;
    public $location;
    public $date;

    public function updatedCover()
    {
        $this->validate([
            'cover' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
        ]);
    }

    public function submit()
    {
        if (Gate::denies('create')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->validate([
            'name' => ['required', 'max:30'],
            'slug' => ['required', 'min:3', 'max:20', 'unique:meetups', 'alpha_dash'],
            'tagline' => ['required', 'max:160'],
            'description' => ['nullable', 'max:50000'],
            'location' => ['nullable', 'max:50'],
            'date' => ['required', 'date'],
            'cover' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
        ]);

        if ($this->cover) {
            $img = Image::make($this->cover)
                ->fit(1500)
                ->crop(1500, 500)
                ->encode('webp', 100);
            $imageName = Str::orderedUuid().'.webp';
            Storage::disk('public')->put('meetup-cover/'.$imageName, (string) $img);
            $url = config('app.url').'/storage/meetup-cover/'.$imageName;
        } else {
            $url = 'https://avatar.tobi.sh/'.Str::orderedUuid().'.svg?text=📦';
        }

        auth()->user()->meetups()->create([
            'name' => $this->name,
            'slug' => $this->slug,
            'cover' => $url,
            'tagline' => $this->tagline,
            'description' => $this->description,
            'location' => $this->location,
            'date' => $this->date,
        ]);

        return redirect()->route('meetups.home');
    }
}
