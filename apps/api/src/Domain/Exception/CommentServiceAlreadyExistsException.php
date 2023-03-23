<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;

class CommentServiceAlreadyExistsException extends Exception
{
    public function __construct(int $id)
    {
        parent::__construct("The article with ID {$id} has already a comment service attached.");
    }
}
