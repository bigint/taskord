<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;

class Task extends Model
{
    use CanBeLiked;

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
