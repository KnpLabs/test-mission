<?php

declare(strict_types=1);

namespace App\Application\REST\Comment\Collection;

use App\Application\MessageBus;
use App\Domain\UseCase\GetAllComments;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GET
{
    public function __construct(private MessageBus $messageBus)
    {

    }

    #[Route('/api/comments', methods: 'GET')]
    public function __invoke(): Response
    {
        /**
         * @var GetAllComments\Output
         */
        $output = $this->messageBus->handle(new GetAllComments\Input());

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
    private function serialize(GetAllComments\Output $output): iterable
    {
        foreach ($output->comments as $comment) {
            yield [
                'id' => $comment->getId(),
                'author' => $comment->getAuthor(),
                'content' => $comment->getContent(),
                'commentService' => $comment->getCommentService()->getId(),
            ];
        }
    }
}
