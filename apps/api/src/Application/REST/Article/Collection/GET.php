<?php

declare(strict_types=1);

namespace App\Application\REST\Article\Collection;

use App\Application\MessageBus;
use App\Domain\UseCase\GetAllArticles;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GET
{
    public function __construct(private MessageBus $messageBus)
    {

    }

    #[Route('/api/articles', methods: 'GET')]
    public function __invoke(): Response
    {
        /**
         * @var GetAllArticles\Output
         */
        $output = $this->messageBus->handle(new GetAllArticles\Input());

        return new JsonResponse([
            ...$this->serialize($output)
        ], Response::HTTP_OK);
    }

    /**
     * @return iterable<array<string, mixed>>
     */
    private function serialize(GetAllArticles\Output $output): iterable
    {
        foreach ($output->articles as $article) {
            yield [
                'id' => $article->getId(),
                'author' => $article->getAuthor(),
                'title' => $article->getTitle(),
                'content' => $article->getContent(),
                'commentService' => null === $article->getCommentService() ? null : $article->getCommentService()->getId()
            ];
        }
    }
}
