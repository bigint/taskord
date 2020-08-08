<?php

namespace App\Notifications\Slack;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewTask extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task)
    {
        $this->task = $task;
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
        $message = 'Famous Hello World!';

        return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->success()
                ->content('New Task has been created!')
                ->attachment(function ($attachment) {
                    $attachment->title('@'.$this->task->user->username, 'https://taskord.com/@'.$this->task->user->username)
                               ->fields([
                                   'Task' => $this->task->task,
                                   'ID' => $this->task->id,
                               ]);
                });
    }
}
