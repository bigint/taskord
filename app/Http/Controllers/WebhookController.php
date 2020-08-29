<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Webhook;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function web($token, Request $request)
    {
        $webhook = Webhook::where('token', $token)->first();
        if (! $webhook) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No webhook exists',
            ]);
        }
        $request_body = $request->json()->all();
        if (
            ! array_key_exists('task', $request_body) or
            ! array_key_exists('done', $request_body)
        ) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid parameters',
            ]);
        }
        if ($request_body['done']) {
            $done_at = Carbon::now();
        } else {
            $done_at = null;
        }
        $task = Task::create([
            'user_id' =>  $webhook->user_id,
            'task' => $request_body['task'],
            'done' => $request_body['done'],
            'done_at' => $done_at,
            'type' => 'user',
            'source' => 'Webhook',
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }
}
