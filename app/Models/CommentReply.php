<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Rennokki\QueryCache\Traits\QueryCacheable;

class CommentReply extends Model
{
    use HasFactory;
    use CanBeLiked;
    use QueryCacheable;

    public $cacheFor = 3600;
    public $cacheTags = ['comment_replies'];
    public $cachePrefix = 'comment_replies_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'comment_id',
        'reply',
        'hidden',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'comment_id' => 'integer',
        'reply' => 'string',
        'hidden' => 'boolean',
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
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
