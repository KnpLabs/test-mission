<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetAllCommentServices;

use App\Domain\Repository\CommentServices;

class Handler
{
    public function __construct(private readonly CommentServices $commentServices)
    {

    }

    public function __invoke(Input $input): Output
    {
        return new Output($this->commentServices->findAll());
    }
}
