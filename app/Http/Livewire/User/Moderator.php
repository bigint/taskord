<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Notifications\Staff\ContributorEnabled;
use App\Notifications\Staff\PatronGifted;
use App\Notifications\Staff\UserVerified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class Moderator extends Component
{
    public User $user;
    public $isBeta;
    public $isStaff;
    public $isPatron;
    public $darkMode;
    public $isContributor;
    public $isPrivate;
    public $isVerified;
    public $spammy;
    public $isSuspended;
    public $staffNotes;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
        $this->isBeta = $user->is_beta;
        $this->isStaff = $user->is_staff;
        $this->isPatron = $user->is_patron;
        $this->isContributor = $user->is_contributor;
        $this->isPrivate = $user->is_private;
        $this->isVerified = $user->is_verified;
        $this->spammy = $user->spammy;
        $this->isSuspended = $user->is_suspended;
        $this->staffNotes = $user->staff_notes;
    }

    public function loadModerator()
    {
        $this->readyToLoad = true;
    }

    public function enrollBeta()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->is_beta = ! $this->user->is_beta;
        $this->user->save();
        $this->emit('modSettingsUpdated');

        return toast($this, 'success', config('taskord.toast.settings-updated'));
    }

    public function enrollStaff()
    {
        if (Gate::denies('staff.ops') or $this->user->id === 1) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->is_staff = ! $this->user->is_staff;
        $this->user->save();
        $this->emit('modSettingsUpdated');

        return toast($this, 'success', config('taskord.toast.settings-updated'));
    }

    public function enrollDeveloper()
    {
        if (Gate::denies('staff.ops') or $this->user->id === 1) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->is_contributor = ! $this->user->is_contributor;
        $this->user->save();
        $this->emit('modSettingsUpdated');

        if ($this->user->is_contributor) {
            $this->user->notify(new ContributorEnabled(true));
        }

        return toast($this, 'success', config('taskord.toast.settings-updated'));
    }

    public function privateUser()
    {
        if (Gate::denies('staff.ops') or $this->user->id === 1) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->is_private = ! $this->user->is_private;
        $this->user->save();
        $this->emit('modSettingsUpdated');

        return toast($this, 'success', config('taskord.toast.settings-updated'));
    }

    public function flagUser()
    {
        if (Gate::denies('staff.ops') or $this->user->id === 1) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->spammy = ! $this->user->spammy;
        $this->user->save();
        $this->emit('modSettingsUpdated');

        return toast($this, 'success', config('taskord.toast.settings-updated'));
    }

    public function suspendUser()
    {
        if (Gate::denies('staff.ops') or $this->user->id === 1) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->is_suspended = ! $this->user->is_suspended;

        if ($this->user->is_suspended) {
            $this->user->spammy = true;
            $this->spammy = true;
        } else {
            $this->user->spammy = false;
            $this->spammy = false;
        }

        $this->user->save();
        $this->emit('modSettingsUpdated');

        return toast($this, 'success', config('taskord.toast.settings-updated'));
    }

    public function enrollPatron()
    {
        if (Gate::denies('staff.ops') or $this->user->id === 1) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->is_patron = ! $this->user->is_patron;
        $this->user->save();

        if ($this->user->is_patron) {
            $this->user->notify(new PatronGifted(true));
        }
        $this->emit('modSettingsUpdated');

        return toast($this, 'success', config('taskord.toast.settings-updated'));
    }

    public function featureUser()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        if ($this->user->featured_at) {
            $this->user->featured_at = null;
        } else {
            $this->user->featured_at = carbon();
        }
        $this->user->save();
        // TODO: Featured email to user
        $this->emit('modSettingsUpdated');

        return toast($this, 'success', config('taskord.toast.settings-updated'));
    }

    public function verifyUser()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->is_verified = ! $this->user->is_verified;
        $this->user->save();

        if ($this->user->is_verified) {
            $this->user->notify(new UserVerified(true));
        }
        $this->emit('modSettingsUpdated');

        return toast($this, 'success', config('taskord.toast.settings-updated'));
    }

    public function masquerade()
    {
        if (Gate::denies('staff.ops') or $this->user->id === 1) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        Auth::loginUsingId($this->user->id);

        return redirect()->route('home');
    }

    public function resetAvatar()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->avatar = 'https://avatar.tobi.sh/'.Str::orderedUuid().'.svg?text='.strtoupper(substr($this->user->username, 0, 2));
        $this->user->save();
        toast($this, 'success', config('taskord.toast.settings-updated'));

        return redirect()->route('user.done', ['username' => $this->user->username]);
    }

    public function releaseUsername()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->username = strtolower(Str::random(6));
        $this->user->save();
        toast($this, 'success', config('taskord.toast.settings-updated'));

        return redirect()->route('user.done', ['username' => $this->user->username]);
    }

    public function deleteTasks()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        foreach ($this->user->tasks as $task) {
            foreach ($task->images ?? [] as $image) {
                Storage::delete($image);
            }
        }
        $this->user->tasks()->delete();
        toast($this, 'success', config('taskord.toast.settings-updated'));

        return redirect()->route('user.done', ['username' => $this->user->username]);
    }

    public function deleteComments()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->comments()->delete();
        toast($this, 'success', config('taskord.toast.settings-updated'));

        return redirect()->route('user.done', ['username' => $this->user->username]);
    }

    public function deleteQuestions()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->questions()->delete();
        toast($this, 'success', config('taskord.toast.settings-updated'));

        return redirect()->route('user.done', ['username' => $this->user->username]);
    }

    public function deleteAnswers()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->answers()->delete();
        toast($this, 'success', config('taskord.toast.settings-updated'));

        return redirect()->route('user.done', ['username' => $this->user->username]);
    }

    public function deleteMilestones()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->milestones()->delete();
        toast($this, 'success', config('taskord.toast.settings-updated'));

        return redirect()->route('user.done', ['username' => $this->user->username]);
    }

    public function deleteProducts()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $user = User::find($this->user->id);
        foreach ($user->ownedProducts as $product) {
            $product->tasks()->delete();
            $product->webhooks()->delete();
            $avatar = explode('storage/', $product->avatar);
            if (array_key_exists(1, $avatar)) {
                Storage::delete($avatar[1]);
            }
        }
        $user->ownedProducts()->delete();
        toast($this, 'success', config('taskord.toast.settings-updated'));

        return redirect()->route('user.done', ['username' => $this->user->username]);
    }

    public function deleteUser()
    {
        if (Gate::denies('staff.ops') or $this->user->id === 1) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $user = User::find($this->user->id);
        // Delete Task Images
        foreach ($user->tasks as $task) {
            if ($task->oembed) {
                $task->oembed->delete();
            }
            foreach ($task->images ?? [] as $image) {
                Storage::delete($image);
            }
        }
        // Delete Product Logos
        foreach ($user->ownedProducts as $product) {
            $product->tasks()->delete();
            $product->webhooks()->delete();
            $avatar = explode('storage/', $product->avatar);
            if (array_key_exists(1, $avatar)) {
                Storage::delete($avatar[1]);
            }
        }
        // Delete User Avatar
        $avatar = explode('storage/', $user->avatar);
        if (array_key_exists(1, $avatar)) {
            Storage::delete($avatar[1]);
        }
        $user->likes()->delete();
        $user->notifications()->delete();
        $user->delete();

        return redirect()->route('home');
    }

    public function updateUserStaffNotes()
    {
        if (Gate::denies('staff.ops')) {
            return toast($this, 'error', config('taskord.toast.deny'));
        }

        $this->user->staff_notes = $this->staffNotes;
        $this->user->save();
        $this->emit('modSettingsUpdated');

        return toast($this, 'success', config('taskord.toast.settings-updated'));
    }

    public function render(): View
    {
        return view('livewire.user.moderator', [
            'user' => $this->readyToLoad ? $this->user : [],
        ]);
    }
}
