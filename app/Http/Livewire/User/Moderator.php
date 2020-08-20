<?php

namespace App\Http\Livewire\User;

use App\Jobs\ModEvents;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

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
                ModEvents::dispatch('INFO', '@'.$this->user->username.' is enrolled to beta by @'.Auth::user()->username);
            } else {
                ModEvents::dispatch('WARNING', '@'.$this->user->username.' is un-enrolled from beta by @'.Auth::user()->username);
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
                ModEvents::dispatch('INFO', '@'.$this->user->username.' is enrolled as staff by @'.Auth::user()->username);
            } else {
                ModEvents::dispatch('WARNING', '@'.$this->user->username.' is un-enrolled from staff by @'.Auth::user()->username);
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
                ModEvents::dispatch('INFO', '@'.$this->user->username.' is enrolled as contributor by @'.Auth::user()->username);
            } else {
                ModEvents::dispatch('WARNING', '@'.$this->user->username.' is un-enrolled from contributor by @'.Auth::user()->username);
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
                ModEvents::dispatch('WARNING', '@'.$this->user->username.' is marked as private user by @'.Auth::user()->username);
            } else {
                ModEvents::dispatch('WARNING', '@'.$this->user->username.' is un-marked as private user by @'.Auth::user()->username);
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
                ModEvents::dispatch('WARNING', '@'.$this->user->username.' is flagged by @'.Auth::user()->username);
            } else {
                ModEvents::dispatch('WARNING', '@'.$this->user->username.' is un-flagged by @'.Auth::user()->username);
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
                ModEvents::dispatch('WARNING', '@'.$this->user->username.' is suspended and flagged by @'.Auth::user()->username);
            } else {
                ModEvents::dispatch('WARNING', '@'.$this->user->username.' is un-suspended and un-flagged by @'.Auth::user()->username);
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
                ModEvents::dispatch('INFO', '@'.$this->user->username.' is enrolled as patron by @'.Auth::user()->username);
            } else {
                ModEvents::dispatch('WARNING', '@'.$this->user->username.' is un-enrolled as patron by @'.Auth::user()->username);
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
                ModEvents::dispatch('INFO', '@'.$this->user->username.' is enabled dark mode by @'.Auth::user()->username);
            } else {
                ModEvents::dispatch('WARNING', '@'.$this->user->username.' is disabled dark mode by @'.Auth::user()->username);
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
            ModEvents::dispatch('WARNING', '@'.Auth::user()->username.' is masqueraded into @'.$this->user->username);
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
            $user->tasks()->delete();
            ModEvents::dispatch('CRITICAL', '@'.Auth::user()->username.' deleted all tasks made by @'.$this->user->username);

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
            ModEvents::dispatch('CRITICAL', '@'.Auth::user()->username.' deleted all comments made by @'.$this->user->username);

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
            ModEvents::dispatch('CRITICAL', '@'.Auth::user()->username.' deleted all questions made by @'.$this->user->username);

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
            ModEvents::dispatch('CRITICAL', '@'.Auth::user()->username.' deleted all answers made by @'.$this->user->username);

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
            $user->products()->delete();
            ModEvents::dispatch('CRITICAL', '@'.Auth::user()->username.' deleted all products made by @'.$this->user->username);

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
            ModEvents::dispatch('CRITICAL', '@'.Auth::user()->username.' deleted the user @'.$this->user->username);
            $user->delete();

            return redirect()->route('home');
        } else {
            return false;
        }
    }

    public function render()
    {
        $user = User::find($this->user->id);
        $updated_at = Carbon::parse($user->updated_at);
        $current_date = Carbon::now();
        $isActive = $updated_at->diffInDays($current_date, false) >= 90 ? false : true;
        
        return view('livewire.user.moderator', [
            'isActive' => $isActive,
        ]);
    }
}
