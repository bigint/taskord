<?php

namespace App\Telegram;

use App\Actions\CreateNewTask;
use App\Models\User;
use Helper;
use Telegram;

class CreateTask
{
    protected User $user;
    protected $task;
    protected $status;

    public function __construct(
        User $user,
        $task,
        $status
    ) {
        $this->user = $user;
        $this->task = $task;
        $this->status = $status;
    }

    public function __invoke()
    {
        if (strlen($this->task) < 5) {
            return $this->send($this->user->telegram_chat_id, '⚠ Task should have at least 5 characters');
        }

        if (! $this->user->hasVerifiedEmail()) {
            return $this->send($this->user->telegram_chat_id, '💌 Your email is not verified!');
        }

        if ($this->user->spammy) {
            return $this->send($this->user->telegram_chat_id, '🚩 Your account is flagged!');
        }

        $product_id = Helper::getProductIDFromMention($this->task, $this->user);

        $task = (new CreateNewTask($this->user, [
            'product_id' =>  $product_id,
            'task' => $this->task,
            'done' => $this->status,
            'done_at' => $this->status ? carbon() : null,
            'type' => $product_id ? 'product' : 'user',
            'source' => 'Telegram',
        ]))();

        return $this->status ?
            $this->send($this->user->telegram_chat_id, '✅ *A new completed task has been created* [#'.$task->id.'](https://taskord.com/task/'.$task->id.')') :
            $this->send($this->user->telegram_chat_id, '⏳ *A new pending task has been created* [#'.$task->id.'](https://taskord.com/task/'.$task->id.')');
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
