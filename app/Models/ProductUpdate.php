<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Multicaret\Acquaintances\Traits\CanBeLiked;
use Rennokki\QueryCache\Traits\QueryCacheable;

class ProductUpdate extends Model
{
    use CanBeLiked;
    use QueryCacheable;
    use HasFactory;

    public $cacheFor = 3600;
    public $cacheTags = ['product_updates'];
    public $cachePrefix = 'product_updates_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'user_id',
        'product_id',
        'title',
        'body',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'product_id' => 'integer',
        'title' => 'string',
        'body' => 'string',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
