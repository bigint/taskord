<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;

class Product extends Model
{
    use CanBeSubscribed;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'avatar',
        'website',
        'twitter',
        'github',
        'producthunt',
        'launched',
        'launched_at',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function task()
    {
        return $this->hasMany(\App\Models\Task::class);
    }

    public function product_update()
    {
        return $this->belongsTo(\App\Models\ProductUpdate::class);
    }
}
