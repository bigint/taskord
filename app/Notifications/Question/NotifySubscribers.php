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
    protected $userId;

    public function __construct($answer)
    {
        $this->answer = $answer;
        $this->userId = $answer->user->id;
    }

    public function via()
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $user = User::find($this->userId);

        if (! $user->spammy) {
            return (new MailMessage())
                ->subject('@'.$user->username.' answered a question you subscribe to')
                ->greeting('Hello @'.$notifiable->username.' 👋')
                ->line('💬 The question you subscribe to has a new answer by @'.$user->username)
                ->line('Question: '.$this->answer->question->title)
                ->line('Answer: '.$this->answer->answer)
                ->action('Go to Question', url('/question/'.$this->answer->question->id))
                ->line('Thank you for using Taskord!');
        }

        return null;
    }

    public function toArray()
    {
        return [
            'answer_id' => $this->answer->id,
            'user_id' => $this->userId,
        ];
    }
}
