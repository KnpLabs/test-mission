<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;

class ArticleNotFoundException extends Exception
{
    public function __construct(int $id)
    {
        parent::__construct("The article with ID {$id} was not found.");
    }
}
