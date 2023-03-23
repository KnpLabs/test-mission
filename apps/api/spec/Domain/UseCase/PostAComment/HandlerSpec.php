<?php

declare(strict_types=1);

namespace spec\App\Domain\UseCase\PostAComment;

use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Exception\CommentNotFoundException;
use App\Domain\Exception\CommentServiceNotFoundException;
use App\Domain\Model\Article;
use App\Domain\Model\Comment;
use App\Domain\Model\CommentService;
use App\Domain\Repository\Articles;
use App\Domain\Repository\Comments;
use App\Domain\Repository\CommentServices;
use App\Domain\UseCase\PostAComment\Handler;
use App\Domain\UseCase\PostAComment\Input;
use App\Domain\UseCase\PostAComment\Output;
use PhpSpec\ObjectBehavior;

class HandlerSpec extends ObjectBehavior
{
    function let(Comments $comments, Articles $articles, CommentServices $commentServices): void
    {
        $this->beConstructedWith($comments, $articles, $commentServices);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(Handler::class);
    }

    function it_posts_a_comment(
        $articles,
        $commentServices,
        $comments,
    ): void {
        $articleId = 2;
        $commentServiceId = 2;
        $input = new Input($articleId, $commentServiceId, null, 'Jane Doe', 'Lorem Ipsum');

        $article = new Article('Jane Doe', 'Title', 'Lorem Ipsum');
        $commentService = new CommentService($article);
        $comment = new Comment($input->author, $input->content, $commentService, $input->parentId);
        $articles->find($articleId)->willReturn($article);
        $commentServices->find($commentServiceId)->willReturn($commentService);

        $comments->add($comment)->shouldBeCalled();
        $comments->flush()->shouldBeCalled();

        $output = $this($input);

        $output->shouldHaveType(Output::class);
        $output->comment->getAuthor()->shouldBeLike('Jane Doe');
        $output->comment->getParentId()->shouldBeLike(null);
        $output->comment->getContent()->shouldBeLike('Lorem Ipsum');
    }

    function it_throws_an_exception_when_the_article_associated_does_not_exist(
        $articles
    ): void {
        $articleId = 2;
        $commentServiceId = 2;
        $input = new Input($articleId, $commentServiceId, null, 'Jane Doe', 'Lorem Ipsum');

        $articles->find($articleId)->willReturn(null);

        $this->shouldThrow(new ArticleNotFoundException($articleId))->during('__invoke', [$input]);
    }

    function it_throws_an_exception_when_the_comment_service_associated_does_not_exist(
        $articles,
        $commentServices,
        Article $article
    ): void {
        $articleId = 2;
        $commentServiceId = 2;
        $input = new Input($articleId, $commentServiceId, null, 'Jane Doe', 'Lorem Ipsum');

        $articles->find($articleId)->willReturn($article);
        $commentServices->find($commentServiceId)->willReturn(null);

        $this->shouldThrow(new CommentServiceNotFoundException($commentServiceId))->during('__invoke', [$input]);
    }

    function it_throws_an_exception_when_the_parent_comment_associated_does_not_exist(
        $articles,
        $commentServices,
        $comments,
        Article $article,
        CommentService $commentService
    ): void {
        $articleId = 2;
        $commentServiceId = 2;
        $parentId = 3; 
        $input = new Input($articleId, $commentServiceId, $parentId, 'Jane Doe', 'Lorem Ipsum');

        $articles->find($articleId)->willReturn($article);
        $commentServices->find($commentServiceId)->willReturn($commentService);
        $comments->find($parentId)->willReturn(null);

        $this->shouldThrow(new CommentNotFoundException($parentId))->during('__invoke', [$input]);
    }
}
