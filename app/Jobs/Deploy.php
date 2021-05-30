<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class Deploy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $ip;

    public function __construct($user, $ip)
    {
        $this->user = $user;
        $this->ip = $ip;
    }

    public function handle()
    {
        if (App::environment() === 'production') {
            $client = new Client();
            $client->request('POST', 'https://gitlab.com/api/v4/projects/25370928/ref/master/trigger/pipeline', [
                'form_params' => [
                    'token' => config('services.gitlab.trigger_token'),
                    'variables[DEPLOY_USER]' => '@'.$this->user->username,
                    'variables[DEPLOY_EMAIL]' => $this->user->email,
                    'variables[DEPLOY_IP]' => $this->ip,
                    'variables[DEPLOY_ENVIRONMENT]' => App::environment(),
                ],
            ]);
        }
    }
}
