<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Milestone extends Model
{
    use CanBeLiked;
    use HasFactory;
    use QueryCacheable;

    public $cacheFor = 3600;
    public $cacheTags = ['milestones'];
    public $cachePrefix = 'milestones_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'hidden',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'hidden' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
