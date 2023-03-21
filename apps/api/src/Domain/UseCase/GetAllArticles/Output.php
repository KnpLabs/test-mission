<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetAllArticles;

use App\Domain\Model\Article;

class Output
{
    /**
     * @param array<Article> $articles
     */
    public function __construct(public readonly array $articles)
    {
        
    }
}
