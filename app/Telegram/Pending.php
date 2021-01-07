<?php

namespace App\Telegram;

use App\Models\Task;
use App\Models\User;
use Telegram;

class Pending
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

        $tasks = Task::cacheFor(60 * 60)
            ->where([
                ['user_id', $this->user->id],
                ['done', false],
            ])
            ->get();

        if (count($tasks) > 0) {
            $res = [];
            foreach ($tasks as $task) {
                array_push($res, '⏳ *'.$task->task.'* [#'.$task->id.'](https://taskord.com/task/'.$task->id.')');
            }

            return $this->send($this->user->telegram_chat_id, implode("\n\n", $res));
        } else {
            return $this->send($this->user->telegram_chat_id, '*All done!* No pending tasks 👏');
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
