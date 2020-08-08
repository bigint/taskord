<?php

namespace App\Notifications\Slack;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class Mod extends Notification implements ShouldQueue
{
    use Queueable;

    protected $type;
    protected $target;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($type, $target, $user)
    {
        $this->type = $type;
        $this->target = $target;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        if ($this->type === 'MASQUERADE') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('MASQUERADE')
                               ->content('@'.$this->user->username.' masquerade into @'.$this->target->username);
                });
        } else if ($this->type === 'BETA') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('BETA')
                               ->content('@'.$this->user->username.' enrolled as beta for @'.$this->target->username);
                });
        } else if ($this->type === 'STAFF') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('STAFF')
                               ->content('@'.$this->user->username.' enrolled as staff for @'.$this->target->username);
                });
        } else if ($this->type === 'PATRON') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('PATRON')
                               ->content('@'.$this->user->username.' enrolled as patron for @'.$this->target->username);
                });
        } else if ($this->type === 'DARKMODE') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('DARKMODE')
                               ->content('@'.$this->user->username.' enrolled dark mode for @'.$this->target->username);
                });
        } else if ($this->type === 'CONTRIBUTOR') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('CONTRIBUTOR')
                               ->content('@'.$this->user->username.' enrolled as contributor for @'.$this->target->username);
                });
        } else if ($this->type === 'FLAG') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('FLAG')
                               ->content('@'.$this->user->username.' flagged @'.$this->target->username);
                });
        } else if ($this->type === 'DELETE_TASKS') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('DELETE_TASKS')
                               ->content('@'.$this->user->username.' deleted all tasks by @'.$this->target->username);
                });
        } else if ($this->type === 'DELETE_COMMENTS') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('DELETE_COMMENTS')
                               ->content('@'.$this->user->username.' deleted all comments by @'.$this->target->username);
                });
        } else if ($this->type === 'DELETE_QUESTIONS') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('DELETE_QUESTIONS')
                               ->content('@'.$this->user->username.' deleted all questions by @'.$this->target->username);
                });
        } else if ($this->type === 'DELETE_ANSWERS') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('DELETE_ANSWERS')
                               ->content('@'.$this->user->username.' deleted all answers by @'.$this->target->username);
                });
        } else if ($this->type === 'DELETE_PRODUCTS') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('DELETE_PRODUCTS')
                               ->content('@'.$this->user->username.' deleted all products by @'.$this->target->username);
                });
        } else if ($this->type === 'DELETE_USER') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->warning()
                ->content('⚠️ Mod Event ⚠️')
                ->attachment(function ($attachment) {
                    $attachment->title('DELETE_USER')
                               ->content('@'.$this->user->username.' deleted someone');
                });
        }
    }
}
