<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelFollow\Followable;
use Overtrue\LaravelSubscribe\Traits\Subscriber;
use QCod\Gamify\Gamify;
use Rennokki\QueryCache\Traits\QueryCacheable;

class User extends Authenticatable
{
    use Notifiable, Followable, Subscriber, Gamify, QueryCacheable;

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
        return $this->hasMany('App\Task');
    }

    public function task_praise()
    {
        return $this->hasMany('App\TaskPraise');
    }

    public function task_comment()
    {
        return $this->hasMany('App\TaskComment');
    }

    public function task_comment_praise()
    {
        return $this->hasMany('App\TaskCommentPraise');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function question_praise()
    {
        return $this->hasMany('App\QuestionPraise');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function answer_praise()
    {
        return $this->hasMany('App\AnswerPraise');
    }
}
