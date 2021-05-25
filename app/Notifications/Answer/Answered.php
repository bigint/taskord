<?php

namespace App\Notifications\Answer;

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

    public function __construct($answer)
    {
        $this->answer = $answer;
        $this->user_id = $answer->user->id;
    }

    public function via($notifiable)
    {
        $pref = [];

        if ($notifiable->notifications_email) {
            array_push($pref, 'mail');
        }

        if ($notifiable->notifications_web) {
            array_push($pref, 'database');
        }

        return $pref;
    }

    public function toMail($notifiable)
    {
        $user = User::find($this->user_id);

        if (! $user->spammy) {
            return (new MailMessage)
                        ->subject('@'.$user->username.' answered your question')
                        ->greeting('Hello @'.$notifiable->username.' 👋')
                        ->line('💬 Your question has new answer by @'.$user->username)
                        ->line('Question: '.$this->answer->question->title)
                        ->line('Answer: '.$this->answer->answer)
                        ->action('Go to Question', url('/question/'.$this->answer->question->id))
                        ->line('Thank you for using Taskord!');
        } else {
            return null;
        }
    }

    public function toDatabase($notifiable)
    {
        return [
            'answer_id' => $this->answer->id,
            'user_id' => $this->user_id,
        ];
    }
}
