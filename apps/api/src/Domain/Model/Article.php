<?php

declare(strict_types=1);

namespace App\Domain\Model;

use DateTimeImmutable;

class Article
{
    public int $id;

    public DateTimeImmutable $createdAt;

    public ?CommentService $commentService;

    public function __construct(
        public string $author,
        public string $title,
        public string $content,
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCommentService(): ?CommentService
    {
        return $this->commentService;
    }
}
