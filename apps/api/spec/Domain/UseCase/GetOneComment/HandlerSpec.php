<?php

declare(strict_types=1);

namespace spec\App\Domain\UseCase\GetOneComment;

use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Exception\CommentNotFoundException;
use App\Domain\Exception\CommentServiceNotFoundException;
use App\Domain\Model\Article;
use App\Domain\Model\Comment;
use App\Domain\Model\CommentService;
use App\Domain\Repository\Articles;
use App\Domain\Repository\Comments;
use App\Domain\Repository\CommentServices;
use App\Domain\UseCase\GetOneComment\Handler;
use App\Domain\UseCase\GetOneComment\Input;
use App\Domain\UseCase\GetOneComment\Output;
use PhpSpec\ObjectBehavior;

class HandlerSpec extends ObjectBehavior
{
    function let(Articles $articles, CommentServices $commentServices, Comments $comments): void
    {
        $this->beConstructedWith($articles, $commentServices, $comments);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Handler::class);
    }

    function it_returns_a_comment(
        $comments,
        $articles,
        $commentServices,
        Comment $comment,
        Article $article,
        CommentService $commentService
    ): void {
        $articleId = 4;
        $commentServiceId = 4;
        $id = 4;

        $input = new Input($articleId, $commentServiceId, $id);

        $articles->find($articleId)->willReturn($article);
        $commentServices->find($commentServiceId)->willReturn($commentService);
        $comments->find($id)->willReturn($comment);

        $output = $this($input);
        $output->shouldHaveType(Output::class);
        $output->comment->shouldBeLike($comment);
    }

    function it_throws_an_exception_when_the_comment_does_not_exist(
        $comments,
        $commentServices,
        $articles, 
        Article $article,
        CommentService $commentService
    ): void {
        $articleId = 4;
        $commentServiceId = 4;
        $id = 456;

        $input = new Input($articleId, $commentServiceId, $id);

        $articles->find($articleId)->willReturn($article);
        $commentServices->find($commentServiceId)->willReturn($commentService);
        $comments->find($id)->willReturn(null);

        $this->shouldThrow(new CommentNotFoundException($id))->during('__invoke', [$input]);
    }

    function it_throws_an_exception_when_the_article_does_not_exist($articles): void
    {
        $articleId = 4;
        $commentServiceId = 4;
        $id = 456;

        $input = new Input($articleId, $commentServiceId, $id);

        $articles->find($articleId)->willReturn(null);

        $this->shouldThrow(new ArticleNotFoundException($articleId))->during('__invoke', [$input]);
    }

    function it_throws_an_exception_when_the_comment_service_does_not_exist(
        $articles, 
        $commentServices,
        Article $article
    ): void {
        $articleId = 4;
        $commentServiceId = 4;
        $id = 456;

        $input = new Input($articleId, $commentServiceId, $id);

        $articles->find($articleId)->willReturn($article);
        $commentServices->find($commentServiceId)->willReturn(null);

        $this->shouldThrow(new CommentServiceNotFoundException($commentServiceId))->during('__invoke', [$input]);
    }
}
