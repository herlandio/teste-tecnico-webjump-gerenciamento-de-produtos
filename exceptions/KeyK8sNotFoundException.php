<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;

class KeyK8sNotFoundException extends RuntimeException
{
    public function __construct($key, $code = 0, Throwable $previous = null)
    {
        $message = "Error getting key for: $key";
        parent::__construct($message, $code, $previous);
    }
}

