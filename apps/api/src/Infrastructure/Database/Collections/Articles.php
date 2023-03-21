<?php

declare(strict_types=1);

namespace Infrastructure\Database\Collections;

use App\Domain;
use App\Infrastructure\Database\Repository\ArticleRepository;

class Articles implements Domain\Repository\Articles
{
    public function __construct(private readonly ArticleRepository $articleRepository)
    {
        
    }

    public function add(Domain\Model\Article $article): void
    {
        $this->articleRepository->createQueryBuilder('article')->getEntityManager()->persist($article);
    }

    public function flush(): void
    {
        $this->articleRepository->createQueryBuilder('article')->getEntityManager()->flush();
    }

    public function find(int $id): ?Domain\Model\Article
    {
        return $this->articleRepository->findOneBy(['id' => $id]);
    }

    /**
     * @return array<Domain\Model\Article>
     */
    public function findAll(): array
    {
        return $this->articleRepository->findAll();
    }
}
