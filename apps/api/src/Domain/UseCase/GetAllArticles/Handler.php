<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetAllArticles;

use App\Domain\Repository\Articles;

class Handler
{
    public function __construct(private readonly Articles $articles)
    {
        
    }

    public function __invoke(Input $input): Output
    {
        return new Output($this->articles->findAll());
    }
}
