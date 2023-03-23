<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetAllComments;

use App\Domain\Model\Comment;

class Output
{
    /**
     * @param array<Comment> $comments
     */
    public function __construct(public readonly array $comments)
    {

    }
}
