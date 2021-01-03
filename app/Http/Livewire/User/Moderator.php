<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Notifications\ContributorEnabled;
use App\Notifications\Logger;
use App\Notifications\PatronGifted;
use App\Notifications\UserVerified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        if (Auth::check() && auth()->user()->isStaff) {
            $this->user->isBeta = ! $this->user->isBeta;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isBeta) {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Enrolled Beta'
                    )
                );
                loggy('Admin', auth()->user(), 'Enrolled to Beta | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Un-enrolled Beta'
                    )
                );
                loggy('Admin', auth()->user(), 'Un-enrolled from Beta | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function enrollStaff()
    {
        if (Auth::check() && auth()->user()->isStaff) {
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
                        auth()->user(),
                        $this->user,
                        'Enrolled Staff'
                    )
                );
                loggy('Admin', auth()->user(), 'Enrolled as Staff | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Un-enrolled Staff'
                    )
                );
                loggy('Admin', auth()->user(), 'Un-enrolled from Staff | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function enrollDeveloper()
    {
        if (Auth::check() && auth()->user()->isStaff) {
            $this->user->isDeveloper = ! $this->user->isDeveloper;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isDeveloper) {
                $this->user->notify(new ContributorEnabled(true));
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Enrolled Contributor'
                    )
                );
                loggy('Admin', auth()->user(), 'Enrolled as Contributor | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Un-enrolled Contributor'
                    )
                );
                loggy('Admin', auth()->user(), 'Un-enrolled from Contributor | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function privateUser()
    {
        if (Auth::check() && auth()->user()->isStaff) {
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
                        auth()->user(),
                        $this->user,
                        'Enrolled Private account'
                    )
                );
                loggy('Admin', auth()->user(), 'Enrolled as private user | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Un-enrolled Private account'
                    )
                );
                loggy('Admin', auth()->user(), 'Un-enrolled from private user | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function flagUser()
    {
        if (Auth::check() && auth()->user()->isStaff) {
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
                        auth()->user(),
                        $this->user,
                        'Flagged'
                    )
                );
                loggy('Admin', auth()->user(), 'Flagged the user | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Un-flagged'
                    )
                );
                loggy('Admin', auth()->user(), 'Un-flagged the user | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function suspendUser()
    {
        if (Auth::check() && auth()->user()->isStaff) {
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
                        auth()->user(),
                        $this->user,
                        'Suspended'
                    )
                );
                loggy('Admin', auth()->user(), 'Suspended the user | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Un-suspended'
                    )
                );
                loggy('Admin', auth()->user(), 'Un-suspended the user | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function enrollPatron()
    {
        if (Auth::check() && auth()->user()->isStaff) {
            $this->user->isPatron = ! $this->user->isPatron;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isPatron) {
                $this->user->notify(new PatronGifted(true));
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Enrolled Patron'
                    )
                );
                loggy('Admin', auth()->user(), 'Enrolled as Patron | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Un-enrolled Patron'
                    )
                );
                loggy('Admin', auth()->user(), 'Un-enrolled from Patron | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function verifyUser()
    {
        if (Auth::check() && auth()->user()->isStaff) {
            $this->user->isVerified = ! $this->user->isVerified;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->isVerified) {
                $this->user->notify(new UserVerified(true));
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Verified'
                    )
                );
                loggy('Admin', auth()->user(), 'Verified the user | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Un-verified'
                    )
                );
                loggy('Admin', auth()->user(), 'Un-verified the user | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function enrollDarkMode()
    {
        if (Auth::check() && auth()->user()->isStaff) {
            $this->user->darkMode = ! $this->user->darkMode;
            $this->user->timestamps = false;
            $this->user->save();
            if ($this->user->darkMode) {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Enabled Darkmode'
                    )
                );
                loggy('Admin', auth()->user(), 'Enrolled to Dark mode | Username: @'.$this->user->username);
            } else {
                $this->user->notify(
                    new Logger(
                        'MOD',
                        auth()->user(),
                        $this->user,
                        'Disabled Darkmode'
                    )
                );
                loggy('Admin', auth()->user(), 'Un-enrolled from Dark mode | Username: @'.$this->user->username);
            }
        } else {
            return false;
        }
    }

    public function masquerade()
    {
        if (Auth::check() && auth()->user()->isStaff) {
            if ($this->user->id === 1) {
                return false;
            }
            $this->user->notify(
                new Logger(
                    'MOD',
                    auth()->user(),
                    $this->user,
                    'Masqueraded'
                )
            );
            loggy('Admin', auth()->user(), 'Masqueraded | Username: @'.$this->user->username);
            Auth::loginUsingId($this->user->id);

            return redirect()->route('home');
        } else {
            return false;
        }
    }

    public function resetAvatar()
    {
        if (Auth::check() && auth()->user()->isStaff) {
            loggy('Admin', auth()->user(), 'Resetted avatar | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->avatar = 'https://avatar.tobi.sh/'.md5($user->email).'.svg?text='.strtoupper(substr($user->username, 0, 2));
            $user->save();
            $this->user->notify(
                new Logger(
                    'MOD',
                    auth()->user(),
                    $this->user,
                    'Resetted avatar'
                )
            );

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function releaseUsername()
    {
        if (Auth::check() && auth()->user()->isStaff) {
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->username = strtolower(Str::random(6));
            $user->save();
            loggy('Admin', auth()->user(), 'Released the username | Username: @'.$user->username);
            $this->user->notify(
                new Logger(
                    'MOD',
                    auth()->user(),
                    $this->user,
                    'Released the username'
                )
            );

            return redirect()->route('user.done', ['username' => $user->username]);
        } else {
            return false;
        }
    }

    public function deleteTasks()
    {
        if (Auth::check() && auth()->user()->isStaff) {
            loggy('Admin', auth()->user(), 'Deleted all tasks | Username: @'.$this->user->username);
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
                    auth()->user(),
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
        if (Auth::check() && auth()->user()->isStaff) {
            loggy('Admin', auth()->user(), 'Deleted all comments | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->comments()->delete();
            $this->user->notify(
                new Logger(
                    'MOD',
                    auth()->user(),
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
        if (Auth::check() && auth()->user()->isStaff) {
            loggy('Admin', auth()->user(), 'Deleted all questions | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->questions()->delete();
            $this->user->notify(
                new Logger(
                    'MOD',
                    auth()->user(),
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
        if (Auth::check() && auth()->user()->isStaff) {
            loggy('Admin', auth()->user(), 'Deleted all answers | Username: @'.$this->user->username);
            $user = User::find($this->user->id);
            $user->timestamps = false;
            $user->answers()->delete();
            $this->user->notify(
                new Logger(
                    'MOD',
                    auth()->user(),
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
        if (Auth::check() && auth()->user()->isStaff) {
            loggy('Admin', auth()->user(), 'Deleted all products | Username: @'.$this->user->username);
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
                    auth()->user(),
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
        if (Auth::check() && auth()->user()->isStaff) {
            loggy('Admin', auth()->user(), 'Deleted the user | Username: @'.$this->user->username);
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
}
