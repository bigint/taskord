<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Feature extends Model
{
    use HasFactory;
    use QueryCacheable;

    public $cacheFor = 3600;
    public $cacheTags = ['features'];
    public $cachePrefix = 'features_';

    protected static $flushCacheOnUpdate = true;

    protected $fillable = [
        'name',
        'description',
        'slug',
    ];
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'slug' => 'string',
    ];

    public static function enabled($slug)
    {
        $feature = self::whereSlug($slug)->first();
        if (auth()->check()) {
            if ($feature->public) {
                return true;
            }
            if (auth()->user()->staff_mode) {
                return $feature->staff ? true : false;
            }
            if (auth()->user()->is_beta) {
                return $feature->beta ? true : false;
            }
            if (auth()->user()->is_contributor) {
                return $feature->contributor ? true : false;
            }

            return false;
        }

        return $feature->public ? true : false;
    }
}
