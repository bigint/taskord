<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Comment extends Model
{
    use QueryCacheable, Likeable;

    protected $cacheFor = 3600;

    protected $fillable = [
        'user_id',
        'task_id',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function task()
    {
        return $this->belongsTo(\App\Models\Task::class);
    }
}
