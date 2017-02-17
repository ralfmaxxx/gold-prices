<?php

namespace AppBundle\Repository\ORM\Exception;

use AppBundle\Entity\GoldPrice;
use RuntimeException;

class RepositoryException extends RuntimeException
{
    private const COULD_NOT_SAVE_MESSAGE_PATTERN = 'Could not save gold price with id "%s"';

    public static function couldNotSave(GoldPrice $goldPrice): self
    {
        return new self(
            sprintf(self::COULD_NOT_SAVE_MESSAGE_PATTERN, $goldPrice->getId())
        );
    }
}
