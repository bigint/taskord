<?php

namespace App\GraphQL\Queries;

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
