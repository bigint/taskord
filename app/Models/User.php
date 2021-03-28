<?php

namespace App\Models;

use App\Jobs\VerifyEmailQueue;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Multicaret\Acquaintances\Traits\CanBeFollowed;
use Multicaret\Acquaintances\Traits\CanFollow;
use Multicaret\Acquaintances\Traits\CanLike;
use Multicaret\Acquaintances\Traits\CanSubscribe;
use Nicolaslopezj\Searchable\SearchableTrait;
use QCod\Gamify\Gamify;
use Rennokki\QueryCache\Traits\QueryCacheable;

class User extends Authenticatable implements MustVerifyEmail
{
    use CanLike;
    use Notifiable;
    use Gamify;
    use CanFollow, CanBeFollowed, CanSubscribe;
    use QueryCacheable;
    use HasFactory;
    use SearchableTrait;

    public $cacheFor = 3600;
    public $cacheTags = ['users'];
    public $cachePrefix = 'users_';
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'username',
        'firstname',
        'avatar',
        'email',
        'password',
        'provider',
        'provider_id',
        'lastIP',
        'email_verified_at',
        'api_token',
    ];

    protected $searchable = [
        'columns' => [
            'users.username' => 10,
            'users.firstname' => 9,
        ],
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    public function milestones()
    {
        return $this->hasMany(\App\Models\Milestone::class);
    }

    public function ownedProducts()
    {
        return $this->hasMany(\App\Models\Product::class);
    }

    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class);
    }

    public function product_update()
    {
        return $this->belongsTo(\App\Models\ProductUpdate::class);
    }

    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class);
    }

    public function answers()
    {
        return $this->hasMany(\App\Models\Answer::class);
    }

    public function patron()
    {
        return $this->hasOne(\App\Models\Patron::class);
    }

    public function webhooks()
    {
        return $this->hasMany(\App\Models\Webhook::class);
    }

    public function meetups()
    {
        return $this->hasMany(\App\Models\Meetup::class);
    }

    public function isOnline()
    {
        return Cache::has('user-online-'.$this->id);
    }

    public function sendEmailVerificationNotification()
    {
        VerifyEmailQueue::dispatch($this);
    }

    public function routeNotificationForDiscord()
    {
        return config('taskord.discord.webhook');
    }
}
