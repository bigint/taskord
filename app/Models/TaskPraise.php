<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPraise extends Model
{
    protected $fillable = ['user_id', 'task_id'];

    public function task()
    {
        return $this->belongsTo(\App\Models\Task::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
