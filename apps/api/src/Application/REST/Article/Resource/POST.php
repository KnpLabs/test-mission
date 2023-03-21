<?php

declare(strict_types=1);

namespace App\Application\REST\Article\Resource;

use App\Application\MessageBus;
use App\Application\Validation\JsonSchema\Object\Article\ArticleSchema;
use App\Domain\UseCase\PostAnArticle;
use KnpLabs\JsonSchemaBundle\Exception\JsonSchemaException;
use KnpLabs\JsonSchemaBundle\RequestHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class POST
{
    public function __construct(
        private readonly MessageBus $messageBus,
        private readonly RequestHandler $requestHandler
    ){

    }

    #[Route('/api/articles', methods: 'POST')]
    public function __invoke(Request $request): Response
    {
        try {
            $data = $this->requestHandler->extractJson($request, ArticleSchema::class);

        } catch (JsonSchemaException $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST, json: true);
        }

        /**
         * @var PostAnArticle\Output
         */
        $output = $this->messageBus->handle(new PostAnArticle\Input($data['author'], $data['title'], $data['content']));

        return new JsonResponse($this->serialize($output), Response::HTTP_CREATED);
    }

    /**
     * @return array<string, ?scalar>
     */
    private function serialize(PostAnArticle\Output $output): array
    {
        return [
            'author' => $output->article->getAuthor(),
            'title' => $output->article->getTitle(),
            'content' => $output->article->getContent()
        ];
    }
}
