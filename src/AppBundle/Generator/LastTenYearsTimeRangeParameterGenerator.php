<?php

namespace AppBundle\Generator;

use AppBundle\Repository\Api\Parameter\TimeRangeParameter;
use DateInterval;
use DateTime;
use Generator;

class LastTenYearsTimeRangeParameterGenerator implements GeneratorInterface
{
    private const START_IMPORT_DATE = '-10 years midnight';

    private const ONE_MONTH_PERIOD = 'P1Y';

    public function get(): Generator
    {
        $importDateStart = new DateTime(self::START_IMPORT_DATE);
        $now = new DateTime();

        while ($importDateStart < $now) {
            yield new TimeRangeParameter(clone $importDateStart);

            $importDateStart->add(new DateInterval(self::ONE_MONTH_PERIOD));
        }
    }
}
