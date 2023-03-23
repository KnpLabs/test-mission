<?php

declare(strict_types=1);

namespace App\Application\REST\CommentService\Collection;

use App\Application\MessageBus;
use App\Domain\UseCase\GetAllCommentServices;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GET
{
    public function __construct(private MessageBus $messageBus)
    {

    }

    #[Route('/api/commentservices', methods: 'GET')]
    public function __invoke(): Response
    {
        /**
         * @var GetAllCommentServices\Output
         */
        $output = $this->messageBus->handle(new GetAllCommentServices\Input());

        return new JsonResponse(
            [
                ...$this->serialize($output)
            ], 
            Response::HTTP_OK
        );
    }

    /**
     * @return iterable<array<string, mixed>>
     */
    private function serialize(GetAllCommentServices\Output $output): iterable
    {
        foreach ($output->commentServices as $commentService) {
            yield [
                'id' => $commentService->getId(),
                'article' => $commentService->getArticle()->getId(),

            ];
        }
    }
}
