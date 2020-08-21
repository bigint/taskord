<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Task extends Model
{
    use QueryCacheable, Likeable;

    protected $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'product_id',
        'task',
        'done',
        'done_at',
        'image',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function comment()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    public function product()
    {
        return $this->hasOne(\App\Models\Product::class);
    }
}
