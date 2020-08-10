<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class TaskComment extends Model
{
    use QueryCacheable;

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

    public function task_comment_praise()
    {
        return $this->hasMany(\App\Models\TaskCommentPraise::class);
    }
}
