<?php

namespace App\Models;

use Taskord\EloquentViewable\Contracts\Viewable;
use Taskord\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Question extends Model implements Viewable
{
    use InteractsWithViews, CanBeLiked, QueryCacheable, CanBeSubscribed;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'patronOnly',
        'hidden',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function answer()
    {
        return $this->hasMany(\App\Models\Answer::class);
    }
}
