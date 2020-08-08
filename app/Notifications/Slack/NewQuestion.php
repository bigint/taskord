<?php

namespace App\Notifications\Slack;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewQuestion extends Notification implements ShouldQueue
{
    use Queueable;

    protected $question;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($question, $user)
    {
        $this->question = $question;
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
            ->content('New question was added by @'.$this->user->username)
            ->attachment(function ($attachment) {
                $attachment->title('Asked by @'.$this->user->username, 'https://taskord.com/@'.$this->user->username)
                           ->fields([
                               'Title' => $this->question->title,
                               'Body' => $this->question->body,
                               'ID' => $this->question->id,
                           ]);
            });
    }
}
