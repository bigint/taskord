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
        'last_ip',
        'email_verified_at',
        'api_token',
    ];
    protected $searchable = [
        'columns' => [
            'users.username' => 10,
            'users.firstname' => 9,
        ],
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentReplies()
    {
        return $this->hasMany(CommentReply::class);
    }

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function ownedProducts()
    {
        return $this->hasMany(Product::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function productUpdates()
    {
        return $this->belongsTo(ProductUpdate::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function patron()
    {
        return $this->hasOne(Patron::class);
    }

    public function webhooks()
    {
        return $this->hasMany(Webhook::class);
    }

    public function meetups()
    {
        return $this->hasMany(Meetup::class);
    }

    public function isOnline()
    {
        return Cache::has('user-online-'.$this->id);
    }

    public function sendEmailVerificationNotification()
    {
        VerifyEmailQueue::dispatch($this);
    }
}
