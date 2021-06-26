<?php

namespace App\Models;

use Conner\Tagging\Taggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Nicolaslopezj\Searchable\SearchableTrait;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Question extends Model implements Viewable
{
    use InteractsWithViews;
    use CanBeLiked, CanBeSubscribed;
    use Taggable;
    use QueryCacheable;
    use HasFactory;
    use SearchableTrait;

    public $cacheFor = 3600;
    public $cacheTags = ['questions'];
    public $cachePrefix = 'questions_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'body',
        'is_solvable',
        'solved',
        'patron_only',
        'hidden',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'slug' => 'string',
        'title' => 'string',
        'body' => 'string',
        'is_solvable' => 'boolean',
        'solved' => 'boolean',
        'patron_only' => 'boolean',
        'hidden' => 'boolean',
    ];
    protected $searchable = [
        'columns' => [
            'questions.title' => 10,
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
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
