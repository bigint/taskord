<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Task extends Model
{
    use CanBeLiked;
    use QueryCacheable;

    public $cacheFor = 1800;

    protected $fillable = [
        'user_id',
        'product_id',
        'task',
        'done',
        'source',
        'done_at',
        'due_at',
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
        return $this->belongsTo(\App\Models\Product::class);
    }
}
