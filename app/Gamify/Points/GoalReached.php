<?php

namespace App\Gamify\Points;

use QCod\Gamify\PointType;

class GoalReached extends PointType
{
    public $allowDuplicates = false;

    /**
     * Point constructor.
     *
     * @param $subject
     */
    public function __construct($subject, $award)
    {
        $this->subject = $subject;
        $this->award = $award;
    }

    public function getPoints()
    {
        return $this->award;
    }

    /**
     * User who will be receive points.
     *
     * @return mixed
     */
    public function payee()
    {
        return $this->getSubject()->user;
    }
}
