<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetAllComments;

use App\Domain\Repository\Comments;

class Handler
{
    public function __construct(private readonly Comments $comments)
    {

    }

    public function __invoke(Input $input): Output
    {
        return new Output($this->comments->findAll());
    }
}
