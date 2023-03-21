<?php

declare(strict_types=1);

namespace App\Application\REST\Article\Resource;

use App\Application\MessageBus;
use App\Domain\UseCase\GetOneArticle;
use App\Domain\Exception\ArticleNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class GET
{
    public function __construct(private readonly MessageBus $messageBus)
    {

    }

    #[Route('/api/articles/{id}', methods:'GET')]
    public function __invoke(int $id): Response
    {
        try {
            /**
             * @var GetOneArticle\Output
             */
            $output = $this->messageBus->handle(new GetOneArticle\Input($id));
        } catch (ArticleNotFoundException $articleNotFoundException) {
            throw new NotFoundHttpException(
                previous: $articleNotFoundException
            );
        }

        return new JsonResponse($this->serialize($output), Response::HTTP_OK);
    }

    /**
     * @return array<string, ?scalar>
     */
    private function serialize(GetOneArticle\Output $output): array
    {
        return [
            'id' => $output->article->getId(),
            'author' => $output->article->getAuthor(),
            'title' => $output->article->getTitle(),
            'content' => $output->article->getContent(),
            'commentService' => null === $output->article->getCommentService() ? null : $output->article->getCommentService()->getId()
        ];
    }
}
