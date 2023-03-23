<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetOneCommentService;

use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Exception\CommentServiceNotFoundException;
use App\Domain\Repository\Articles;
use App\Domain\Repository\CommentServices;

class Handler
{
    public function __construct(private readonly Articles $articles, private readonly CommentServices $commentServices)
    {

    }

    public function __invoke(Input $input): Output
    {
        if (null === $this->articles->find($input->articleId)) {
            throw new ArticleNotFoundException($input->articleId);
        }

        if (null === $commentService = $this->commentServices->find($input->id)) {
            throw new CommentServiceNotFoundException($input->id);
        }

        return new Output($commentService);
    }
}
