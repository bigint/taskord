<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Product extends Model
{
    use CanBeSubscribed, QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'avatar',
        'website',
        'twitter',
        'github',
        'producthunt',
        'sponsor',
        'launched',
        'launched_at',
    ];

    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function members()
    {
        return $this->belongsToMany(\App\Models\User::class)->withTimestamps();
    }

    public function task()
    {
        return $this->hasMany(\App\Models\Task::class);
    }

    public function product_update()
    {
        return $this->belongsTo(\App\Models\ProductUpdate::class);
    }

    public function webhooks()
    {
        return $this->hasMany(\App\Models\Webhook::class);
    }
}
