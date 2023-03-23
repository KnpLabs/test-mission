<?php

declare(strict_types=1);

namespace App\Domain\UseCase\GetOneComment;

use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Exception\CommentNotFoundException;
use App\Domain\Exception\CommentServiceNotFoundException;
use App\Domain\Repository\Articles;
use App\Domain\Repository\Comments;
use App\Domain\Repository\CommentServices;

class Handler
{
    public function __construct(
        private readonly Articles $articles, 
        private readonly CommentServices $commentServices,
        private readonly Comments $comments,
    ){

    }

    public function __invoke(Input $input): Output
    {
        if (null === $this->articles->find($input->articleId)) {
            throw new ArticleNotFoundException($input->articleId);
        }

        if (null === $this->commentServices->find($input->commentServiceId)) {
            throw new CommentServiceNotFoundException($input->commentServiceId);
        }

        if (null === $comment = $this->comments->find($input->id)) {
            throw new CommentNotFoundException($input->id);
        }

        return new Output($comment);
    }
}
