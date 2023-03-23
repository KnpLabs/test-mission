<?php

declare(strict_types=1);

namespace App\Application\REST\Comment\Resource;

use App\Application\MessageBus;
use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Exception\CommentNotFoundException;
use App\Domain\Exception\CommentServiceNotFoundException;
use App\Domain\UseCase\GetOneComment;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class GET
{
    public function __construct(private readonly MessageBus $messageBus)
    {

    }

    #[Route('/api/articles/{articleId}/commentservices/{commentServiceId}/comments/{id}', methods:'GET')]
    public function __invoke(int $articleId, int $commentServiceId, int $id): Response
    {
        try {
            /**
             * @var GetOneComment\Output
             */
            $output = $this->messageBus->handle(new GetOneComment\Input($articleId, $commentServiceId, $id));
        } catch (ArticleNotFoundException $articleNotFoundException) {
            throw new NotFoundHttpException(
                previous: $articleNotFoundException
            );
        } catch (CommentServiceNotFoundException $commentServiceNotFoundException) {
            throw new NotFoundHttpException(
                previous: $commentServiceNotFoundException
            );
        } catch (CommentNotFoundException $commentNotFoundException) {
            throw new NotFoundHttpException(
                previous: $commentNotFoundException
            );
        }

        return new JsonResponse($this->serialize($output), Response::HTTP_OK);
    }

    /**
     * @return array<string, ?scalar>
     */
    private function serialize(GetOneComment\Output $output): array
    {
        return [
            'id' => $output->comment->getId(),
            'author' => $output->comment->getAuthor(),
            'content' => $output->comment->getContent(),
            'commentService' => $output->comment->getCommentService()->getId(),
            'parentId' => $output->comment->getParentId(),
        ];
    }
}
