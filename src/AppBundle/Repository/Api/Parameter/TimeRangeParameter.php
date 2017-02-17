<?php

namespace AppBundle\Repository\Api\Parameter;

use DateTime;

class TimeRangeParameter
{
    private const FIRST_YEAR_DAY = 'Y-01-01';

    private const LAST_YEAR_DAY = 'Y-12-31';

    private const CURRENT_DAY = 'Y-m-d';

    private $month;

    public function __construct(DateTime $month)
    {
        $this->month = $month;
    }

    public function getFrom(): string
    {
        return $this->month->format(self::FIRST_YEAR_DAY);
    }

    public function getTo(): string
    {
        return $this->month->format('Y') == date('Y') ?
            date(self::CURRENT_DAY) :
            $this->month->format(self::LAST_YEAR_DAY);
    }
}
