<?php

namespace App\GraphQL\Queries;

class QuestionQuery
{
    public function hasLiked($question)
    {
        if (auth()->check()) {
            return auth()->user()->hasLiked($question);
        }

        return null;
    }
}
