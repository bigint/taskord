<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Notifications\Admin\ContributorEnabled;
use App\Notifications\Admin\PatronGifted;
use App\Notifications\Admin\UserVerified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class Moderator extends Component
{
    public User $user;
    public $staff_notes;
    public $readyToLoad = false;

    public function mount($user)
    {
        $this->user = $user;
        $this->staff_notes = $user->staff_notes;
    }

    public function loadModerator()
    {
        $this->readyToLoad = true;
    }

    public function enrollBeta()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            $this->user->isBeta = ! $this->user->isBeta;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isBeta) {
                loggy(request(), 'Admin', auth()->user(), 'Enrolled to Beta | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Admin', auth()->user(), 'Un-enrolled from Beta | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function enrollStaff()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            if ($this->user->id === 1) {
                return false;
            }
            $this->user->isStaff = ! $this->user->isStaff;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isStaff) {
                loggy(request(), 'Admin', auth()->user(), 'Enrolled as Staff | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Admin', auth()->user(), 'Un-enrolled from Staff | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function enrollDeveloper()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            $this->user->isDeveloper = ! $this->user->isDeveloper;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isDeveloper) {
                $this->user->notify(new ContributorEnabled(true));
                loggy(request(), 'Admin', auth()->user(), 'Enrolled as Contributor | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Admin', auth()->user(), 'Un-enrolled from Contributor | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function privateUser()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            if ($this->user->id === 1) {
                return false;
            }
            $this->user->isPrivate = ! $this->user->isPrivate;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isPrivate) {
                loggy(request(), 'Admin', auth()->user(), 'Enrolled as private user | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Admin', auth()->user(), 'Un-enrolled from private user | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function flagUser()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            if ($this->user->id === 1) {
                return false;
            }
            $this->user->isFlagged = ! $this->user->isFlagged;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isFlagged) {
                loggy(request(), 'Admin', auth()->user(), 'Flagged the user | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Admin', auth()->user(), 'Un-flagged the user | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function suspendUser()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            if ($this->user->id === 1) {
                return false;
            }
            $this->user->isSuspended = ! $this->user->isSuspended;
            if ($this->user->isSuspended) {
                $this->user->isFlagged = true;
            } else {
                $this->user->isFlagged = false;
            }
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isSuspended) {
                loggy(request(), 'Admin', auth()->user(), 'Suspended the user | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Admin', auth()->user(), 'Un-suspended the user | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function enrollPatron()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            $this->user->isPatron = ! $this->user->isPatron;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isPatron) {
                $this->user->notify(new PatronGifted(true));
                loggy(request(), 'Admin', auth()->user(), 'Enrolled as Patron | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Admin', auth()->user(), 'Un-enrolled from Patron | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function verifyUser()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            $this->user->isVerified = ! $this->user->isVerified;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isVerified) {
                $this->user->notify(new UserVerified(true));
                loggy(request(), 'Admin', auth()->user(), 'Verified the user | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Admin', auth()->user(), 'Un-verified the user | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function enrollDarkMode()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            $this->user->darkMode = ! $this->user->darkMode;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->darkMode) {
                loggy(request(), 'Admin', auth()->user(), 'Enrolled to Dark mode | Username: @'.$this->user->username);
            } else {
                loggy(request(), 'Admin', auth()->user(), 'Un-enrolled from Dark mode | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function masquerade()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            if ($this->user->id === 1) {
                return false;
            }
            loggy(request(), 'Admin', auth()->user(), 'Masqueraded | Username: @'.$this->user->username);
            Auth::loginUsingId($this->user->id);

            return redirect()->route('home');
        } else {
            return false;
        }
    }

    public function resetAvatar()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            loggy(request(), 'Admin', auth()->user(), 'Resetted avatar | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->avatar = 'https://avatar.tobi.sh/'.md5($user->email).'.svg?text='.strtoupper(substr($user->username, 0, 2));
            $user->save();

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function releaseUsername()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->username = strtolower(Str::random(6));
            $user->save();
            loggy(request(), 'Admin', auth()->user(), 'Released the username | Username: @'.$user->username);

            return redirect()->route('user.done', ['username' => $user->username]);
        } else {
            return false;
        }
    }

    public function deleteTasks()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            loggy(request(), 'Admin', auth()->user(), 'Deleted all tasks | Username: @'.$this->user->username);
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
            return false;
        }
    }

    public function deleteComments()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            loggy(request(), 'Admin', auth()->user(), 'Deleted all comments | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->comments()->delete();

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteQuestions()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            loggy(request(), 'Admin', auth()->user(), 'Deleted all questions | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->questions()->delete();

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteAnswers()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            loggy(request(), 'Admin', auth()->user(), 'Deleted all answers | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->answers()->delete();

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteMilestones()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            loggy(request(), 'Admin', auth()->user(), 'Deleted all milestones | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->milestones()->delete();

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteProducts()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            loggy(request(), 'Admin', auth()->user(), 'Deleted all products | Username: @'.$this->user->username);
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
            return false;
        }
    }

    public function deleteUser()
    {
        if (auth()->check() && auth()->user()->isStaff) {
            loggy(request(), 'Admin', auth()->user(), 'Deleted the user | Username: @'.$this->user->username);
            if ($this->user->id === 1) {
                return false;
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
            return false;
        }
    }

    public function updateUserStaffNotes()
    {
        $this->validate([
            'staff_notes' => ['nullable'],
        ]);

        User::where('id', $this->user->id)->update(['staff_notes' => $this->staff_notes]);

        loggy(request(), 'Admin', auth()->user(), 'Updated the staff notes for user: @'.$this->user->username);

        return $this->dispatchBrowserEvent('toast', [
            'type' => 'success',
            'body' => 'Note has been updated!',
        ]);
    }

    public function render()
    {
        return view('livewire.user.moderator', [
            'user' => $this->readyToLoad ? $this->user : [],
        ]);
    }
}
