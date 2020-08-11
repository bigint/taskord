<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Overtrue\LaravelLike\Traits\Likeable;

class Task extends Model
{
    use QueryCacheable, Likeable;

    protected $cacheFor = 3600;

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

    public function task_comment()
    {
        return $this->hasMany(\App\Models\TaskComment::class);
    }

    public function product()
    {
        return $this->hasOne(\App\Models\Product::class);
    }
}
