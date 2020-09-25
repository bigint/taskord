<?php

namespace App\GraphQL\Mutations;

use App\Gamify\Points\TaskCreated;
use App\Models\Task;
use App\Notifications\TelegramLogger;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class TaskMutator
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return 'Your are rate limited, try again later!';
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return 'Your email is not verified!';
            }

            if (Auth::user()->isFlagged) {
                return 'Your account is flagged!';
            }

            $task = Task::create([
                'user_id' =>  Auth::id(),
                'product_id' =>  null,
                'task' => $args['task'],
                'done' => $args['done'],
                'done_at' => $args['done'] ? Carbon::now() : null,
                'image' => null,
                'due_at' => null,
                'type' => 'user',
                'source' => 'Taskord API',
            ]);
            givePoint(new TaskCreated($task));
            Auth::user()->notify(
                new TelegramLogger(
                    '*✅ New Task* by @'
                    .Auth::user()->username."\n\n"
                    .$task->task."\n\nhttps://taskord.com/task/"
                    .$task->id
                )
            );

            return 'Task Created';
        } else {
            return 'Fail';
        }
    }
}
