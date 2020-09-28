<?php

namespace App\GraphQL\Queries;

use App\Models\Comment;

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
}
