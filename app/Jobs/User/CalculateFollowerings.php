<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateFollowerings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sourceUser;
    protected $targerUser;

    public function __construct($sourceUser, $targerUser)
    {
        $this->sourceUser = $sourceUser;
        $this->targerUser = $targerUser;
    }

    public function handle()
    {
        $this->sourceUser->following_count = $this->sourceUser->followings->count('id');
        $this->sourceUser->followers_count = $this->sourceUser->followers->count('id');
        $this->targerUser->following_count = $this->targerUser->followings->count('id');
        $this->targerUser->followers_count = $this->targerUser->followers->count('id');
        $this->sourceUser->save();
        $this->targerUser->save();
    }
}
