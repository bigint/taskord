<?php

namespace App\Http\Livewire\User;

use App\Notifications\Slack\Mod;
use App\User;
use Auth;
use Livewire\Component;
use Notification;

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
            $this->user->save();
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('BETA', $this->user, Auth::user()));
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
            $this->user->save();
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('STAFF', $this->user, Auth::user()));
        } else {
            return false;
        }
    }

    public function enrollDeveloper()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $this->user->isDeveloper = ! $this->user->isDeveloper;
            $this->user->save();
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('CONTRIBUTOR', $this->user, Auth::user()));
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
            $this->user->save();
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('FLAG', $this->user, Auth::user()));
        } else {
            return false;
        }
    }

    public function enrollPatron()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $this->user->isPatron = ! $this->user->isPatron;
            $this->user->save();
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('PATRON', $this->user, Auth::user()));
        } else {
            return false;
        }
    }

    public function enrollDarkMode()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $this->user->darkMode = ! $this->user->darkMode;
            $this->user->save();
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('DARKMODE', $this->user, Auth::user()));
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
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('MASQUERADE', $this->user, Auth::user()));
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
            $user->tasks()->delete();
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('DELETE_TASKS', $this->user, Auth::user()));

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteComments()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $user = User::find($this->user->id);
            $user->task_comment()->delete();
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('DELETE_COMMENTS', $this->user, Auth::user()));

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteQuestions()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $user = User::find($this->user->id);
            $user->questions()->delete();
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('DELETE_QUESTIONS', $this->user, Auth::user()));

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteAnswers()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $user = User::find($this->user->id);
            $user->answers()->delete();
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('DELETE_ANSWERS', $this->user, Auth::user()));

            return redirect()->route('user.done', ['username' => $this->user->username]);
        } else {
            return false;
        }
    }

    public function deleteProducts()
    {
        if (Auth::check() && Auth::user()->isStaff) {
            $user = User::find($this->user->id);
            $user->products()->delete();
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('DELETE_PRODUCTS', $this->user, Auth::user()));

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
            Notification::route('slack', env('SLACK_HOOK'))
                    ->notify(new Mod('DELETE_USER', null, Auth::user()));
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
