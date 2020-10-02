<?php

namespace App\GraphQL\Mutations;

use App\Gamify\Points\TaskCreated;
use App\Models\Task;
use App\Notifications\TelegramLogger;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class TaskMutator
{
    public function create($_, array $args)
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return [
                'response' => 'Your are rate limited, try again later!',
            ];
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return [
                    'response' => 'Your email is not verified!',
                ];
            }

            if (Auth::user()->isFlagged) {
                return [
                    'response' => 'Your account is flagged!',
                ];
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
                'source' => $args['source'],
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

            return [
                'task' => $task,
                'response' => 'Task has been created!',
            ];
        } else {
            return [
                'response' => 'Login to create task!',
            ];
        }
    }

    public function praise($_, array $args)
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return [
                'response' => 'Your are rate limited, try again later!',
            ];
        }

        if (Auth::check()) {
            if (! Auth::user()->hasVerifiedEmail()) {
                return [
                    'response' => 'Your email is not verified!',
                ];
            }

            if (Auth::user()->isFlagged) {
                return [
                    'response' => 'Your account is flagged!',
                ];
            }

            $task = Task::find($args['id']);

            if ($task) {
                if ($task->user->id === Auth::id()) {
                    return [
                        'task' => $task,
                        'response' => 'You can\'t praise your own task!',
                    ];
                } else {
                    Helper::togglePraise($task, 'TASK');
                }

                return [
                    'task' => $task,
                    'response' => 'Toggle Praise Successful!',
                ];
            } else {
                return [
                    'response' => 'No task found!',
                ];
            }

            return [
                'task' => $task,
                'response' => 'Task has been created!',
            ];
        } else {
            return [
                'response' => 'Login to praise task!',
            ];
        }
    }

    public function delete($_, array $args)
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return [
                'response' => 'Your are rate limited, try again later!',
            ];
        }

        if (Auth::check()) {
            if (Auth::user()->isFlagged) {
                return [
                    'response' => 'Your account is flagged!',
                ];
            }

            $task = Task::find($args['id']);

            if ($task) {
                if (Auth::id() === $task->user->id) {
                    Storage::delete($task->image);
                    $task->delete();
                    Auth::user()->touch();

                    return [
                        'response' => 'Task deleted successfully!',
                    ];
                } else {
                    return [
                        'response' => 'Forbidden!',
                    ];
                }
            } else {
                return [
                    'response' => 'No task found!',
                ];
            }
        } else {
            return [
                'response' => 'Login to delete task!',
            ];
        }
    }
}
