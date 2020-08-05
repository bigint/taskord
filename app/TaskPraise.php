<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskPraise extends Model
{
    protected $fillable = ['user_id', 'task_id'];

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
