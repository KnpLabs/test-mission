<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetOneArticle;

class Input
{
    public function __construct(public readonly int $id)
    {
        
    }
}
