<?php

namespace App\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Question extends Model implements Viewable
{
    use QueryCacheable, InteractsWithViews;

    protected $cacheFor = 3600;

    protected $fillable = [
        'user_id',
        'title',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function answer()
    {
        return $this->hasMany(\App\Models\Answer::class);
    }

    public function question_praise()
    {
        return $this->hasMany(\App\Models\QuestionPraise::class);
    }
}
