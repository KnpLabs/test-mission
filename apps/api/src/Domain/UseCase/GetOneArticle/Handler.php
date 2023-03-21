<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetOneArticle;

use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Repository\Articles;

class Handler
{
    public function __construct(private readonly Articles $articles)
    {
        
    }

    public function __invoke(Input $input): Output
    {
        if (null === $article = $this->articles->find($input->id)) {
            throw new ArticleNotFoundException($input->id);
        }

        return new Output($article);
    }
}
