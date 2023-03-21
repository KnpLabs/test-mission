<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Article;

interface Articles
{
    public function add(Article $article): void;

    public function flush(): void;

    public function find(int $id): ?Article;

    /**
     * @return array<Article>
     */
    public function findAll(): array;
}
