<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Answered extends Notification implements ShouldQueue
{
    use Queueable;

    protected $answer;
    protected $user_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($answer)
    {
        $this->answer = $answer;
        $this->user_id = $answer->user->id;
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

        if ($notifiable->answerAddedEmail) {
            array_push($pref, 'mail');
        }

        if ($notifiable->answerAddedWeb) {
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
                    ->subject('@'.$user->username.' answered your question')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('👏 Your question has new answer by @'.$user->username)
                    ->line('Question: '.$this->answer->question->title)
                    ->line('Answer: '.$this->answer->answer)
                    ->action('Go to Question', url('/question/'.$this->answer->question->id))
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
