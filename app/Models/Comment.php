<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Nicolaslopezj\Searchable\SearchableTrait;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Comment extends Model
{
    use CanBeLiked;
    use QueryCacheable;
    use HasFactory;
    use SearchableTrait;

    public $cacheFor = 3600;
    public $cacheTags = ['comments'];
    public $cachePrefix = 'comments_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'task_id',
        'comment',
        'hidden',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'task_id' => 'integer',
        'comment' => 'string',
        'hidden' => 'boolean',
    ];
    protected $searchable = [
        'columns' => [
            'comments.comment' => 10,
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
     * @return BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(CommentReply::class);
    }
}
