<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetAllCommentServices;

use App\Domain\Model\CommentService;

class Output
{
    /**
     * @param array<CommentService> $commentServices
     */
    public function __construct(public readonly array $commentServices)
    {
    }
}
