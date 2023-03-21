<?php

declare(strict_types=1);

namespace App\Domain\UseCase\PostAnArticle;

use App\Domain\Model\Article;
use App\Domain\Repository\Articles;

class Handler
{
    public function __construct(private readonly Articles $articles)
    {
        
    }

    public function __invoke(Input $input): Output
    {
        $article = new Article($input->author, $input->title, $input->content);
        $this->articles->add($article);
        $this->articles->flush();

        return new Output($article);
    }
}
