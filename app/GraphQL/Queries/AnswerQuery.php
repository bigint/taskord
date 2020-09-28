<?php

namespace App\GraphQL\Queries;

use App\Models\Comment;

class AnswerQuery
{
    public function getAnswer($answer, array $args)
    {
        if (
            $answer->hidden or
            $answer->question->patronOnly or
            $answer->user->isFlagged
        ) {
            return null;
        }
        return $answer->answer;
    }
}
