<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;

class Comment extends Model
{
    use CanBeLiked;

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
