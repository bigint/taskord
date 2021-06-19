<?php

namespace App\Models;

use Conner\Tagging\Taggable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'slug',
        'user_id',
        'title',
        'body',
        'is_solvable',
        'solved',
        'patron_only',
        'hidden',
    ];
    protected $searchable = [
        'columns' => [
            'questions.title' => 10,
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
