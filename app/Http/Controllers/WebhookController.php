<?php

namespace App\Http\Controllers;

use App\Actions\CreateNewTask;
use App\Models\User;
use App\Models\Webhook;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Http\Request as WebhookRequest;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    use WithRateLimiting;

    public function createTask($webhook, $task, $done, $done_at, $product_id, $type)
    {
        $ignoreList = [
            'styleci',
            'merge pull request',
            'merge branch',
        ];

        if (! Str::contains(strtolower($task), $ignoreList)) {
            $webhook->user->touch();

            $task = (new CreateNewTask($webhook->user, [
                'user_id' => $webhook->user_id,
                'task' => $task,
                'done' => $done,
                'done_at' => $done_at,
                'product_id' => $product_id,
                'type' => $product_id ? 'product' : 'user',
                'source' => $type,
            ]))();
        }
    }

    public function simpleWebhook($request, $webhook)
    {
        $requestBody = $request->json()->all();
        if (
            ! array_key_exists('task', $requestBody) or
            ! array_key_exists('done', $requestBody)
        ) {
            return response('Invalid parameters', 422);
        }
        if ($requestBody['done']) {
            $done_at = carbon();
        } else {
            $done_at = null;
        }

        $this->createTask(
            $webhook,
            $requestBody['task'],
            $requestBody['done'],
            $done_at,
            $webhook->product_id,
            'Webhook'
        );

        return response('success', 200);
    }

    public function githubWebhook($request, $webhook)
    {
        if (Str::contains($request->header('User-Agent'), 'GitLab')) {
            return response('You are using GitHub hook which is not allowed', 422);
        }

        if ($request->header('content-type') !== 'application/json') {
            return response('Only application/json content type is allowed', 422);
        }

        if ($request->header('X-GitHub-Event') === 'ping') {
            return response('success', 200);
        }

        if ($request->header('X-GitHub-Event') !== 'push') {
            return response('Only push event is allowed', 200);
        }

        $requestBody = $request->json()->all();

        if (mb_strtolower($requestBody['sender']['type'], 'UTF-8') === 'bot') {
            return response('Bot cannot log tasks', 200);
        }

        if ($requestBody['repository']['default_branch'] !== str_replace('refs/heads/', '', $requestBody['ref'])) {
            return response('Only commits from default branch is allowed', 200);
        }

        if ($requestBody['head_commit']) {
            $commit = explode("\n\n", $requestBody['head_commit']['message'])[0];
            $task = Str::limit($commit, 100);
        } else {
            return response('No head_commit found', 200);
        }

        $this->createTask(
            $webhook,
            $task,
            true,
            carbon(),
            $webhook->product_id,
            'GitHub'
        );

        return response('success', 200);
    }

    public function gitlabWebhook($request, $webhook)
    {
        if (Str::contains($request->header('User-Agent'), 'GitHub')) {
            return response('You are using GitLab hook which is not allowed', 422);
        }

        if ($request->header('Content-Type') !== 'application/json') {
            return response('Only application/json content type is allowed', 422);
        }

        if ($request->header('X-Gitlab-Event') !== 'Push Hook') {
            return response('Only push event is allowed', 200);
        }

        $requestBody = $request->json()->all();

        if ($requestBody['project']['default_branch'] !== str_replace('refs/heads/', '', $requestBody['ref'])) {
            return response('Only commits from default branch is allowed', 200);
        }

        if (count($requestBody['commits']) >= 1) {
            $commit = explode("\n", $requestBody['commits'][0]['message'])[0];
            $task = Str::limit($commit, 100);
        } else {
            return response('No commits found', 200);
        }

        $this->createTask(
            $webhook,
            $task,
            true,
            carbon(),
            $webhook->product_id,
            'GitLab'
        );

        return response('success', 200);
    }

    public function web($token, WebhookRequest $request)
    {
        try {
            $this->rateLimit(50);
        } catch (TooManyRequestsException $exception) {
            return response('Your are rate limited, try again later', 429);
        }

        $webhook = Webhook::whereToken($token)->first();
        if (! $webhook) {
            return response('No webhook exists', 404);
        }

        if (User::find($webhook->user_id)->spammy) {
            return response('Your account is flagged', 401);
        }

        if ($webhook->type === 'web') {
            return $this->simpleWebhook($request, $webhook);
        }

        if ($webhook->type === 'github') {
            return $this->githubWebhook($request, $webhook);
        }

        if ($webhook->type === 'gitlab') {
            return $this->gitlabWebhook($request, $webhook);
        }
    }
}
