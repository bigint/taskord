<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class ProductUpdate extends Model
{
    use QueryCacheable;

    protected $cacheFor = 3600;

    protected $fillable = [
        'user_id',
        'product_id',
        'title',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}
