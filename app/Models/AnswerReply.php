<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Rennokki\QueryCache\Traits\QueryCacheable;

class AnswerReply extends Model
{
    use HasFactory;
    use CanBeLiked;
    use QueryCacheable;

    public $cacheFor = 3600;
    public $cacheTags = ['answer_replies'];
    public $cachePrefix = 'answer_replies_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'answer_id',
        'reply',
        'hidden',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'answer_id' => 'integer',
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
    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}
