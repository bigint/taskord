<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function milestone()
    {
        return $this->belongsTo(Milestone::class);
    }

    public function oembed()
    {
        return $this->hasOne(Oembed::class);
    }
}
