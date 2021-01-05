<?php

namespace App\Http\Controllers;

use App\Actions\CreateNewTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Str;
use Telegram;

class TelegramController extends Controller
{
    public function getUpdates()
    {
        $updates = Telegram::getWebhookUpdates();
        if (isset($updates->message['message_id'])) {
            $message = $updates->message['text'];
            $chat_id = $updates->message['from']['id'];
        } else {
            return false;
        }

        if (Str::of($message)->startsWith('/auth')) {
            $token = substr($message, strpos($message, '/auth') + 6);
            $this->authUser($token, $chat_id);
        } elseif (Str::of($message)->startsWith('/task')) {
            $task = substr($message, strpos($message, '/todo') + 6);
            $this->createTask($task, $chat_id);
        } elseif (Str::of($message)->startsWith('/done')) {
            $id = substr($message, strpos($message, '/done') + 6);
            $this->markAsDone($id, $chat_id);
        } elseif (Str::of($message)->startsWith('/pending')) {
            $this->getPending($chat_id);
        } elseif (Str::of($message)->startsWith('/logout')) {
            $this->logout($chat_id);
        } else {
            return $this->send($chat_id, 'Please enter the valid command!');
        }
    }

    public function authUser($token, $chat_id)
    {
        if (strlen($token) !== 60) {
            return $this->send($chat_id, 'Oops! Please enter the valid API token 🔑');
        }

        $user = User::where('api_token', $token)->first();
        if (! $user) {
            return $this->send($chat_id, 'Oops! Please enter the valid API token 🔑');
        }

        if ($user->telegram_chat_id) {
            return $this->send($chat_id, 'You are already authenticated ✅');
        } else {
            $user->telegram_chat_id = $chat_id;
            $user->save();

            return $this->send($chat_id, '*Authentication successful* ✅');
        }
    }

    public function createTask($todo, $chat_id)
    {
        if (strlen($todo) < 6) {
            return $this->send($chat_id, '⚠ Task should have at least 5 characters');
        }

        if ($this->authCheck($chat_id)) {
            $user = User::where('telegram_chat_id', $chat_id)->first();

            if (! $user->hasVerifiedEmail()) {
                return $this->send($chat_id, '💌 Your email is not verified!');
            }

            if ($user->isFlagged) {
                return $this->send($chat_id, '🚩 Your account is flagged!');
            }

            $task = (new CreateNewTask($user, [
                'task' => $todo,
                'done' => false,
                'type' => 'user',
                'source' => 'Telegram',
            ]))();

            return $this->send($chat_id, '⏳ A new pending task has been Created - #'.$task->id);
        }
    }

    public function getPending($chat_id)
    {
        if ($this->authCheck($chat_id)) {
            $user = User::where('telegram_chat_id', $chat_id)->first();
            $tasks = Task::cacheFor(60 * 60)
                ->where([
                    ['user_id', $user->id],
                    ['done', false],
                ])
                ->get();

            if (count($tasks) > 0) {
                if (! $user->hasVerifiedEmail()) {
                    return $this->send($chat_id, '💌 Your email is not *verified*!');
                }

                if ($user->isFlagged) {
                    return $this->send($chat_id, '🚩 Your account is *flagged*!');
                }

                $res = [];
                foreach ($tasks as $task) {
                    array_push($res, '⏳ *'.$task->task.'* [#'.$task->id.'](https://taskord.com/task/'.$task->id.')');
                }

                return $this->send($chat_id, implode("\n\n", $res));
            } else {
                return $this->send($chat_id, '*All done!* No pending tasks 👏');
            }
        }
    }

    public function markAsDone($id, $chat_id)
    {
        if (! $id) {
            return $this->send($chat_id, '⚠ You should give *Task ID* `Eg: /done 28`');
        }

        if ($this->authCheck($chat_id)) {
            $user = User::where('telegram_chat_id', $chat_id)->first();
            $task = Task::find($id);
            if ($task) {
                if ($task->user_id !== $user->id) {
                    return $this->send($chat_id, '⚠ Forbidden!');
                }

                if (! $user->hasVerifiedEmail()) {
                    return $this->send($chat_id, '💌 Your email is not *verified*!');
                }

                if ($user->isFlagged) {
                    return $this->send($chat_id, '🚩 Your account is *flagged*!');
                }

                if ($task->done) {
                    return $this->send($chat_id, 'Task #'.$task->id.' is *already done* ✅');
                } else {
                    $task->done = true;
                    $task->done_at = carbon();
                    $task->save();

                    return $this->send($chat_id, 'Task #'.$task->id.' has been *marked as done* ✅');
                }
            } else {
                return $this->send($chat_id, 'Oops! Task not exist 🙅');
            }
        }
    }

    public function logout($chat_id)
    {
        if ($this->authCheck($chat_id)) {
            $user = User::where('telegram_chat_id', $chat_id)->first();
            if ($user) {
                $user->telegram_chat_id = null;
                $user->save();

                return $this->send($chat_id, '🚪 *Logout successful*');
            }
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
