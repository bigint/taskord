<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Task extends Model
{
    use QueryCacheable;

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
        return $this->belongsTo('App\User');
    }

    public function task_praise()
    {
        return $this->hasMany('App\TaskPraise');
    }

    public function task_comment()
    {
        return $this->hasMany('App\TaskComment');
    }

    public function product()
    {
        return $this->hasOne('App\Product');
    }
}
