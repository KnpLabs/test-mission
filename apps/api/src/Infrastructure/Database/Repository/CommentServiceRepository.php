<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Repository;

use App\Domain\Model\CommentService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommentService>
 */
final class CommentServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentService::class);
    }
}
