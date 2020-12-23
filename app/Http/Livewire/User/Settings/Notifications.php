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

    public function mentionsEmail()
    {
        if (Auth::check()) {
            if (Auth::id() === $this->user->id) {
                $this->user->taskMentionedEmail = ! $this->user->taskMentionedEmail;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('mentionsEmail was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->taskMentionedWeb = ! $this->user->taskMentionedWeb;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('mentionsWeb was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->taskPraisedEmail = ! $this->user->taskPraisedEmail;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('taskPraisedEmail was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->taskPraisedWeb = ! $this->user->taskPraisedWeb;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('taskPraisedWeb was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->commentPraisedEmail = ! $this->user->commentPraisedEmail;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('commentPraisedEmail was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->commentPraisedWeb = ! $this->user->commentPraisedWeb;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('commentPraisedWeb was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->questionPraisedEmail = ! $this->user->questionPraisedEmail;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('questionPraisedEmail was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->questionPraisedWeb = ! $this->user->questionPraisedWeb;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('questionPraisedWeb was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->answerPraisedEmail = ! $this->user->answerPraisedEmail;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('answerPraisedEmail was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->answerPraisedWeb = ! $this->user->answerPraisedWeb;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('answerPraisedWeb was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->commentAddedEmail = ! $this->user->commentAddedEmail;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('commentAddedEmail was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->commentAddedWeb = ! $this->user->commentAddedWeb;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('commentAddedWeb was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->answerAddedEmail = ! $this->user->answerAddedEmail;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('answerAddedEmail was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->answerAddedWeb = ! $this->user->answerAddedWeb;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('answerAddedWeb was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->userFollowedEmail = ! $this->user->userFollowedEmail;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('userFollowedEmail was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->userFollowedWeb = ! $this->user->userFollowedWeb;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('userFollowedWeb was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->productSubscribedWeb = ! $this->user->productSubscribedWeb;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('productSubscribedWeb was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->productSubscribedEmail = ! $this->user->productSubscribedEmail;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('productSubscribedEmail was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->productUpdatesWeb = ! $this->user->productUpdatesWeb;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('productUpdatesWeb was toggled in notification settings');

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
            if (Auth::id() === $this->user->id) {
                $this->user->productUpdatesEmail = ! $this->user->productUpdatesEmail;
                $this->user->save();
                activity()
                    ->withProperties(['type' => 'User'])
                    ->log('productUpdatesEmail was toggled in notification settings');

                return $this->alert('success', 'Notification settings has been updated');
            } else {
                return $this->alert('error', 'Forbidden!');
            }
        } else {
            return $this->alert('error', 'Forbidden!');
        }
    }
}
