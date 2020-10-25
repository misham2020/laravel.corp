<?php

namespace App\Repository;

use App\Comment;

class CommentsRepository extends Repository
{
    public function __construct(Comment $comment)
    {
       
        $this->model = $comment;

    }
}