<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Deal extends Model
{
    use QueryCacheable;
    use HasFactory;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'name',
        'offer',
        'coupon',
        'referral',
        'description',
        'website',
        'logo',
    ];
}
