<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Nicolaslopezj\Searchable\SearchableTrait;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Answer extends Model
{
    use CanBeLiked;
    use HasFactory;
    use QueryCacheable;
    use SearchableTrait;

    public $cacheFor = 3600;
    public $cacheTags = ['answers'];
    public $cachePrefix = 'answers_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
        'hidden',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'question_id' => 'integer',
        'answer' => 'string',
        'hidden' => 'boolean',
    ];
    protected $searchable = [
        'columns' => [
            'answers.answer' => 10,
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
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
