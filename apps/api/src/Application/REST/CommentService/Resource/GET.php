<?php

declare(strict_types=1);

namespace App\Application\REST\CommentService\Resource;

use App\Application\MessageBus;
use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Exception\CommentServiceNotFoundException;
use App\Domain\Model\Comment;
use App\Domain\UseCase\GetOneCommentService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class GET
{
    public function __construct(private readonly MessageBus $messageBus)
    {

    }

    #[Route('/api/articles/{articleId}/commentservices/{id}', methods:'GET')]
    public function __invoke(int $articleId, int $id): Response
    {
        try {
            /**
             * @var GetOneCommentService\Output
             */
            $output = $this->messageBus->handle(new GetOneCommentService\Input($articleId, $id));
        } catch (ArticleNotFoundException $articleNotFoundException) {
            throw new NotFoundHttpException(
                previous: $articleNotFoundException
            );
        } catch (CommentServiceNotFoundException $commentServiceNotFoundException) {
            throw new NotFoundHttpException(
                previous: $commentServiceNotFoundException
            );
        }

        return new JsonResponse($this->serialize($output), Response::HTTP_OK);
    }

    /**
     * @return array<string, array<Comment>|int>
     */
    private function serialize(GetOneCommentService\Output $output): array
    {
        return [
            'id' => $output->commentService->getId(),
            'article' => $output->commentService->getArticle()->getId(),
            'comments' => $this->serializeComments($output->commentService->getComments()),
        ];
    }

    private function serializeComments(array $comments)
    {
        return array_map(
            fn (Comment $comment): array => [
                'id' => $comment->getId(),
                'author' => $comment->getAuthor(),
                'content' => $comment->getContent()
            ],
            [...$comments]
        );
    }
}
