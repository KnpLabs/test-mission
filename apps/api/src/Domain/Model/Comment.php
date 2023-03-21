<?php

declare(strict_types=1);

namespace App\Domain\Model;

use DateTimeImmutable;

class Comment
{
    public int $id;
    public DateTimeImmutable $createdAt;

    public function __construct(
        public string $author,
        public string $content,
        public CommentService $commentService,
        public ?int $parentId = null,
    ){
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCommentService(): CommentService
    {
        return $this->commentService;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
