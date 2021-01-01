<?php

namespace App\GraphQL\Queries;

class QuestionQuery
{
    public function getTitle($question, array $args)
    {
        if (
            $question->hidden or
            $question->patronOnly or
            $question->user->isFlagged
        ) {
            return null;
        }

        return $question->title;
    }

    public function getBody($question, array $args)
    {
        if (
            $question->hidden or
            $question->patronOnly or
            $question->user->isFlagged
        ) {
            return null;
        }

        return $question->body;
    }

    public function hasPraised($question, array $args)
    {
        if (Auth::check()) {
            return user()->hasLiked($question);
        } else {
            return null;
        }
    }
}
