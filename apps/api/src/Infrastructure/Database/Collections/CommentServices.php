<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Collections;

use App\Domain;
use App\Infrastructure\Database\Repository\CommentServiceRepository;

class CommentServices implements Domain\Repository\CommentServices
{
    public function __construct(private readonly CommentServiceRepository $commentServiceRepository)
    {

    }

    public function add(Domain\Model\CommentService $commentService): void
    {
        $this->commentServiceRepository->createQueryBuilder('comment_service')->getEntityManager()->persist($commentService);
    }

    public function flush(): void
    {
        $this->commentServiceRepository->createQueryBuilder('comment_service')->getEntityManager()->flush();
    }

    public function find(int $id): ?Domain\Model\CommentService
    {
        return $this->commentServiceRepository->findOneBy(['id' => $id]);
    }

    /**
     * @return array<Domain\Model\CommentService>
     */
    public function findAll(): array
    {
        return $this->commentServiceRepository->findAll();
    }
}
