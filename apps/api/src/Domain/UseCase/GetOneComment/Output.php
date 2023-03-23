<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetOneComment;

use App\Domain\Model\Comment;

class Output
{
    public function __construct(public readonly Comment $comment)
    {

    }
}
