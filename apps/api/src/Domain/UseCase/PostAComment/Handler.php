<?php

declare(strict_types=1);

namespace App\Domain\UseCase\PostAComment;

use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Exception\CommentNotFoundException;
use App\Domain\Exception\CommentServiceNotFoundException;
use App\Domain\Model\Comment;
use App\Domain\Repository\Articles;
use App\Domain\Repository\Comments;
use App\Domain\Repository\CommentServices;

class Handler
{
    public function __construct(
        private readonly Comments $comments,
        private readonly Articles $articles,
        private readonly CommentServices $commentServices
    ){

    }

    public function __invoke(Input $input): Output
    {
        if (null === $this->articles->find($input->articleId)) {
            throw new ArticleNotFoundException($input->articleId);
        }

        if (null === $commentService = $this->commentServices->find($input->commentServiceId)) {
            throw new CommentServiceNotFoundException($input->commentServiceId);
        }

        if (null !== $parentId = $input->parentId) {
            if (null === $this->comments->find($parentId)) {
                throw new CommentNotFoundException(($parentId));
            }
        }

        $comment = new Comment($input->author, $input->content, $commentService, $parentId);
        $this->comments->add($comment);
        $this->comments->flush();

        return new Output($comment);
    }
}
