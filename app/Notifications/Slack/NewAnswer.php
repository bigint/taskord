<?php

namespace App\Notifications\Slack;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewAnswer extends Notification implements ShouldQueue
{
    use Queueable;

    protected $answer;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($answer, $user)
    {
        $this->answer = $answer;
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
            ->content('New answer was added by @'.$this->user->username.' to @'.$this->answer->question->user->username)
            ->attachment(function ($attachment) {
                $attachment->title('Answered by @'.$this->user->username, 'https://taskord.com/@'.$this->user->username)
                           ->fields([
                               'Answer' => $this->answer->answer,
                               'ID' => $this->answer->id,
                           ]);
            });
    }
}
