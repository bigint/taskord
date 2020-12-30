<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Webhook;
use App\Notifications\VersionReleased;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use GuzzleHttp\Client;
use Helper;
use Illuminate\Http\Request as WebhookRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    public function createTask($webhook, $task, $done, $done_at, $product_id, $type)
    {
        $ignoreList = [
            'styleci',
            'merge pull request',
        ];

        if (! Str::contains(strtolower($task), $ignoreList)) {
            $webhook->user->touch();
            $task = Task::create([
                'user_id' =>  $webhook->user_id,
                'task' => $task,
                'done' => $done,
                'done_at' => $done_at,
                'product_id' => $product_id,
                'type' => $product_id ? 'product' : 'user',
                'source' => $type,
            ]);
            activity()
                ->withProperties(['type' => 'Task'])
                ->log('Created a new task via '.$type.' Task ID: '.$task->id);
        }
    }

    public function simpleWebhook($request, $webhook)
    {
        $request_body = $request->json()->all();
        if (
            ! array_key_exists('task', $request_body) or
            ! array_key_exists('done', $request_body)
        ) {
            return response('Invalid parameters', 422);
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
            $webhook->product_id,
            'Webhook'
        );

        return response('success', 200);
    }

    public function githubWebhook($request, $webhook)
    {
        if ($request->header('X-GitHub-Event') === 'ping') {
            return response('success', 200);
        }
        $request_body = $request->json()->all();

        if (! $request->header('X-GitHub-Event') === 'push') {
            return response('Only push event is allowed', 200);
        }

        if (mb_strtolower($request_body['sender']['type'], 'UTF-8') == 'bot') {
            return response('Bot cannot log tasks', 200);
        }

        if ($request_body['repository']['default_branch'] !== str_replace('refs/heads/', '', $request_body['ref'])) {
            return response('Only commits from default branch is allowed', 200);
        }

        if ($request_body['head_commit']) {
            $task = Str::limit($request_body['head_commit']['message'], 100);
        } else {
            return response('No head_commit found', 200);
        }

        $this->createTask(
            $webhook,
            $task,
            true,
            Carbon::now(),
            $webhook->product_id,
            'GitHub'
        );

        return response('success', 200);
    }

    public function gitlabWebhook($request, $webhook)
    {
        $request_body = $request->json()->all();

        if ($request->header('X-Gitlab-Event') !== 'Push Hook') {
            return response('Only push event is allowed', 200);
        }

        if ($request_body['project']['default_branch'] !== str_replace('refs/heads/', '', $request_body['ref'])) {
            return response('Only default branch is allowed', 200);
        }

        if (count($request_body['commits']) >= 1) {
            $task = Str::limit($request_body['commits'][0]['message'], 100);
        } else {
            return response('No commits found', 200);
        }

        $this->createTask(
            $webhook,
            $task,
            true,
            Carbon::now(),
            $webhook->product_id,
            'GitLab'
        );

        return response('success', 200);
    }

    public function web($token, WebhookRequest $request)
    {
        $throttler = Throttle::get(Request::instance(), 50, 5);
        $throttler->hit();
        if (count($throttler) > 60) {
            Helper::flagAccount(Auth::user());
        }
        if (! $throttler->check()) {
            activity()
                ->withProperties(['type' => 'Throttle'])
                ->log('Rate limited in Webhook');

            return response('Your are rate limited, try again later', 429);
        }

        $webhook = Webhook::where('token', $token)->first();
        if (! $webhook) {
            return response('No webhook exists', 401);
        }

        if (User::find($webhook->user_id)->isFlagged) {
            return response('Your account is flagged', 401);
        }

        if ($webhook->type === 'web') {
            return $this->simpleWebhook($request, $webhook);
        } elseif ($webhook->type === 'github') {
            return $this->githubWebhook($request, $webhook);
        } elseif ($webhook->type === 'gitlab') {
            return $this->gitlabWebhook($request, $webhook);
        }
    }

    public function newVersion($appkey)
    {
        if (env('APP_VERSION_KEY') === $appkey) {
            $client = new Client();
            $res = $client->request('POST', 'https://gitlab.com/api/graphql', [
                'form_params' => [
                    'query' => '
                    query {
                      project(fullPath: "taskord/taskord") {
                        releases(first: 1) {
                          nodes {
                            tagName
                            description
                          }
                        }
                      }
                    }',
                ],
            ]);
            $message = json_decode($res->getBody(), true)['data']['project']['releases']['nodes'][0];
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new VersionReleased($message));
            }
            activity()
                ->withProperties(['type' => 'Admin'])
                ->log('New version Webhook has been Initiated');

            return response('success', 200);
        } else {
            return response('failed', 500);
        }
    }
}
