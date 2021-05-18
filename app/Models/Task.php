<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Nicolaslopezj\Searchable\SearchableTrait;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Task extends Model implements Feedable
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
        'images' => 'array',
        'due_at' => 'datetime',
    ];

    protected $searchable = [
        'columns' => [
            'tasks.task' => 10,
        ],
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\Comment::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function milestone()
    {
        return $this->belongsTo(\App\Models\Milestone::class);
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->task);
    }

    public static function getFeedItems()
    {
    return Task::all();
    }
}
