<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Notifications\Staff\ContributorEnabled;
use App\Notifications\Staff\PatronGifted;
use App\Notifications\Staff\UserVerified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class Moderator extends Component
{
    public User $user;
    public $is_beta;
    public $is_staff;
    public $is_patron;
    public $dark_mode;
    public $is_contributor;
    public $is_private;
    public $is_verified;
    public $spammy;
    public $is_suspended;
    public $staff_notes;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
        $this->is_beta = $user->is_beta;
        $this->is_staff = $user->is_staff;
        $this->is_patron = $user->is_patron;
        $this->dark_mode = $user->dark_mode;
        $this->is_contributor = $user->is_contributor;
        $this->is_private = $user->is_private;
        $this->is_verified = $user->is_verified;
        $this->spammy = $user->spammy;
        $this->is_suspended = $user->is_suspended;
        $this->staff_notes = $user->staff_notes;
    }

    public function loadModerator()
    {
        $this->readyToLoad = true;
    }

    public function enrollBeta()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $this->user->is_beta = ! $this->user->is_beta;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_beta) {
                loggy(request(), 'Staff', auth()->user(), 'Enrolled to Beta | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Staff', auth()->user(), 'Un-enrolled from Beta | Username: @'.$this->user->username);
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function enrollStaff()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            if ($this->user->id === 1) {
                return toast($this, 'error', 'Forbidden!');
            }
            $this->user->is_staff = ! $this->user->is_staff;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_staff) {
                loggy(request(), 'Staff', auth()->user(), 'Enrolled as Staff | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Staff', auth()->user(), 'Un-enrolled from Staff | Username: @'.$this->user->username);
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function enrollDeveloper()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $this->user->is_contributor = ! $this->user->is_contributor;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_contributor) {
                $this->user->notify(new ContributorEnabled(true));
                loggy(request(), 'Staff', auth()->user(), 'Enrolled as Contributor | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Staff', auth()->user(), 'Un-enrolled from Contributor | Username: @'.$this->user->username);
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function privateUser()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            if ($this->user->id === 1) {
                return toast($this, 'error', 'Forbidden!');
            }
            $this->user->is_private = ! $this->user->is_private;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_private) {
                loggy(request(), 'Staff', auth()->user(), 'Enrolled as private user | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Staff', auth()->user(), 'Un-enrolled from private user | Username: @'.$this->user->username);
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function flagUser()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            if ($this->user->id === 1) {
                return toast($this, 'error', 'Forbidden!');
            }
            $this->user->spammy = ! $this->user->spammy;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->spammy) {
                loggy(request(), 'Staff', auth()->user(), 'Flagged the user | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Staff', auth()->user(), 'Un-flagged the user | Username: @'.$this->user->username);
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function suspendUser()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            if ($this->user->id === 1) {
                return toast($this, 'error', 'Forbidden!');
            }
            $this->user->is_suspended = ! $this->user->is_suspended;
            if ($this->user->is_suspended) {
                $this->user->spammy = true;
                $this->spammy = true;
            } else {
                $this->user->spammy = false;
                $this->spammy = false;
            }
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_suspended) {
                loggy(request(), 'Staff', auth()->user(), 'Suspended the user | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Staff', auth()->user(), 'Un-suspended the user | Username: @'.$this->user->username);
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function enrollPatron()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $this->user->is_patron = ! $this->user->is_patron;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_patron) {
                $this->user->notify(new PatronGifted(true));
                loggy(request(), 'Staff', auth()->user(), 'Enrolled as Patron | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Staff', auth()->user(), 'Un-enrolled from Patron | Username: @'.$this->user->username);
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function verifyUser()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $this->user->is_verified = ! $this->user->is_verified;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->is_verified) {
                $this->user->notify(new UserVerified(true));
                loggy(request(), 'Staff', auth()->user(), 'Verified the user | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Staff', auth()->user(), 'Un-verified the user | Username: @'.$this->user->username);
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function enrollDarkMode()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $this->user->dark_mode = ! $this->user->dark_mode;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->dark_mode) {
                loggy(request(), 'Staff', auth()->user(), 'Enrolled to Dark mode | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Staff', auth()->user(), 'Un-enrolled from Dark mode | Username: @'.$this->user->username);
            }
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function masquerade()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            if ($this->user->id === 1) {
                return toast($this, 'error', 'Forbidden!');
            }
            loggy(request(), 'Staff', auth()->user(), 'Masqueraded | Username: @'.$this->user->username);
            Auth::loginUsingId($this->user->id);

            return redirect()->route('home');
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function resetAvatar()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            loggy(request(), 'Staff', auth()->user(), 'Resetted avatar | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->avatar = 'https://avatar.tobi.sh/'.Str::orderedUuid().'.svg?text='.strtoupper(substr($user->username, 0, 2));
            $user->save();

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function releaseUsername()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->username = strtolower(Str::random(6));
            $user->save();
            loggy(request(), 'Staff', auth()->user(), 'Released the username | Username: @'.$user->username);

            return redirect()->route('user.done', ['username' => $user->username]);
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function deleteTasks()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            loggy(request(), 'Staff', auth()->user(), 'Deleted all tasks | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            foreach ($user->tasks as $task) {
                foreach ($task->images ?? [] as $image) {
                    Storage::delete($image);
                }
            }
            $user->tasks()->delete();

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function deleteComments()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            loggy(request(), 'Staff', auth()->user(), 'Deleted all comments | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->comments()->delete();

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function deleteQuestions()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            loggy(request(), 'Staff', auth()->user(), 'Deleted all questions | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->questions()->delete();

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function deleteAnswers()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            loggy(request(), 'Staff', auth()->user(), 'Deleted all answers | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->answers()->delete();

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function deleteMilestones()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            loggy(request(), 'Staff', auth()->user(), 'Deleted all milestones | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->milestones()->delete();

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function deleteProducts()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            loggy(request(), 'Staff', auth()->user(), 'Deleted all products | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            foreach ($user->ownedProducts as $product) {
                $product->tasks()->delete();
                $product->webhooks()->delete();
                $avatar = explode('storage/', $product->avatar);
                if (array_key_exists(1, $avatar)) {
                    Storage::delete($avatar[1]);
                }
            }
            $user->ownedProducts()->delete();

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function deleteUser()
    {
        if (auth()->check() && auth()->user()->is_staff) {
            loggy(request(), 'Staff', auth()->user(), 'Deleted the user | Username: @'.$this->user->username);
            if ($this->user->id === 1) {
                return toast($this, 'error', 'Forbidden!');
            }

            $user = User::find($this->user->id);
            // Delete Task Images
            foreach ($user->tasks as $task) {
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
        } else {
            return toast($this, 'error', 'Forbidden!');
        }
    }

    public function updateUserStaffNotes()
    {
        $this->validate([
            'staff_notes' => ['nullable'],
        ]);

        User::where('id', $this->user->id)->update(['staff_notes' => $this->staff_notes]);

        loggy(request(), 'Staff', auth()->user(), 'Updated the staff notes for user: @'.$this->user->username);

        return toast($this, 'success', 'Note has been updated!');
    }

    public function render()
    {
        return view('livewire.user.moderator', [
            'user' => $this->readyToLoad ? $this->user : [],
        ]);
    }
}
