<?php

declare(strict_types=1);

namespace spec\App\Domain\UseCase\GetAllComments;

use App\Domain\Model\Comment;
use App\Domain\Repository\Comments;
use App\Domain\UseCase\GetAllComments\Handler;
use App\Domain\UseCase\GetAllComments\Input;
use App\Domain\UseCase\GetAllComments\Output;
use PhpSpec\ObjectBehavior;

class HandlerSpec extends ObjectBehavior
{
    function let(Comments $comments): void
    {
        $this->beConstructedWith($comments);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Handler::class);
    }

    function it_returns_all_comments($comments, Comment $comment1, Comment $comment2): void
    {
        $input = new Input();

        $comments->findAll()->willReturn([$comment1, $comment2]);

        $output = $this($input);
        $output->shouldHaveType(Output::class);
        $output->comments->shouldBeLike([$comment1, $comment2]);
    }
}
