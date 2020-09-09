<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class AnswerPraised extends Notification implements ShouldQueue
{
    use Queueable;

    protected $answer;
    protected $user_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($answer, $user_id)
    {
        $this->answer = $answer;
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

        if ($notifiable->answerPraisedEmail) {
            array_push($pref, 'mail');
        }

        if ($notifiable->answerPraisedWeb) {
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
                    ->subject('@'.$user->username.' praised your answer')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('👏 Your answer was praised by @'.$user->username)
                    ->line($this->answer->answer)
                    ->line('Thank you for using Taskord!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'answer' => $this->answer->answer,
            'answer_id' => $this->answer->id,
            'question_id' => $this->answer->question->id,
            'user_id' => $this->user_id,
        ];
    }
}
