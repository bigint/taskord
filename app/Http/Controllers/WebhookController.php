<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Webhook;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use Illuminate\Http\Request as WebhookRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    public function createTask($webhook, $task, $done, $done_at, $type)
    {
        $ignoreList = [
            'styleci',
        ];

        if (! Str::contains(strtolower($task), $ignoreList)) {
            $task = Task::create([
                'user_id' =>  $webhook->user_id,
                'task' => $task,
                'done' => $done,
                'done_at' => $done_at,
                'type' => 'user',
                'source' => $type,
            ]);
        }
    }

    public function web($token, WebhookRequest $request)
    {
        $throttler = Throttle::get(Request::instance(), 20, 5);
        $throttler->hit();
        if (! $throttler->check()) {
            return response()->json([
                'message' => 'Your are rate limited, try again later!',
            ], 429);
        }

        $webhook = Webhook::where('token', $token)->first();
        if (! $webhook) {
            return response()->json([
                'message' => 'No webhook exists',
            ], 401);
        }

        if (User::find($webhook->user_id)->isFlagged) {
            return response()->json([
                'message' => 'Your account is flagged!',
            ], 401);
        }

        if ($webhook->type === 'web') {
            $request_body = $request->json()->all();
            if (
                ! array_key_exists('task', $request_body) or
                ! array_key_exists('done', $request_body)
            ) {
                return response()->json([
                    'message' => 'Invalid parameters',
                ], 422);
            }
            if ($request_body['done']) {
                $done_at = Carbon::now();
            } else {
                $done_at = null;
            }

            $this->createTask(
                $webhook,
                $request_body['task'],
                $request_body['done'],
                $done_at,
                'Webhook'
            );

            return response()->json([
                'status' => 'success',
            ], 200);
        } elseif ($webhook->type === 'github' or $webhook->type === 'gitlab') {
            if ($request->header('X-GitHub-Event') === 'ping') {
                return response()->json([
                    'message' => 'Webhook Connected!',
                ], 200);
            }
            $request_body = $request->json()->all();
            
            if (Str::contains($request_body['pusher']['name'], '[bot]')) {
                return response()->json([
                    'message' => 'Bot cannot log tasks!',
                ], 200);
            }
            
            if (count($request_body['commits']) === 0) {
                return response()->json([
                    'message' => 'Cannot log 0 commits to task!',
                ], 200);
            }

            if (count($request_body['commits']) === 1) {
                $task = Str::limit($request_body['commits'][0]['message'], 100).' on "'.$request_body['repository']['name'].'"';
            } else {
                $task = 'Pushed '.count($request_body['commits']).' changes to "'.$request_body['repository']['name'].'"';
            }

            $this->createTask(
                $webhook,
                $task,
                true,
                Carbon::now(),
                $webhook->type === 'github' ? 'GitHub' : 'GitLab'
            );

            return response()->json([
                'status' => 'success',
            ], 200);
        }
    }
}
