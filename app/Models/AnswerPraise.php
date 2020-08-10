<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerPraise extends Model
{
    protected $fillable = ['user_id', 'answer_id'];

    public function answer()
    {
        return $this->belongsTo(\App\Models\Answer::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
