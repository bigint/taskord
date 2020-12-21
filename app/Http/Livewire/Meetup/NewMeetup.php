<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Meetup;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::check()) {
            $this->validate([
                'cover' => 'nullable|mimes:jpeg,jpg,png,gif|max:1024',
            ]);
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function submit()
    {
        if (Auth::check()) {
            $this->validate([
                'name' => 'required|max:30',
                'slug' => 'required|min:3|max:20|unique:meetups|alpha_dash',
                'tagline' => 'required|max:160',
                'description' => 'nullable|max:50000',
                'location' => 'nullable|max:50',
                'date' => 'required|date',
                'cover' => 'nullable|mimes:jpeg,jpg,png,gif|max:1024',
            ]);

            if (! Auth::user()->hasVerifiedEmail()) {
                return $this->alert('warning', 'Your email is not verified!', [
                    'showCancelButton' => true,
                ]);
            }

            if (Auth::user()->isFlagged) {
                return $this->alert('error', 'Your account is flagged!', [
                    'showCancelButton' => true,
                ]);
            }

            if ($this->cover) {
                $img = Image::make($this->cover)
                        ->fit(1500)
                        ->crop(1500, 500)
                        ->encode('webp', 80);
                $imageName = Str::random(32).'.png';
                Storage::disk('public')->put('meetup-cover/'.$imageName, (string) $img);
                $url = config('app.url').'/storage/meetup-cover/'.$imageName;
            } else {
                $url = 'https://avatar.tobi.sh/'.md5($this->slug).'.svg?text=📦';
            }

            $meetup = Meetup::create([
                'user_id' =>  Auth::id(),
                'name' => $this->name,
                'slug' => $this->slug,
                'cover' => $url,
                'tagline' => $this->tagline,
                'description' => $this->description,
                'location' => $this->location,
                'date' => $this->date,
            ]);
            Auth::user()->touch();

            $this->alert('success', 'Meetup has been created!', [
                'showCancelButton' => true,
            ]);

            return redirect()->route('meetups.home');
        } else {
            $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.meetup.new-meetup');
    }
}
