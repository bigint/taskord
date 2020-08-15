<?php

namespace App\Gamify\Badges;

use QCod\Gamify\BadgeType;

class Novice extends BadgeType
{
    /**
     * Description for badge.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Check is user qualifies for badge.
     *
     * @param $user
     * @return bool
     */
    public function qualifier($user)
    {
        return $user->getPoints() >= 500;
    }
}
