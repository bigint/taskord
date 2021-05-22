<?php

namespace App\Http\Livewire\Meetup;

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
        if (auth()->check()) {
            $this->validate([
                'cover' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
            ]);
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function submit()
    {
        if (auth()->check()) {
            $this->validate([
                'name' => ['required', 'max:30'],
                'slug' => ['required', 'min:3', 'max:20', 'unique:meetups', 'alpha_dash'],
                'tagline' => ['required', 'max:160'],
                'description' => ['nullable', 'max:50000'],
                'location' => ['nullable', 'max:50'],
                'date' => ['required', 'date'],
                'cover' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
            ]);

            if (! auth()->user()->hasVerifiedEmail()) {
                return toast($this, 'error', 'Your email is not verified!');
            }

            if (auth()->user()->isFlagged) {
                return toast($this, 'error', 'Your account is flagged!');
            }

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

            $meetup = auth()->user()->meetups()->create([
                'name' => $this->name,
                'slug' => $this->slug,
                'cover' => $url,
                'tagline' => $this->tagline,
                'description' => $this->description,
                'location' => $this->location,
                'date' => $this->date,
            ]);
            auth()->user()->touch();

            return redirect()->route('meetups.home');
        } else {
            toast($this, 'error', 'Forbidden!');
        }
    }
}
