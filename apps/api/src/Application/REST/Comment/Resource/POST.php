<?php

declare(strict_types=1);

namespace App\Application\REST\Comment\Resource;

use App\Application\MessageBus;
use App\Application\Validation\JsonSchema\Object\Comment\CommentSchema;
use App\Domain\Exception\ArticleNotFoundException;
use App\Domain\Exception\CommentNotFoundException;
use App\Domain\Exception\CommentServiceNotFoundException;
use App\Domain\UseCase\PostAComment;
use KnpLabs\JsonSchemaBundle\Exception\JsonSchemaException;
use KnpLabs\JsonSchemaBundle\RequestHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class POST
{
    public function __construct(
        private readonly MessageBus $messageBus,
        private readonly RequestHandler $requestHandler
    ){

    }

    #[Route('/api/articles/{articleId}/commentservices/{commentServiceId}/comments/{$id}', requirements: ['articleId' => '\d+', 'commentServiceId' => '\d+'], methods: 'POST')]
    public function __invoke(Request $request, int $articleId, int $commentServiceId, int $id = null): Response
    {
        try {
            $data = $this->requestHandler->extractJson($request, CommentSchema::class);
        } catch (JsonSchemaException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST, json: true);
        }

        try {
            /**
             * @var PostAComment\Output
             */
            $output = $this->messageBus->handle(new PostAComment\Input($articleId, $commentServiceId, $id, $data['author'], $data['content']));
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

        return new JsonResponse($this->serialize($output), Response::HTTP_CREATED);
    }

    /**
     * @return array<string, ?scalar>
     */
    private function serialize(PostAComment\Output $output): array
    {
        return [
            'author' => $output->comment->getAuthor(),
            'content' => $output->comment->getContent(),
            'commentService' => $output->comment->getCommentService()->getId(),
            'parentId' => $output->comment->getParentId(),
        ];
    }
}
