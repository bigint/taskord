<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Answer extends Model
{
    use CanBeLiked;
    use HasFactory;
    use QueryCacheable;

    public $cacheFor = 3600;
    protected static $flushCacheOnUpdate = true;
    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
        'hidden',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function question()
    {
        return $this->belongsTo(\App\Models\Question::class);
    }
}
