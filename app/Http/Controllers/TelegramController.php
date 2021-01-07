<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Telegram\AuthUser;
use App\Telegram\CreateTask;
use App\Telegram\Logout;
use App\Telegram\Pending;
use App\Telegram\Start;
use App\Telegram\Stats;
use App\Telegram\ToggleTaskStatus;
use Illuminate\Support\Str;
use Telegram;

class TelegramController extends Controller
{
    public function getUpdates()
    {
        $updates = Telegram::getWebhookUpdates();
        if (isset($updates->message['message_id'])) {
            if (isset($updates->message['photo'])) {
                $message = isset($updates->message['caption']) ? $updates->message['caption'] : '/start';
                $file_id = $updates->message['photo'][1]['file_id'];
                $chat_id = $updates->message['from']['id'];
            } elseif (
                isset($updates->message['document']) or // Avoid Document
                isset($updates->message['sticker']) // Avoid Sticker
            ) {
                $message = '/start';
                $chat_id = $updates->message['from']['id'];
            } else {
                $message = $updates->message['text'];
                $file_id = null;
                $chat_id = $updates->message['from']['id'];
            }
        } else {
            return false;
        }

        $user = User::where('telegram_chat_id', $chat_id)->first();

        switch (true) {
            case Str::of($message)->startsWith('/start'):
                return (new Start($chat_id))();
            break;

            case Str::of($message)->startsWith('/auth'):
                $token = substr($message, strpos($message, '/auth') + 6);

                return (new AuthUser($token, $chat_id))();
            break;

            case Str::of($message)->startsWith('/todo'):
                if ($this->authCheck($chat_id)) {
                    $task = substr($message, strpos($message, '/todo') + 6);

                    return (new CreateTask($user, $task, $file_id, false))();
                }
            break;

            case Str::of($message)->startsWith('/done'):
                if ($this->authCheck($chat_id)) {
                    $task = substr($message, strpos($message, '/done') + 6);

                    return (new CreateTask($user, $task, $file_id, true))();
                }
            break;

            case Str::of($message)->startsWith('/complete'):
                if ($this->authCheck($chat_id)) {
                    $id = substr($message, strpos($message, '/complete') + 10);

                    return (new ToggleTaskStatus($user, $id, true))();
                }
            break;

            case Str::of($message)->startsWith('/uncomplete'):
                if ($this->authCheck($chat_id)) {
                    $id = substr($message, strpos($message, '/complete') + 12);

                    return (new ToggleTaskStatus($user, $id, false))();
                }
            break;

            case Str::of($message)->startsWith('/pending'):
                if ($this->authCheck($chat_id)) {
                    return (new Pending($user))();
                }
            break;

            case Str::of($message)->startsWith('/stats'):
                if ($this->authCheck($chat_id)) {
                    return (new Stats($user))();
                }
            break;

            case Str::of($message)->startsWith('/logout'):
                if ($this->authCheck($chat_id)) {
                    return (new Logout($chat_id))();
                }
            break;

            default:
                return $this->send($chat_id, 'Please enter the valid command!');
            break;
        }
    }

    public function authCheck($chat_id)
    {
        $user = User::where('telegram_chat_id', $chat_id)->first();
        if ($user) {
            return true;
        } else {
            $this->send($chat_id, '🔒 *You\'re not logged in. /auth <token> to begin*');

            return false;
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
