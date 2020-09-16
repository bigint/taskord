<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'token',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
