<?php

declare(strict_types=1);

namespace spec\App\Domain\UseCase\GetOneArticle;

use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Model\Article;
use App\Domain\Repository\Articles;
use App\Domain\UseCase\GetOneArticle\Handler;
use App\Domain\UseCase\GetOneArticle\Input;
use App\Domain\UseCase\GetOneArticle\Output;
use PhpSpec\ObjectBehavior;

class HandlerSpec extends ObjectBehavior
{
    function let(Articles $articles): void
    {
        $this->beConstructedWith($articles);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Handler::class);
    }

    function it_returns_an_article($articles, Article $article): void
    {
        $id = 4;

        $input = new Input($id);

        $articles->find($id)->willReturn($article);

        $output = $this->__invoke($input);
        $output->shouldHaveType(Output::class);
        $output->article->shouldBeLike($article);
    }

    function it_throws_an_exception_when_the_article_is_not_found($articles): void
    {
        $id = 456;

        $input = new Input($id);

        $articles->find($id)->willReturn(null);

        $this->shouldThrow(new ArticleNotFoundException($id))->during('__invoke', [$input]);
    }
}
