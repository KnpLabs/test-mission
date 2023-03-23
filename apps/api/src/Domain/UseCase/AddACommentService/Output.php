<?php

declare(strict_types=1);

namespace App\Domain\UseCase\AddACommentService;

use App\Domain\Model\CommentService;

class Output
{
    public function __construct(public readonly CommentService $commentService)
    {

    }
}
