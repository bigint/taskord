<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    protected $searchable = [
        'columns' => [
            'comments.comment' => 10,
        ],
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function task()
    {
        return $this->belongsTo(\App\Models\Task::class);
    }

    public function replies()
    {
        return $this->hasMany(\App\Models\CommentReply::class);
    }
}
