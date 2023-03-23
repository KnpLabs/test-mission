<?php

declare(strict_types=1);

namespace App\Domain\UseCase\AddACommentService;

use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Exception\CommentServiceAlreadyExistsException;
use App\Domain\Model\CommentService;
use App\Domain\Repository\Articles;
use App\Domain\Repository\CommentServices;

class Handler
{
    public function __construct(private readonly Articles $articles, private readonly CommentServices $commentServices)
    {

    }

    public function __invoke(Input $input): Output
    {
        if (null === $article = $this->articles->find($input->articleId)) {
            throw new ArticleNotFoundException($input->articleId);
        }

        if (null !== $article->getCommentService()) {
            throw new CommentServiceAlreadyExistsException($input->articleId);
        }

        $commentService = new CommentService($article);

        $this->commentServices->add($commentService);
        $this->commentServices->flush();

        return new Output($commentService);
    }
}
