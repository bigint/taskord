<?php

namespace App\Http\Livewire\User\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    public User $user;

    public function mount($user)
    {
        $this->user = $user;
    }

    public function mentionsEmail()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->taskMentionedEmail = ! $this->user->taskMentionedEmail;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "mentionsEmail" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function mentionsWeb()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->taskMentionedWeb = ! $this->user->taskMentionedWeb;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "mentionsWeb" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function taskPraisedEmail()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->taskPraisedEmail = ! $this->user->taskPraisedEmail;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "taskPraisedEmail" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function taskPraisedWeb()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->taskPraisedWeb = ! $this->user->taskPraisedWeb;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "taskPraisedWeb" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function commentPraisedEmail()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->commentPraisedEmail = ! $this->user->commentPraisedEmail;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "commentPraisedEmail" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function commentPraisedWeb()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->commentPraisedWeb = ! $this->user->commentPraisedWeb;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "commentPraisedWeb" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function questionPraisedEmail()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->questionPraisedEmail = ! $this->user->questionPraisedEmail;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "questionPraisedEmail" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function questionPraisedWeb()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->questionPraisedWeb = ! $this->user->questionPraisedWeb;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "questionPraisedWeb" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function answerPraisedEmail()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->answerPraisedEmail = ! $this->user->answerPraisedEmail;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "answerPraisedEmail" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function answerPraisedWeb()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->answerPraisedWeb = ! $this->user->answerPraisedWeb;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "answerPraisedWeb" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function commentAddedEmail()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->commentAddedEmail = ! $this->user->commentAddedEmail;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "commentAddedEmail" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function commentAddedWeb()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->commentAddedWeb = ! $this->user->commentAddedWeb;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "commentAddedWeb" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function answerAddedEmail()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->answerAddedEmail = ! $this->user->answerAddedEmail;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "answerAddedEmail" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function answerAddedWeb()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->answerAddedWeb = ! $this->user->answerAddedWeb;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "answerAddedWeb" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function userFollowedEmail()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->userFollowedEmail = ! $this->user->userFollowedEmail;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "userFollowedEmail" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function userFollowedWeb()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->userFollowedWeb = ! $this->user->userFollowedWeb;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "userFollowedWeb" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function productSubscribedWeb()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->productSubscribedWeb = ! $this->user->productSubscribedWeb;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "productSubscribedWeb" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function productSubscribedEmail()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->productSubscribedEmail = ! $this->user->productSubscribedEmail;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "productSubscribedEmail" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function productUpdatesWeb()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->productUpdatesWeb = ! $this->user->productUpdatesWeb;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "productUpdatesWeb" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }

    public function productUpdatesEmail()
    {
        if (Auth::check()) {
            if (auth()->user()->id === $this->user->id) {
                $this->user->productUpdatesEmail = ! $this->user->productUpdatesEmail;
                $this->user->save();
                loggy('User', auth()->user(), 'Toggled "productUpdatesEmail" in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
