<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Multicaret\Acquaintances\Traits\CanBeSubscribed;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Meetup extends Model
{
    use CanBeSubscribed, QueryCacheable;
}
