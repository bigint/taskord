<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Notifications\TelegramLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Moderator extends Component
{
    public $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function enrollBeta()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $this->user->isBeta = ! $this->user->isBeta;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isBeta) {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is enrolled to beta by @'.Auth::user()->username));
            } else {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is un-enrolled from beta by @'.Auth::user()->username));
            }
        } else {
            return false;
        }
    }

    public function enrollStaff()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            if ($this->user->id === 1) {
                return false;
            }
            $this->user->isStaff = ! $this->user->isStaff;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isStaff) {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is enrolled as staff by @'.Auth::user()->username));
            } else {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is un-enrolled from staff by @'.Auth::user()->username));
            }
        } else {
            return false;
        }
    }

    public function enrollDeveloper()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $this->user->isDeveloper = ! $this->user->isDeveloper;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isDeveloper) {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is enrolled as contributor by @'.Auth::user()->username));
            } else {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is un-enrolled from contributor by @'.Auth::user()->username));
            }
        } else {
            return false;
        }
    }

    public function privateUser()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            if ($this->user->id === 1) {
                return false;
            }
            $this->user->isPrivate = ! $this->user->isPrivate;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isPrivate) {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is marked as private user by @'.Auth::user()->username));
            } else {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is marked as public user by @'.Auth::user()->username));
            }
        } else {
            return false;
        }
    }

    public function flagUser()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            if ($this->user->id === 1) {
                return false;
            }
            $this->user->isFlagged = ! $this->user->isFlagged;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isFlagged) {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is flagged by @'.Auth::user()->username));
            } else {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is un-flagged by @'.Auth::user()->username));
            }
        } else {
            return false;
        }
    }

    public function suspendUser()
    {
        if (Auth::check() && Auth::user()->isStaff) {
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
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is suspended and flagged by @'.Auth::user()->username));
            } else {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is un-suspended and un-flagged by @'.Auth::user()->username));
            }
        } else {
            return false;
        }
    }

    public function enrollPatron()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $this->user->isPatron = ! $this->user->isPatron;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isPatron) {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is enrolled as patron by @'.Auth::user()->username));
            } else {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is un-enrolled from patron by @'.Auth::user()->username));
            }
        } else {
            return false;
        }
    }

    public function enrollDarkMode()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $this->user->darkMode = ! $this->user->darkMode;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isPatron) {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is enabled dark mode by @'.Auth::user()->username));
            } else {
                $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".$this->user->username.' is disabled dark mode by @'.Auth::user()->username));
            }
        } else {
            return false;
        }
    }

    public function masquerade()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            if ($this->user->id === 1) {
                return false;
            }
            $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".Auth::user()->username.' is masqueraded into @'.$this->user->username));
            Auth::loginUsingId($this->user->id);

            return redirect()->route('home');
        } else {
            return false;
        }
    }

    public function deleteTasks()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            foreach ($user->tasks as $task) {
                Storage::delete($task->image);
            }
            $user->tasks()->delete();
            $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".Auth::user()->username.' deleted all tasks made by @'.$this->user->username));

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteComments()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->comment()->delete();
            $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".Auth::user()->username.' deleted all comments made by @'.$this->user->username));

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteQuestions()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->questions()->delete();
            $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".Auth::user()->username.' deleted all questions made by @'.$this->user->username));

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteAnswers()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->answers()->delete();
            $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".Auth::user()->username.' deleted all answers made by @'.$this->user->username));

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteProducts()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            foreach ($user->ownedProducts as $product) {
                $product->task()->delete();
                $product->webhooks()->delete();
                $avatar = explode('storage/', $product->avatar);
                if (array_key_exists(1, $avatar)) {
                    Storage::delete($avatar[1]);
                }
            }
            $user->ownedProducts()->delete();
            $this->user->notify(new TelegramLogger("*🚨 Mod Event 🚨*\n\n@".Auth::user()->username.' deleted all products made by @'.$this->user->username));

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteUser()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            if ($this->user->id === 1) {
                return false;
            }
            $user = User::find($this->user->id);
            // Delete Task Images
            foreach ($user->tasks as $task) {
                Storage::delete($task->image);
            }
            // Delete Product Logos
            foreach ($user->ownedProducts as $product) {
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

    public function render()
    {
        return view('livewire.user.moderator');
    }
}
