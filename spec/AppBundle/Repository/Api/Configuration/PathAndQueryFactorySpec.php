<?php

namespace spec\AppBundle\Repository\Api\Configuration;

use AppBundle\Http\Configuration\PathAndQuery;
use AppBundle\Repository\Api\COnfiguration\PathAndQueryFactory;
use AppBundle\Repository\Api\Parameter\TimeRangeParameter;
use PhpSpec\ObjectBehavior;

/**
 * @mixin PathAndQueryFactory
 */
class PathAndQueryFactorySpec extends ObjectBehavior
{
    private const START_DATE = '2017-01-01';

    private const END_DATE = '2017-01-11';

    private const EXPECTED_PATH = 'cenyzlota/' . self::START_DATE . '/' . self::END_DATE;

    private const EXPECTED_QUERY = 'format=json';

    function it_is_initializable()
    {
        $this->shouldHaveType(PathAndQueryFactory::class);
    }

    function it_creates_path_and_query_from_time_range_parameter(
        TimeRangeParameter $timeRangeParameter
    ) {
        $expectedPathAndQuery = new PathAndQuery(
            self::EXPECTED_PATH,
            self::EXPECTED_QUERY
        );

        $timeRangeParameter
            ->getFrom()
            ->shouldBeCalled()
            ->willReturn(self::START_DATE);

        $timeRangeParameter
            ->getTo()
            ->shouldBeCalled()
            ->willReturn(self::END_DATE);

        $this->createFrom($timeRangeParameter)->shouldBeLike($expectedPathAndQuery);
    }
}
