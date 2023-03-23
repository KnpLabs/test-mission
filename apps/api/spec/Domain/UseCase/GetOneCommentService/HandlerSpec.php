<?php

declare(strict_types=1);

namespace spec\App\Domain\UseCase\GetOneCommentService;

use App\Domain\Exception\CommentServiceNotFoundException;
use App\Domain\Model\Article;
use App\Domain\Model\CommentService;
use App\Domain\Repository\Articles;
use App\Domain\Repository\CommentServices;
use App\Domain\UseCase\GetOneCommentService\Handler;
use App\Domain\UseCase\GetOneCommentService\Input;
use App\Domain\UseCase\GetOneCommentService\Output;
use PhpSpec\ObjectBehavior;

class HandlerSpec extends ObjectBehavior
{
    function let(Articles $articles, CommentServices $commentServices): void
    {
        $this->beConstructedWith($articles, $commentServices);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Handler::class);
    }

    function it_returns_a_comment_service(
        $commentServices,
        $articles,
        Article $article,
        CommentService $commentService
    ): void {
        $articleId = 6;
        $id = 4;

        $input = new Input($articleId, $id);

        $articles->find($articleId)->willReturn($article);
        $commentServices->find($id)->willReturn($commentService);

        $output = $this($input);
        $output->shouldHaveType(Output::class);
        $output->commentService->shouldBeLike($commentService);
    }

    function it_throws_an_exception_when_the_comment_service_does_not_exist(
        $articles, 
        $commentServices,
        Article $article
    ): void {
        $articleId = 6;
        $id = 456;

        $input = new Input($articleId, $id);

        $articles->find($articleId)->willReturn($article);

        $commentServices->find($id)->willReturn(null);

        $this->shouldThrow(new CommentServiceNotFoundException($id))->during('__invoke', [$input]);
    }
}
