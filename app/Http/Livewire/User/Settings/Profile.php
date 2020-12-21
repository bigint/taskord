<?php

namespace App\Http\Livewire\User\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
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
    // Goal
    public $daily_goal;
    public $hasGoal;
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
        $this->hasGoal = $user->hasGoal;
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
        if (Auth::check()) {
            $this->validate([
                'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:1024',
            ]);
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function updateProfile()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->validate([
                    'firstname' => 'nullable|max:30',
                    'lastname' => 'nullable|max:30',
                    'bio' => 'nullable|max:160',
                    'location' => 'nullable|max:30',
                    'company' => 'nullable|max:30',
                    'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:1024',
                ]);

                if ($this->avatar) {
                    $old_avatar = explode('storage/', $this->user->avatar);
                    if (array_key_exists(1, $old_avatar)) {
                        Storage::delete($old_avatar[1]);
                    }
                    $img = Image::make($this->avatar)
                        ->fit(400)
                        ->encode('webp', 80);
                    $imageName = Str::random(32).'.png';
                    Storage::disk('public')->put('avatars/'.$imageName, (string) $img);
                    $avatar = config('app.url').'/storage/avatars/'.$imageName;
                    $this->user->avatar = $avatar;
                }

                if (Auth::check()) {
                    $this->user->firstname = $this->firstname;
                    $this->user->lastname = $this->lastname;
                    $this->user->bio = $this->bio;
                    $this->user->location = $this->location;
                    $this->user->company = $this->company;
                    $this->user->save();
                    activity()
                        ->withProperties(['type' => 'User'])
                        ->log('Profile settings was updated');

                    return $this->alert('success', 'Your profile has been updated!', [
                        'showCancelButton' => true,
                    ]);
                }
            } else {
                return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function useGravatar()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $old_avatar = explode('storage/', $this->user->avatar);
                if (array_key_exists(1, $old_avatar)) {
                    Storage::delete($old_avatar[1]);
                }
                $this->user->avatar = 'https://secure.gravatar.com/avatar/'.md5(Auth::user()->email).'?s=500&d=identicon';
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('Changed avatar provider to Gravatar');

                return $this->alert('success', 'Your profile has been updated!', [
                    'showCancelButton' => true,
                ]);
            } else {
                return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function enableGoal()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->hasGoal = ! $this->user->hasGoal;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('Goals for the account was toggled');
            } else {
                return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function setGoal()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->validate([
                    'daily_goal' => 'integer|max:1000|min:5',
                ]);

                if (Auth::check()) {
                    $this->user->daily_goal = $this->daily_goal;
                    $this->user->save();
                    activity()
                        ->withProperties(['type' => 'User'])
                        ->log('Goal was set as '.$this->daily_goal.'/day');

                    return $this->alert('success', 'Your goal has been updated!', [
                        'showCancelButton' => true,
                    ]);
                }
            } else {
                return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function updateSponsor()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->validate([
                    'sponsor' => 'nullable|active_url',
                ]);

                if (Auth::check()) {
                    $this->user->sponsor = $this->sponsor;
                    $this->user->save();
                    activity()
                        ->withProperties(['type' => 'User'])
                        ->log('Sponsor URL was updated');

                    return $this->alert('success', 'Your sponsor link has been updated!', [
                        'showCancelButton' => true,
                    ]);
                }
            } else {
                return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function updateSocial()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->validate([
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
                    activity()
                        ->withProperties(['type' => 'User'])
                        ->log('Social URLs were updated');

                    return $this->alert('success', 'Your social links has been updated!', [
                        'showCancelButton' => true,
                    ]);
                }
            } else {
                return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function onlyFollowingsTasks()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->onlyFollowingsTasks = ! $this->user->onlyFollowingsTasks;
                $this->user->save();
                if ($this->user->onlyFollowingsTasks) {
                    session()->flash('showfollowing', 'Only following user\'s task will be show on homepage');
                } else {
                    session()->flash('showfollowing', 'All user\'s task will be show on homepage');
                }
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('Toggled only followings tasks in settings');
            } else {
                return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
            }
        } else {
            return $this->alert('error', 'Forbidden!', [
                'showCancelButton' => true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.user.settings.profile');
    }
}
