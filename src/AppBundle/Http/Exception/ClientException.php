<?php

namespace AppBundle\Http\Exception;

use Exception;
use RuntimeException;

class ClientException extends RuntimeException
{
    public static function createFromPrevious(Exception $exception): self
    {
        return new self($exception->getMessage(), $exception->getCode(), $exception);
    }
}
