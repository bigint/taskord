<?php

namespace App\Http\Livewire\User\Settings;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    public $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function taskMentionedEmail()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->taskMentionedEmail = ! $this->user->taskMentionedEmail;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function taskMentionedWeb()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->taskMentionedWeb = ! $this->user->taskMentionedWeb;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function taskPraisedEmail()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->taskPraisedEmail = ! $this->user->taskPraisedEmail;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function taskPraisedWeb()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->taskPraisedWeb = ! $this->user->taskPraisedWeb;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function commentPraisedEmail()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->commentPraisedEmail = ! $this->user->commentPraisedEmail;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function commentPraisedWeb()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->commentPraisedWeb = ! $this->user->commentPraisedWeb;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function questionPraisedEmail()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->questionPraisedEmail = ! $this->user->questionPraisedEmail;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function questionPraisedWeb()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->questionPraisedWeb = ! $this->user->questionPraisedWeb;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function answerPraisedEmail()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->answerPraisedEmail = ! $this->user->answerPraisedEmail;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function answerPraisedWeb()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->answerPraisedWeb = ! $this->user->answerPraisedWeb;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function commentAddedEmail()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->commentAddedEmail = ! $this->user->commentAddedEmail;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function commentAddedWeb()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->commentAddedWeb = ! $this->user->commentAddedWeb;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function answerAddedEmail()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->answerAddedEmail = ! $this->user->answerAddedEmail;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function answerAddedWeb()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->answerAddedWeb = ! $this->user->answerAddedWeb;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function userFollowedEmail()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->userFollowedEmail = ! $this->user->userFollowedEmail;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function userFollowedWeb()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->userFollowedWeb = ! $this->user->userFollowedWeb;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function productSubscribedWeb()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->productSubscribedWeb = ! $this->user->productSubscribedWeb;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function productSubscribedEmail()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->productSubscribedEmail = ! $this->user->productSubscribedEmail;
                $this->user->save();
            } else {
                return session()->flash('error', 'Forbidden!');
            }
        } else {
            return session()->flash('error', 'Forbidden!');
        }
    }

    public function render()
    {
        return view('livewire.user.settings.notifications');
    }
}
