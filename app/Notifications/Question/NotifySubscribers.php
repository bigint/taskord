<?php

namespace App\Notifications\Question;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifySubscribers extends Notification implements ShouldQueue
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
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $user = User::find($this->user_id);

        return (new MailMessage)
                    ->subject('@'.$user->username.' answered to the question')
                    ->greeting('Hello @'.$notifiable->username.' 👋')
                    ->line('👏 The question you subscribed has new answer by @'.$user->username)
                    ->line('Question: '.$this->answer->question->title)
                    ->line('Answer: '.$this->answer->answer)
                    ->action('Go to Question', url('/question/'.$this->answer->question->id))
                    ->line('Thank you for using Taskord!');
    }

    public function toArray($notifiable)
    {
        return [
            'answer' => $this->answer->answer,
            'question_id' => $this->answer->question->id,
            'user_id' => $this->user_id,
        ];
    }
}
