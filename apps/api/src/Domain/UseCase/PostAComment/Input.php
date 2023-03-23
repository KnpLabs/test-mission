<?php

declare(strict_types=1);

namespace App\Domain\UseCase\PostAComment;

class Input
{
    public function __construct(
        public readonly int $articleId,
        public readonly int $commentServiceId,
        public readonly ?int $parentId,
        public readonly string $author,
        public readonly string $content,
    ){

    }
}
