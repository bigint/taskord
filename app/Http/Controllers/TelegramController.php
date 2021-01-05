<?php

namespace App\Http\Controllers;

use App\Actions\CreateNewTask;
use App\Models\User;
use Illuminate\Support\Str;
use Telegram;

class TelegramController extends Controller
{
    public function getUpdates()
    {
        $updates = Telegram::getWebhookUpdates();
        $message = $updates->message->text;
        $chat_id = $updates->message->from->id;

        if (Str::of($message)->startsWith('/pair')) {
            $token = substr($message, strpos($message, '/pair') + 6);
            $this->authUser($token, $chat_id);
        } elseif (Str::of($message)->startsWith('/task')) {
            $task = substr($message, strpos($message, '/todo') + 6);
            $this->createTask($task, $chat_id);
        } else {
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Please enter the valid command!',
            ]);
        }
    }

    public function authUser($token, $chat_id)
    {
        if (strlen($token) !== 60) {
            return Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Please enter the valid API token!',
            ]);
        }

        $user = User::where('api_token', $token)->first();
        if (! $user) {
            return Telegram::sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text' => 'Oops! Please check your token!',
            ]);
        }

        if ($user->telegram_chat_id) {
            return Telegram::sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text' => 'You are already authenticated!',
            ]);
        } else {
            $user->telegram_chat_id = $chat_id;
            $user->save();

            return Telegram::sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text' => 'Authentication successful!',
            ]);
        }
    }

    public function createTask($todo, $chat_id)
    {
        if (strlen($todo) < 6) {
            return Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Task should have at least 5 characters!',
            ]);
        }

        if ($this->authCheck($chat_id)) {
            $user = User::where('telegram_chat_id', $chat_id)->first();

            $task = (new CreateNewTask($user, [
                'task' => $todo,
                'done' => false,
                'type' => 'user',
                'source' => 'Telegram',
            ]))();

            return Telegram::sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text' => 'Task has been Created - #'.$task->id,
            ]);
        }
    }

    public function authCheck($chat_id)
    {
        $user = User::where('telegram_chat_id', $chat_id)->first();
        if (! $user->telegram_chat_id) {
            return Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Please Auth!',
            ]);
        } else {
            return true;
        }
    }
}
