<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
