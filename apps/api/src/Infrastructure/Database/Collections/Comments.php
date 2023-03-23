<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Collections;

use App\Domain;
use App\Infrastructure\Database\Repository\CommentRepository;

class Comments implements Domain\Repository\Comments
{
    public function __construct(private readonly CommentRepository $commentRepository)
    {

    }

    public function flush(): void
    {
        $this->commentRepository->createQueryBuilder('comment')->getEntityManager()->flush();
    }

    public function add(Domain\Model\Comment $comment): void
    {
        $this->commentRepository->createQueryBuilder('comment')->getEntityManager()->persist($comment);
    }

    public function find(int $id): ?Domain\Model\Comment
    {
        return $this->commentRepository->findOneBy(['id' => $id]);
    }

    /**
     * @return array<Domain\Model\Comment>
     */
    public function findAll(): array
    {
        return $this->commentRepository->findAll();
    }
}
