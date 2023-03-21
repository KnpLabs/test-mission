<?php

declare(strict_types=1);

namespace spec\App\Domain\UseCase\GetAllArticles;

use App\Domain\Model\Article;
use App\Domain\Repository\Articles;
use App\Domain\UseCase\GetAllArticles\Handler;
use App\Domain\UseCase\GetAllArticles\Input;
use App\Domain\UseCase\GetAllArticles\Output;
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

    function it_returns_all_articles($articles, Article $article1, Article $article2): void
    {
        $input = new Input();

        $articles->findAll()->willReturn([$article1, $article2]);

        $output = $this->__invoke($input);
        $output->shouldHaveType(Output::class);
        $output->articles->shouldBeLike([$article1, $article2]);
    }
}
