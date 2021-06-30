<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Nicolaslopezj\Searchable\SearchableTrait;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Badge extends Model
{
    use HasFactory;
    use QueryCacheable;
    use SearchableTrait;
    use CanBeSubscribed;

    public $cacheFor = 3600;
    public $cacheTags = ['badges'];
    public $cachePrefix = 'badges_';

    protected static $flushCacheOnUpdate = true;
}
