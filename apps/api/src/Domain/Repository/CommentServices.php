<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\CommentService;

interface CommentServices
{
    public function add(CommentService $commentService): void;

    public function flush(): void;

    public function find(int $id): ?CommentService;

    /**
     * @return array<CommentService>
     */
    public function findAll(): array;
}
