<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Notifications\ContributorEnabled;
use App\Notifications\Logger;
use App\Notifications\PatronGifted;
use App\Notifications\UserVerified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Moderator extends Component
{
    public User $user;

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
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Enrolled to Beta | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-enrolled Beta'
                    )
                );
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Un-enrolled from Beta | Username: @'.$this->user->username);
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
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Enrolled as Staff | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-enrolled Staff'
                    )
                );
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Un-enrolled from Staff | Username: @'.$this->user->username);
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
                $this->user->notify(new ContributorEnabled(true));
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Enrolled Contributor'
                    )
                );
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Enrolled as Contributor | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-enrolled Contributor'
                    )
                );
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Un-enrolled from Contributor | Username: @'.$this->user->username);
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
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Enrolled as private user | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-enrolled Private account'
                    )
                );
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Un-enrolled from private user | Username: @'.$this->user->username);
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
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Flagged the user | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-flagged'
                    )
                );
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Un-flagged the user | Username: @'.$this->user->username);
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
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Suspended the user | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-suspended'
                    )
                );
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Un-suspended the user | Username: @'.$this->user->username);
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
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Enrolled as Patron | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-enrolled Patron'
                    )
                );
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Un-enrolled from Patron | Username: @'.$this->user->username);
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
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Verified the user | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Un-verified'
                    )
                );
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Un-verified the user | Username: @'.$this->user->username);
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
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Enrolled to Dark mode | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        Auth::user(),
                        $this->user,
                        'Disabled Darkmode'
                    )
                );
                activity()
                    ->withProperties(['type' => 'Admin'])
                    ->log('Un-enrolled from Dark mode | Username: @'.$this->user->username);
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
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Masqueraded | Username: @'.$this->user->username);
            Auth::loginUsingId($this->user->id);

            return redirect()->route('home');
        } else {
            return false;
        }
    }

    public function deleteTasks()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Deleted all tasks | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            foreach ($user->tasks as $task) {
                foreach ($task->images ?? [] as $image) {
                    Storage::delete($image);
                }
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
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Deleted all comments | Username: @'.$this->user->username);
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
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Deleted all questions | Username: @'.$this->user->username);
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
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Deleted all answers | Username: @'.$this->user->username);
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
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Deleted all products | Username: @'.$this->user->username);
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
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('Deleted the user | Username: @'.$this->user->username);
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
}
