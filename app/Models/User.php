<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelFollow\Followable;
use Overtrue\LaravelLike\Traits\Liker;
use QCod\Gamify\Gamify;
use Rennokki\QueryCache\Traits\QueryCacheable;

class User extends Authenticatable
{
    use Notifiable, Followable, Liker, Gamify, QueryCacheable;

    protected $cacheFor = 3600;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'firstname',
        'avatar',
        'email',
        'password',
        'provider',
        'provider_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tasks()
    {
        return $this->hasMany(\App\Models\Task::class);
    }

    public function task_praise()
    {
        return $this->hasMany(\App\Models\TaskPraise::class);
    }

    public function task_comment()
    {
        return $this->hasMany(\App\Models\TaskComment::class);
    }

    public function task_comment_praise()
    {
        return $this->hasMany(\App\Models\TaskCommentPraise::class);
    }

    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }

    public function product_update()
    {
        return $this->belongsTo(\App\Models\ProductUpdate::class);
    }

    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class);
    }

    public function question_praise()
    {
        return $this->hasMany(\App\Models\QuestionPraise::class);
    }

    public function answers()
    {
        return $this->hasMany(\App\Models\Answer::class);
    }

    public function answer_praise()
    {
        return $this->hasMany(\App\Models\AnswerPraise::class);
    }
}
