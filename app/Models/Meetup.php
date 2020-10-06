<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Meetup extends Model
{
    use CanBeSubscribed, QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'tagline',
        'description',
        'cover',
        'starts_at',
        'ends_at',
        'hidden',
    ];
    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
