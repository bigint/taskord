<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCommentPraise extends Model
{
    protected $fillable = ['user_id', 'task_comment_id'];

    public function task_comment()
    {
        return $this->belongsTo(\App\Models\TaskComment::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
