<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetOneArticle;

use App\Domain\Model\Article;

class Output
{
    public function __construct(public readonly Article $article)
    {
        
    }
}
