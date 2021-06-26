<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Meetup extends Model
{
    use CanBeSubscribed;
    use QueryCacheable;
    use HasFactory;

    public $cacheFor = 3600;
    public $cacheTags = ['meetups'];
    public $cachePrefix = 'meetups_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'tagline',
        'description',
        'location',
        'cover',
        'date',
        'hidden',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'name' => 'string',
        'slug' => 'string',
        'tagline' => 'string',
        'description' => 'string',
        'location' => 'string',
        'cover' => 'string',
        'date' => 'date',
        'hidden' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
