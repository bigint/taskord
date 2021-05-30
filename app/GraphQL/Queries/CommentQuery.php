<?php

namespace App\GraphQL\Queries;

class CommentQuery
{
    public function hasPraised($comment)
    {
        if (auth()->check()) {
            return auth()->user()->hasLiked($comment);
        }

        return null;
    }
}
