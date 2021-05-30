<?php

namespace App\Jobs;

use App\Notifications\TelegramLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class LogActivity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ip;
    protected $userAgent;
    protected $type;
    protected $user;
    protected $message;

    public function __construct($ip, $userAgent, $type, $user, $message)
    {
        $this->ip = $ip;
        $this->userAgent = $userAgent;
        $this->type = $type;
        $this->user = $user;
        $this->message = $message;
    }

    public function handle()
    {
        $geoDetails = $this->getGeoDetails();

        activity()
            ->causedBy($this->user)
            ->withProperties([
                'type' => $this->type,
                'ip' => $this->ip,
                'user_agent' => $this->userAgent,
                'location' => $this->ip === '127.0.0.1' ? null : $geoDetails['location'],
            ])
            ->log($this->message);

        return $this->user->notify(
            new TelegramLogger(
                $this->ip,
                $this->userAgent,
                $this->type,
                $this->user,
                $this->message,
                $geoDetails,
            )
        );
    }

    public function getGeoDetails()
    {
        try {
            if (App::environment() === 'production') {
                try {
                    $ipInfo = json_decode(file_get_contents('http://ip-api.com/json/'.$this->ip));
                    if ($ipInfo->status === 'fail') {
                        return null;
                    }

                    return [
                        'location' => $ipInfo->city.', '.$ipInfo->regionName.', '.$ipInfo->country,
                        'lon' => $ipInfo->lat,
                        'lat' => $ipInfo->lon,
                    ];
                } catch (Exception $e) {
                    return 'IP API Rate limited';
                }
            } else {
                return 'Test Location';
            }
        } catch (Exception $e) {
            return null;
        }
    }
}
