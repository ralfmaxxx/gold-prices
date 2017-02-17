<?php

namespace AppBundle\Repository\ORM;

use AppBundle\Entity\GoldPrice;
use AppBundle\Repository\ORM\Exception\RepositoryException;
use DateTime;

interface GoldPriceRepositoryInterface
{
    /**
     * @throws RepositoryException
     */
    public function save(GoldPrice $goldPrice);

    public function findOneByDate(DateTime $date): ?GoldPrice;

    /**
     * @return GoldPrice[]
     */
    public function findAll(): array;
}
