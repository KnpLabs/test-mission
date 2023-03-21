<?php

declare(strict_types=1);

namespace App\Application\Validation\JsonSchema\Article\Object;

use KnpLabs\JsonSchema\JsonSchema;
use KnpLabs\JsonSchema\ObjectSchema;

class ArticleSchema extends ObjectSchema
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
            'title',
            JsonSchema::create(
                'Title',
                'Title',
                ['Title: title'],
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
        return 'Schema of Article';
    }

    public function getDescription(): string
    {
        return 'Input data to create an article.';
    }
}
