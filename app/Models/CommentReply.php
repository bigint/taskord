<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
