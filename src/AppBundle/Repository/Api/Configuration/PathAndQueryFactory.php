<?php

namespace AppBundle\Repository\Api\Configuration;

use AppBundle\Http\Configuration\PathAndQuery;
use AppBundle\Repository\Api\Parameter\TimeRangeParameter;

class PathAndQueryFactory
{
    private const PATH_PATTERN = 'cenyzlota/%s/%s';

    private const QUERY = 'format=json';

    public function createFrom(TimeRangeParameter $timeRangeParameter): PathAndQuery
    {
        $startDate = $timeRangeParameter->getFrom();
        $endDate = $timeRangeParameter->getTo();

        return new PathAndQuery(
            sprintf(self::PATH_PATTERN, $startDate, $endDate),
            self::QUERY
        );
    }
}
