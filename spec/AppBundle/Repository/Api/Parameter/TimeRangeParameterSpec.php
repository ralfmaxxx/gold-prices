<?php

namespace spec\AppBundle\Repository\Api\Parameter;

use AppBundle\Repository\Api\Parameter\TimeRangeParameter;
use DateTime;
use PhpSpec\ObjectBehavior;

/**
 * @mixin TimeRangeParameter
 */
class TimeRangeParameterSpec extends ObjectBehavior
{
    private const FROM_DATE = '2016-01-01';

    private const TO_DATE = '2016-12-31';

    private const YEAR_2016 = '2016-02-01';

    private const CURRENT_YEAR = 'Y-01-01';

    private const CURRENT_DATE = 'Y-m-d';

    function let()
    {
        $this->beConstructedWith(new DateTime(self::YEAR_2016));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TimeRangeParameter::class);
    }

    function it_returns_first_day_of_the_year_as_from_date()
    {
        $this->getFrom()->shouldReturn(self::FROM_DATE);
    }

    function it_returns_last_day_of_the_year_as_to_date()
    {
        $this->getTo()->shouldReturn(self::TO_DATE);
    }

    function it_returns_current_day_as_to_date_when_it_is_current_year()
    {
        $this->beConstructedWith(new DateTime(date(self::CURRENT_YEAR)));

        $this->getTo()->shouldReturn(date(self::CURRENT_DATE));
    }
}
