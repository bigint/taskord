<?php

namespace App\Notifications\Slack;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewPraise extends Notification implements ShouldQueue
{
    use Queueable;

    protected $type;
    protected $entity;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($type, $entity, $user)
    {
        $this->type = $type;
        $this->entity = $entity;
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
        if ($this->type === 'TASK') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->success()
                ->content('A task was praised by @'.$this->user->username.' to @'.$this->entity->user->username)
                ->attachment(function ($attachment) {
                    $attachment->title('Praised by @'.$this->entity->user->username, 'https://taskord.com/@'.$this->entity->user->username)
                               ->fields([
                                   'Task' => $this->entity->task,
                                   'ID' => $this->entity->id,
                                   'Praise Count' => $this->entity->likes()->count(),
                               ]);
                });
        } elseif ($this->type === 'COMMENT') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->success()
                ->content('A comment was praised by @'.$this->user->username.' to @'.$this->entity->user->username)
                ->attachment(function ($attachment) {
                    $attachment->title('Praised by @'.$this->entity->user->username, 'https://taskord.com/@'.$this->entity->user->username)
                               ->fields([
                                   'Comment' => $this->entity->comment,
                                   'ID' => $this->entity->id,
                                   'Praise Count' => $this->entity->likes()->withType(\App\Models\TaskComment::class)->count('id'),
                               ]);
                });
        } elseif ($this->type === 'QUESTION') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->success()
                ->content('A question was praised by @'.$this->user->username.' to @'.$this->entity->user->username)
                ->attachment(function ($attachment) {
                    $attachment->title('Praised by @'.$this->entity->user->username, 'https://taskord.com/@'.$this->entity->user->username)
                               ->fields([
                                   'Question' => $this->entity->title,
                                   'ID' => $this->entity->id,
                                   'Praise Count' => $this->entity->question_praise->count(),
                               ]);
                });
        } elseif ($this->type === 'ANSWER') {
            return (new SlackMessage)
                ->from('Taskord Bot', ':robot_face:')
                ->to('#logs')
                ->success()
                ->content('A answer was praised by @'.$this->user->username.' to @'.$this->entity->user->username)
                ->attachment(function ($attachment) {
                    $attachment->title('Praised by @'.$this->entity->user->username, 'https://taskord.com/@'.$this->entity->user->username)
                               ->fields([
                                   'Question' => $this->entity->answer,
                                   'ID' => $this->entity->id,
                                   'Praise Count' => $this->entity->answer_praise->count(),
                               ]);
                });
        }
    }
}
