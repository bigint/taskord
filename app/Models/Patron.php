<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patron extends Model
{
    protected $fillable = [
        'user_id',
        'checkout_id',
        'subscription_plan_id',
        'cancel_url',
        'update_url',
        'event_time',
        'next_bill_date',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
