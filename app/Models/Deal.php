<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
        'name',
        'offer',
        'coupon',
        'description',
        'website',
        'logo',
    ];
}
