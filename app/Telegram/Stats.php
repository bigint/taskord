<?php

namespace App\Telegram;

use App\Models\User;
use Telegram;

class Stats
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __invoke()
    {
        if (! $this->user->hasVerifiedEmail()) {
            return $this->send($this->user->telegram_chat_id, '💌 Your email is not verified!');
        }

        if ($this->user->isFlagged) {
            return $this->send($this->user->telegram_chat_id, '🚩 Your account is flagged!');
        }

        $res = "*Your account stats ✨*\n\n"
               .'🔥 *'.number_format($this->user->getPoints())."* Reputations\n"
               .'✅ *'.number_format($this->user->tasks()->whereDone(true)->count())."* tasks completed\n"
               .'⏳ *'.number_format($this->user->tasks()->whereDone(false)->count())."* tasks pending\n"
               .'📦 *'.number_format($this->user->ownedProducts()->whereLaunched(true)->count())."* products launched\n"
               .'📦 *'.number_format($this->user->ownedProducts()->count())."* products owned\n"
               .'👥 *'.number_format($this->user->products()->count())."* products you are member of\n"
               .'💬 *'.number_format($this->user->comments()->count())."* comments posted\n"
               .'❓ *'.number_format($this->user->questions()->count())."* questions asked\n"
               .'💬 *'.number_format($this->user->answers()->count())."* questions answered\n";

        return $this->send($this->user->telegram_chat_id, $res);
    }

    public function send($chat_id, $message)
    {
        return Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => $message,
            'disable_web_page_preview' => true,
            'parse_mode' => 'Markdown',
        ]);
    }
}
