<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;

class CommentNotFoundException extends Exception
{
    public function __construct(int $id)
    {
        parent::__construct("The comment with ID {$id} was not found.");
    }
}
