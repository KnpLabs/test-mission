<?php

declare(strict_types=1);

namespace spec\App\Domain\UseCase\AddACommentService;

use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Exception\CommentServiceAlreadyExistsException;
use App\Domain\Model\Article;
use App\Domain\Model\CommentService;
use App\Domain\Repository\Articles;
use App\Domain\Repository\CommentServices;
use App\Domain\UseCase\AddACommentService\Handler;
use App\Domain\UseCase\AddACommentService\Input;
use App\Domain\UseCase\AddACommentService\Output;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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

    function it_adds_a_comment_service(
        $articles,
        Article $article,
        $commentServices,
    ): void {
        $articleId = 4;

        $input = new Input($articleId);

        $articles->find($articleId)->willReturn($article);

        $article->getCommentService()->willReturn(null);

        $commentServices->add(Argument::type(CommentService::class))->shouldBeCalled();
        $commentServices->flush()->shouldBeCalled();

        $output = $this($input);
        $output->shouldHaveType(Output::class);
        $output->commentService->getArticle()->shouldBeLike($article);
    }

    function it_throws_an_exception_when_the_article_associated_do_not_exist(
        $articles,
    ): void {
        $articleId = 4;

        $input = new Input($articleId);

        $articles->find($articleId)->willReturn(null);

        $this->shouldThrow(new ArticleNotFoundException($articleId))->during('__invoke', [$input]);
    }

    function it_throws_an_exception_when_the_article_associated_already_has_a_comment_service(
        $articles,
        Article $article
    ): void {
        $articleId = 4;
        $commentService = new CommentService($article->getWrappedObject());

        $input = new Input($articleId);

        $articles->find($articleId)->willReturn($article);

        $article->getCommentService()->willReturn($commentService);

        $this->shouldThrow(new CommentServiceAlreadyExistsException($articleId))->during('__invoke', [$input]);
    }
}
