<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Notifications\Logger;
use App\Notifications\PatronGifted;
use App\Notifications\UserVerified;
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
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Enrolled Beta'
                    )
                );
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-enrolled Beta'
                    )
                );
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
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Enrolled Staff'
                    )
                );
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-enrolled Staff'
                    )
                );
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
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Enrolled Contributor'
                    )
                );
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-enrolled Contributor'
                    )
                );
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
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Enrolled Private account'
                    )
                );
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-enrolled Private account'
                    )
                );
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
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Flagged'
                    )
                );
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-flagged'
                    )
                );
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
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Suspended'
                    )
                );
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-suspended'
                    )
                );
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
                $this->user->notify(new PatronGifted(true));
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Enrolled Patron'
                    )
                );
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-enrolled Patron'
                    )
                );
            }
        } else {
            return false;
        }
    }

    public function verifyUser()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $this->user->isVerified = ! $this->user->isVerified;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isVerified) {
                $this->user->notify(new UserVerified(true));
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Verified'
                    )
                );
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-verified'
                    )
                );
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
            if ($this->user->darkMode) {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Enabled Darkmode'
                    )
                );
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Disabled Darkmode'
                    )
                );
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
            $this->user->notify(
                new Logger(
                    'MOD',
                    Auth::user(),
                    $this->user,
                    'Masqueraded'
                )
            );
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
            $this->user->notify(
                new Logger(
                    'MOD',
                    Auth::user(),
                    $this->user,
                    'Deleted all tasks'
                )
            );

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
            $user->comments()->delete();
            $this->user->notify(
                new Logger(
                    'MOD',
                    Auth::user(),
                    $this->user,
                    'Deleted all comments'
                )
            );

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
            $this->user->notify(
                new Logger(
                    'MOD',
                    Auth::user(),
                    $this->user,
                    'Deleted all questions'
                )
            );

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
            $this->user->notify(
                new Logger(
                    'MOD',
                    Auth::user(),
                    $this->user,
                    'Deleted all answers'
                )
            );

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
            $this->user->notify(
                new Logger(
                    'MOD',
                    Auth::user(),
                    $this->user,
                    'Deleted all products'
                )
            );

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
                $product->task()->delete();
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

    public function render()
    {
        return view('livewire.user.moderator');
    }
}
