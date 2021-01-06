<?php

namespace App\GraphQL\Mutations;

use App\Models\Task;
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
            if (! auth()->user()->hasVerifiedEmail()) {
                return [
                    'response' => 'Your email is not verified!',
                ];
            }

            if (auth()->user()->isFlagged) {
                return [
                    'response' => 'Your account is flagged!',
                ];
            }

            $task = Task::create([
                'user_id' =>  auth()->user()->id,
                'product_id' =>  null,
                'task' => $args['task'],
                'done' => $args['done'],
                'done_at' => $args['done'] ? carbon() : null,
                'image' => null,
                'due_at' => null,
                'type' => 'user',
                'source' => $args['source'],
            ]);

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
            if (! auth()->user()->hasVerifiedEmail()) {
                return [
                    'response' => 'Your email is not verified!',
                ];
            }

            if (auth()->user()->isFlagged) {
                return [
                    'response' => 'Your account is flagged!',
                ];
            }

            $task = Task::find($args['id']);

            if ($task) {
                if ($task->user->id === auth()->user()->id) {
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
            if (auth()->user()->isFlagged) {
                return [
                    'response' => 'Your account is flagged!',
                ];
            }

            $task = Task::find($args['id']);

            if ($task) {
                if (auth()->user()->id === $task->user->id) {
                    Storage::delete($task->image);
                    $task->delete();
                    auth()->user()->touch();

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
