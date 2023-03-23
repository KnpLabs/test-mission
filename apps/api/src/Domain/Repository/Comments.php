<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Comment;

interface Comments
{
    public function add(Comment $comment): void;

    public function flush(): void;

    public function find(int $id): ?Comment;

    /**
     * @return array<Comment>
     */
    public function findAll(): array;
}
