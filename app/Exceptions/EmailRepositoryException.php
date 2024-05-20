<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class EmailRepositoryException extends Exception
{
    public function __construct(string $message = 'Something went terribly wrong.', ?Throwable $previous = null)
    {
        parent::__construct($message, 500, $previous);
    }
}
