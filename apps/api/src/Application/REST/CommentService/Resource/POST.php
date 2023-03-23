<?php

declare(strict_types=1);

namespace App\Application\REST\CommentService\Resource;

use App\Application\MessageBus;
use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Exception\CommentServiceAlreadyExistsException;
use App\Domain\Model\Comment;
use App\Domain\UseCase\AddACommentService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class POST
{
    public function __construct(private readonly MessageBus $messageBus)
    {

    }

    #[Route('api/articles/{id}/commentservices', methods: 'POST')]
    public function __invoke(int $id): Response
    {
        try {
            /**
             * @var AddACommentService\Output
             */
            $output = $this->messageBus->handle(new AddACommentService\Input($id));
        } catch (ArticleNotFoundException $articleNotFoundException) {
            throw new NotFoundHttpException(
                previous: $articleNotFoundException
            );
        } catch (CommentServiceAlreadyExistsException $commentServiceAlreadyExistsException) {
            throw new NotFoundHttpException(
                previous: $commentServiceAlreadyExistsException
            );
        }

        return new JsonResponse($this->serialize($output), Response::HTTP_CREATED);
    }

    /**
     * @return array<string, array<Comment>|int>
     */
    private function serialize(AddACommentService\Output $output): array
    {
        return [
            'article' => $output->commentService->getArticle()->getId(),
            'comments' => $output->commentService->getComments(),
        ];
    }
}
