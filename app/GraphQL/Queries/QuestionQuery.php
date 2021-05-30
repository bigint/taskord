<?php

namespace App\GraphQL\Queries;

class QuestionQuery
{
    public function hasPraised($question)
    {
        if (auth()->check()) {
            return auth()->user()->hasLiked($question);
        }

        return null;
    }
}
