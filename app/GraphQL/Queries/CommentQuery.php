<?php

namespace App\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;

class CommentQuery
{
    public function getComment($comment, array $args)
    {
        if (
            $comment->hidden or
            $comment->user->isFlagged
        ) {
            return null;
        }

        return $comment->comment;
    }

    public function hasPraised($comment, array $args)
    {
        if (Auth::check()) {
            return user()->hasLiked($comment);
        } else {
            return null;
        }
    }
}
