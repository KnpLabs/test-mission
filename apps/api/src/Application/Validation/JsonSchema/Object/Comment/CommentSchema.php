<?php

declare(strict_types=1);

namespace App\Application\Validation\JsonSchema\Object\Comment;

use KnpLabs\JsonSchema\JsonSchema;
use KnpLabs\JsonSchema\ObjectSchema;

/**
 * @extends ObjectSchema<CommentSchema>
 */
class CommentSchema extends ObjectSchema
{
    public function __construct()
    {
        $this->addProperty(
            'author',
            JsonSchema::create(
                'Author',
                'Name of the author',
                ['Jane Doe'],
                JsonSchema::string()
            )
        );

        $this->addProperty(
            'content',
            JsonSchema::create(
                'Content',
                'Content',
                ['Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed gravida ut arcu ut commodo.'],
                JsonSchema::string()
            )
        );
    }

    public function getTitle(): string
    {
        return 'Schema of Comment';
    }

    public function getDescription(): string
    {
        return 'Input data to create a comment.';
    }
}
