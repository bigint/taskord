<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class CommentPraised extends Notification implements ShouldQueue
{
    use Queueable;

    protected $comment;
    protected $user_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment, $user_id)
    {
        $this->comment = $comment;
        $this->user_id = $user_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $pref = [];

        if ($notifiable->commentPraisedEmail) {
            array_push($pref, 'mail');
        }

        if ($notifiable->commentPraisedWeb) {
            array_push($pref, 'database');
        }

        return $pref;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = User::find($this->user_id);
        
        return (new MailMessage)
                    ->subject('@'.$user->username.' praised your comment')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('👏 Your comment was praised by @'.$user->username)
                    ->line($this->comment->comment)
                    ->line('Thank you for using Taskord!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'comment' => $this->comment->comment,
            'comment_id' => $this->comment->id,
            'task_id' => $this->comment->task->id,
            'user_id' => $this->user_id,
        ];
    }
}
