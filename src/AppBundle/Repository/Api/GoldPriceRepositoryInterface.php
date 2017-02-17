<?php

namespace AppBundle\Repository\Api;

use AppBundle\Entity\GoldPrice;
use AppBundle\Repository\Api\Exception\RepositoryException;
use AppBundle\Repository\Api\Parameter\TimeRangeParameter;

interface GoldPriceRepositoryInterface
{
    /**
     * @return GoldPrice[]
     * @throws RepositoryException
     */
    public function findAll(TimeRangeParameter $timeRangeParameter): array;
}
