<?php

namespace App\GraphQL\Queries;

class AnswerQuery
{
    public function hasPraised($answer)
    {
        if (auth()->check()) {
            return auth()->user()->hasLiked($answer);
        }

        return null;
    }
}
