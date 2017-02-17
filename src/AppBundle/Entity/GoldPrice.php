<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ORM\GoldPriceRepository")
 */
class GoldPrice
{
    private const INVALID_DATA_MESSAGE_PATTERN = 'Data is invalid: "%s"';

    private const DATE_INDEX = 'data';

    private const PRICE_INDEX = 'cena';

    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(type="bigint", nullable=false)
     * @var int
     */
    private $price;

    /**
     * @ORM\Column(type="date", nullable=false, unique=true)
     * @var DateTime
     */
    private $date;

    private function __construct(int $price, DateTime $date)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->price = $price;
        $this->date = $date;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function from(array $data): self
    {
        if (self::isValid($data)) {
            $price = (int) number_format($data[self::PRICE_INDEX], 2, '', '');
            $date = new DateTime($data[self::DATE_INDEX]);

            return new self($price, $date);
        }

        $getAsString = true;

        throw new InvalidArgumentException(
            sprintf(self::INVALID_DATA_MESSAGE_PATTERN, var_export($data, $getAsString))
        );
    }

    private static function isValid(array $data): bool
    {
        return isset($data[self::PRICE_INDEX], $data[self::DATE_INDEX]);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }
}
