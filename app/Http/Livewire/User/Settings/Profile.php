<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public User $user;
    // Profile
    public $firstname;
    public $lastname;
    public $bio;
    public $location;
    public $company;
    public $avatar;
    // Goal
    public $daily_goal;
    public $has_goal;
    // Sponsor
    public $sponsor;
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
        // Goal
        $this->has_goal = $user->has_goal;
        $this->daily_goal = $user->daily_goal;
        // Sponsor
        $this->sponsor = $user->sponsor;
        // Social
        $this->website = $user->website;
        $this->twitter = $user->twitter;
        $this->twitch = $user->twitch;
        $this->telegram = $user->telegram;
        $this->github = $user->github;
        $this->youtube = $user->youtube;
    }

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
        ]);
    }

    public function updateProfile()
    {
        if (auth()->user()->id === $this->user->id) {
            $this->validate([
                'firstname' => ['nullable', 'max:30'],
                'lastname' => ['nullable', 'max:30'],
                'bio' => ['nullable', 'max:160'],
                'location' => ['nullable', 'max:30'],
                'company' => ['nullable', 'max:30'],
                'avatar' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:1024'],
            ]);

            if ($this->avatar) {
                $old_avatar = explode('storage/', $this->user->avatar);
                if (array_key_exists(1, $old_avatar)) {
                    Storage::delete($old_avatar[1]);
                }
                $img = Image::make($this->avatar)
                    ->fit(400)
                    ->encode('webp', 100);
                $imageName = Str::orderedUuid().'.webp';
                Storage::disk('public')->put('avatars/'.$imageName, (string) $img);
                $avatar = config('app.url').'/storage/avatars/'.$imageName;
                $this->user->avatar = $avatar;
            }

            $this->user->firstname = $this->firstname;
            $this->user->lastname = $this->lastname;
            $this->user->bio = $this->bio;
            $this->user->location = $this->location;
            $this->user->company = $this->company;
            $this->user->save();
            loggy(request(), 'User', auth()->user(), 'Updated the profile settings');

            toast($this, 'success', 'Your profile has been updated!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function resetAvatar()
    {
        if (auth()->user()->id === $this->user->id) {
            $old_avatar = explode('storage/', $this->user->avatar);
            if (array_key_exists(1, $old_avatar)) {
                Storage::delete($old_avatar[1]);
            }
            $this->user->avatar = 'https://avatar.tobi.sh/'.Str::orderedUuid().'.svg?text='.strtoupper(substr($this->user->username, 0, 2));
            $this->user->save();
            loggy(request(), 'User', auth()->user(), 'Resetted avatar to default');

            return toast($this, 'success', 'Your avatar has been resetted!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function useGravatar()
    {
        if (auth()->user()->id === $this->user->id) {
            $old_avatar = explode('storage/', $this->user->avatar);
            if (array_key_exists(1, $old_avatar)) {
                Storage::delete($old_avatar[1]);
            }
            $this->user->avatar = 'https://secure.gravatar.com/avatar/'.md5(auth()->user()->email).'?s=500&d=identicon';
            $this->user->save();
            loggy(request(), 'User', auth()->user(), 'Updated avatar provider to Gravatar');

            return toast($this, 'success', 'Your avatar has been switched to Gravatar!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function enableGoal()
    {
        if (auth()->user()->id === $this->user->id) {
            $this->user->has_goal = ! $this->user->has_goal;
            $this->user->save();
            loggy(request(), 'User', auth()->user(), 'Toggled goals settings');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function setGoal()
    {
        if (auth()->user()->id === $this->user->id) {
            $this->validate([
                'daily_goal' => ['integer', 'max:1000', 'min:5'],
            ]);

            $this->user->daily_goal = $this->daily_goal;
            $this->user->save();
            loggy(request(), 'User', auth()->user(), 'Updated the goal '.$this->daily_goal.'/day');

            toast($this, 'success', 'Your goal has been updated!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function toggleVacationMode()
    {
        if (auth()->user()->id === $this->user->id) {
            $this->user->vacation_mode = ! $this->user->vacation_mode;
            $this->user->save();
            if ($this->user->vacation_mode) {
                loggy(request(), 'User', auth()->user(), 'Enabled vacation mode');

                toast($this, 'success', 'Vacation mode has been enabled!');
            } else {
                loggy(request(), 'User', auth()->user(), 'Disabled vacation mode');

                toast($this, 'success', 'Vacation mode has been disabled!');
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function updateSponsor()
    {
        if (auth()->user()->id === $this->user->id) {
            $this->validate([
                'sponsor' => ['nullable', 'active_url'],
            ]);

            $this->user->sponsor = $this->sponsor;
            $this->user->save();
            loggy(request(), 'User', auth()->user(), 'Updated the sponsor URL');

            toast($this, 'success', 'Your sponsor link has been updated!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function updateSocial()
    {
        if (auth()->user()->id === $this->user->id) {
            $this->validate([
                'website' => ['nullable', 'active_url'],
                'twitter' => ['nullable', 'alpha_dash', 'max:30'],
                'twitch' => ['nullable', 'alpha_dash', 'max:200'],
                'telegram' => ['nullable', 'alpha_dash', 'max:30'],
                'github' => ['nullable', 'alpha_dash', 'max:30'],
                'youtube' => ['nullable', 'alpha_dash', 'max:30'],
            ]);

            $this->user->website = $this->website;
            $this->user->twitter = $this->twitter;
            $this->user->twitch = $this->twitch;
            $this->user->telegram = $this->telegram;
            $this->user->github = $this->github;
            $this->user->youtube = $this->youtube;
            $this->user->save();
            loggy(request(), 'User', auth()->user(), 'Updated the social URLs');

            toast($this, 'success', 'Your social links has been updated!');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function onlyFollowingsTasks()
    {
        if (auth()->user()->id === $this->user->id) {
            $this->user->only_followings_tasks = ! $this->user->only_followings_tasks;
            $this->user->save();
            if ($this->user->only_followings_tasks) {
                toast($this, 'success', 'Only following user\'s task will be show on homepage');
            } else {
                toast($this, 'success', 'All user\'s task will be show on homepage');
            }
            loggy(request(), 'User', auth()->user(), 'Toggled only following users tasks in settings');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }
}
