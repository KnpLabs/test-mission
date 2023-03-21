<?php

declare(strict_types=1);

namespace spec\App\Domain\UseCase\PostAnArticle;

use App\Domain\Model\Article;
use App\Domain\Repository\Articles;
use App\Domain\UseCase\PostAnArticle\Handler;
use App\Domain\UseCase\PostAnArticle\Input;
use App\Domain\UseCase\PostAnArticle\Output;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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

    function it_adds_an_article($articles): void
    {
        $input = new Input('Jane Doe', 'Title', 'Lorem Ipsum');
        
        $articles->add(Argument::type(Article::class))->shouldBeCalled();
        $articles->flush()->shouldBeCalled();

        $output = $this->__invoke($input);

        $output->shouldHaveType(Output::class);
        $output->article->getAuthor()->shouldBeLike('Jane Doe');
        $output->article->getTitle()->shouldBeLike('Title');
        $output->article->getContent()->shouldBeLike('Lorem Ipsum');
    }
}
