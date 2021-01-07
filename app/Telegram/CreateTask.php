<?php

namespace App\Telegram;

use App\Actions\CreateNewTask;
use App\Gamify\Points\TaskCreated;
use App\Models\Task;
use App\Models\User;
use GuzzleHttp\Client;
use Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Telegram;

class CreateTask
{
    protected User $user;
    protected $task;
    protected $file_id;
    protected $status;

    public function __construct(
        User $user,
        $task,
        $file_id,
        $status
    ) {
        $this->user = $user;
        $this->task = $task;
        $this->file_id = $file_id;
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

        if ($this->user->isFlagged) {
            return $this->send($this->user->telegram_chat_id, '🚩 Your account is flagged!');
        }

        if ($this->file_id) {
            $image = [];
            $client = new Client();
            $res = $client->request('GET', 'https://api.telegram.org/bot'.config('telegram.bots.taskordbot.token').'/getFile?file_id='.$this->file_id);
            $res_file_path = json_decode($res->getBody(), true)['result']['file_path'];
            $img = Image::make('https://api.telegram.org/file/bot'.config('telegram.bots.taskordbot.token').'/'.$res_file_path)
                ->encode('jpg', 80);
            $imageName = Str::random(32).'.png';
            Storage::disk('public')->put('photos/'.$imageName, (string) $img);
            $uri = 'photos/'.$imageName;
            array_push($image, $uri);
        } else {
            $image = null;
        }

        $product_id = Helper::getProductIDFromMention($this->task, $this->user);

        $task = (new CreateNewTask($this->user, [
            'product_id' =>  $product_id,
            'task' => $this->task,
            'done' => $this->status,
            'images' => $image,
            'done_at' => $this->status ? carbon() : null,
            'type' => $product_id ? 'product' : 'user',
            'source' => 'Telegram',
        ]))();

        $this->updateActivity($task);

        return $this->status ?
            $this->send($this->user->telegram_chat_id, '✅ *A new completed task has been created* [#'.$task->id.'](https://taskord.com/task/'.$task->id.')') :
            $this->send($this->user->telegram_chat_id, '⏳ *A new pending task has been created* [#'.$task->id.'](https://taskord.com/task/'.$task->id.')');
    }

    public function updateActivity(Task $task)
    {
        givePoint(new TaskCreated($task));
        $users = Helper::getUsernamesFromMentions($task->task);
        Helper::mentionUsers($users, $task, $this->user, 'task');
        $message = "Created a new task via {$task->source}";
        loggy('Task', $this->user, \sprintf('%s | Task ID: %d', $message, $task->id));
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
