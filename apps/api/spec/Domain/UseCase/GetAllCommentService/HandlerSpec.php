<?php

declare(strict_types=1);

namespace spec\App\Domain\UseCase\GetAllCommentServices;

use App\Domain\Model\CommentService;
use App\Domain\Repository\CommentServices;
use App\Domain\UseCase\GetAllCommentServices\Handler;
use App\Domain\UseCase\GetAllCommentServices\Input;
use App\Domain\UseCase\GetAllCommentServices\Output;
use PhpSpec\ObjectBehavior;

class HandlerSpec extends ObjectBehavior
{
    function let(CommentServices $commentServices): void
    {
        $this->beConstructedWith($commentServices);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Handler::class);
    }

    function it_returns_all_comment_services($commentServices, CommentService $commentService1, CommentService $commentService2): void
    {
        $input = new Input();

        $commentServices->findAll()->willReturn([$commentService1, $commentService2]);

        $output = $this($input);
        $output->shouldHaveType(Output::class);
        $output->commentServices->shouldBeLike([$commentService1, $commentService2]);
    }
}
