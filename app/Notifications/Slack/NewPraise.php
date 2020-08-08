<?php

namespace App\Notifications\Slack;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewPraise extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($task, $user)
    {
        $this->task = $task;
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
                ->content('A task was praised by @'.$this->user->username)
                ->attachment(function ($attachment) {
                    $attachment->title('@'.$this->task->user->username, 'https://taskord.com/@'.$this->task->user->username)
                               ->fields([
                                   'Task' => $this->task->task,
                                   'ID' => $this->task->id,
                                   'Praise Count' => $this->task->task_praise->count(),
                               ]);
                });
    }
}
