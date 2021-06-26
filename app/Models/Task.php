<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Nicolaslopezj\Searchable\SearchableTrait;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Task extends Model
{
    use CanBeLiked, CanBeSubscribed;
    use QueryCacheable;
    use HasFactory;
    use SearchableTrait;

    public $cacheFor = 3600;
    public $cacheTags = ['tasks'];
    public $cachePrefix = 'tasks_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'product_id',
        'task',
        'done',
        'source',
        'done_at',
        'due_at',
        'images',
        'type',
        'hidden',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'product_id' => 'integer',
        'task' => 'string',
        'done' => 'boolean',
        'source' => 'string',
        'done_at' => 'datetime',
        'due_at' => 'datetime',
        'images' => 'array',
        'type' => 'string',
        'hidden' => 'boolean',
    ];
    protected $searchable = [
        'columns' => [
            'tasks.task' => 10,
        ],
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function milestone(): BelongsTo
    {
        return $this->belongsTo(Milestone::class);
    }

    /**
     * @return HasOne
     */
    public function oembed(): HasOne
    {
        return $this->hasOne(Oembed::class);
    }
}
