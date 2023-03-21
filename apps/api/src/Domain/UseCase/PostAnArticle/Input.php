<?php

declare(strict_types=1);

namespace App\Domain\UseCase\PostAnArticle;

class Input
{
    public function __construct(
        public readonly string $author,
        public readonly string $title,
        public readonly string $content,
    ){
        
    }
}
