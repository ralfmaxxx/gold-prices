<?php

namespace AppBundle\Repository\Api\Exception;

use AppBundle\Http\Configuration\Response;
use AppBundle\Http\Exception\ClientException;
use RuntimeException;

class RepositoryException extends RuntimeException
{
    private const ERROR_MESSAGE_PATTERN = 'Could not fetch data: "%s"';

    private const COULD_NOT_DECODE_MESSAGE_PATTERN = 'Could not decode to json: "%s"';

    private const COULD_CREATE_ENTITIES_MESSAGE_PATTERN = 'Could not create entities from: "%s"';

    public static function from(ClientException $exception): self
    {
        return new self(
            sprintf(self::ERROR_MESSAGE_PATTERN, $exception->getMessage()),
            $exception->getCode(),
            $exception
        );
    }

    public static function coundNotDecode(Response $response): self
    {
        $getAsString = true;

        return new self(
            sprintf(
                self::COULD_NOT_DECODE_MESSAGE_PATTERN,
                var_export($response->get(), $getAsString)
            )
        );
    }

    public static function couldNotCreateEntities(array $responseArray): self
    {
        $getAsString = true;

        return new self(
            sprintf(
                self::COULD_CREATE_ENTITIES_MESSAGE_PATTERN,
                var_export($responseArray, $getAsString)
            )
        );
    }
}
