<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Telegram;

class TelegramController extends Controller
{
    public function getUpdates()
    {
        $updates = Telegram::getWebhookUpdates();
        error_log($updates);
        $message = $updates->message->text;
        $chat_id = $updates->message->from->id;

        if (Str::of($message)->startsWith('/pair')) {
            $token = substr($message, strpos($message, '/pair') + 6);
            $this->authUser($token, $chat_id);
        } else {
            error_log('wrong command');
            Telegram::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Please enter the valid command!',
            ]);
        }
    }

    public function authUser($token, $chat_id)
    {
        if (strlen($token) !== 60) {
            Telegram::sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text' => 'Please enter the valid API token!',
            ]);
        }

        $user = User::where('api_token', $token)->first();
        if (! $user) {
            Telegram::sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text' => 'Oops! Please check your token!',
            ]);
        }

        if ($user->telegram_chat_id) {
            Telegram::sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text' => 'You are already authenticated!',
            ]);
        } else {
            $user->telegram_chat_id = $chat_id;
            $user->save();
            Telegram::sendMessage([
                'chat_id' => $user->telegram_chat_id,
                'text' => 'You have been authenticated!',
            ]);
        }
    }
}
