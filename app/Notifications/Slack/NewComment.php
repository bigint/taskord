<?php

namespace App\Notifications\Slack;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewComment extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $user)
    {
        $this->comment = $comment;
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
        return (new SlackMessage)
            ->from('Taskord Bot', ':robot_face:')
            ->to('#logs')
            ->success()
            ->content('New comment was added by @'.$this->user->username.' to @'.$this->comment->task->user->username)
            ->attachment(function ($attachment) {
                $attachment->title('Commented by @'.$this->user->username, 'https://taskord.com/@'.$this->user->username)
                           ->fields([
                               'Comment' => $this->comment->comment,
                               'ID' => $this->comment->id,
                           ]);
            });
    }
}
