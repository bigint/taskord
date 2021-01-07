<?php

namespace App\Telegram;

use App\Models\User;
use Telegram;

class Logout
{
    protected $chat_id;

    public function __construct($chat_id)
    {
        $this->chat_id = $chat_id;
    }

    public function __invoke()
    {
        $user = User::where('telegram_chat_id', $this->chat_id)->first();
        if ($user) {
            $user->telegram_chat_id = null;
            $user->save();

            return $this->send($this->chat_id, '🚪 *Logout successful*');
        }
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
