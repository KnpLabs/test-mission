<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetOneCommentService;

class Input
{
    public function __construct(public readonly int $articleId, public readonly int $id)
    {

    }
}
