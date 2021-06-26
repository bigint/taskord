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
    public $cacheTags = ['deals'];
    public $cachePrefix = 'deals_';

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
    protected $casts = [
        'name' => 'string',
        'offer' => 'integer',
        'coupon' => 'string',
        'referral' => 'string',
        'description' => 'string',
        'website' => 'string',
        'logo' => 'string',
    ];
}
