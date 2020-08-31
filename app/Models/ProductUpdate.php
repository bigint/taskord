<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeLiked;

class ProductUpdate extends Model
{
    use CanBeLiked;
    
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
