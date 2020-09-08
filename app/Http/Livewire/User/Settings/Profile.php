<?php

namespace App\Http\Livewire\User\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $user;
    // Profile
    public $firstname;
    public $lastname;
    public $bio;
    public $location;
    public $company;
    public $avatar;
    // Social
    public $website;
    public $twitter;
    public $twitch;
    public $telegram;
    public $github;
    public $youtube;

    public function mount($user)
    {
        $this->user = $user;
        // Profile
        $this->firstname = $user->firstname;
        $this->lastname = $user->lastname;
        $this->bio = $user->bio;
        $this->location = $user->location;
        $this->company = $user->company;
        // Social
        $this->website = $user->website;
        $this->twitter = $user->twitter;
        $this->twitch = $user->twitch;
        $this->telegram = $user->telegram;
        $this->github = $user->github;
        $this->youtube = $user->youtube;
    }

    public function updated($field)
    {
        if (Auth::check()) {
            $this->validateOnly($field, [
                'firstname' => 'nullable|max:30',
                'lastname' => 'nullable|max:30',
                'bio' => 'nullable|max:1000',
                'location' => 'nullable|max:30',
                'company' => 'nullable|max:30',
                'website' => 'nullable|active_url',
                'twitter' => 'nullable|alpha_dash|max:30',
                'twitch' => 'nullable|alpha_dash|max:200',
                'telegram' => 'nullable|alpha_dash|max:30',
                'github' => 'nullable|alpha_dash|max:30',
                'youtube' => 'nullable|alpha_dash|max:30',
            ]);
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function updatedAvatar()
    {
        if (Auth::check()) {
            $this->validate([
                'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048',
            ]);
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function updateProfile()
    {
        if (Auth::check()) {
            $validatedData = $this->validate([
                'firstname' => 'nullable|max:30',
                'lastname' => 'nullable|max:30',
                'bio' => 'nullable|max:1000',
                'location' => 'nullable|max:30',
                'company' => 'nullable|max:30',
                'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048',
            ]);

            if ($this->avatar) {
                $old_avatar = explode('storage/', $this->user->avatar);
                if (array_key_exists(1, $old_avatar)) {
                    Storage::delete($old_avatar[1]);
                }
                $avatar = $this->avatar->store('avatars');
                $this->user->avatar = config('app.url').'/storage/'.$avatar;
            }

            if (Auth::check()) {
                $this->user->firstname = $this->firstname;
                $this->user->lastname = $this->lastname;
                $this->user->bio = $this->bio;
                $this->user->location = $this->location;
                $this->user->company = $this->company;
                $this->user->save();

                return session()->flash('profile', 'Your profile has been updated!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function useGravatar()
    {
        if (Auth::check()) {
            $old_avatar = explode('storage/', $this->user->avatar);
            if (array_key_exists(1, $old_avatar)) {
                Storage::delete($old_avatar[1]);
            }
            $this->user->avatar = 'https://secure.gravatar.com/avatar/'.md5(Auth::user()->email).'?s=500&d=identicon';
            $this->user->save();

            return session()->flash('profile', 'Your profile has been updated!');
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function updateSocial()
    {
        if (Auth::check()) {
            $validatedData = $this->validate([
                'website' => 'nullable|active_url',
                'twitter' => 'nullable|alpha_dash|max:30',
                'twitch' => 'nullable|alpha_dash|max:200',
                'telegram' => 'nullable|alpha_dash|max:30',
                'github' => 'nullable|alpha_dash|max:30',
                'youtube' => 'nullable|alpha_dash|max:30',
            ]);

            if (Auth::check()) {
                $this->user->website = $this->website;
                $this->user->twitter = $this->twitter;
                $this->user->twitch = $this->twitch;
                $this->user->telegram = $this->telegram;
                $this->user->github = $this->github;
                $this->user->youtube = $this->youtube;
                $this->user->save();

                return session()->flash('social', 'Your social links has been updated!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function onlyFollowingsTasks()
    {
        if (Auth::check()) {
            if (Auth::check() && Auth::id() === $this->user->id) {
                $this->user->onlyFollowingsTasks = ! $this->user->onlyFollowingsTasks;
                $this->user->save();
                if ($this->user->onlyFollowingsTasks) {
                    session()->flash('showfollowing', 'Only following user\'s task will be show on homepage');
                } else {
                    session()->flash('showfollowing', 'All user\'s task will be show on homepage');
                }
            } else {
                return false;
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.profile');
    }
}
