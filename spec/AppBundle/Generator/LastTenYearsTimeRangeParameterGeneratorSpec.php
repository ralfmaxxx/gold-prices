<?php

namespace spec\AppBundle\Generator;

use AppBundle\Generator\GeneratorInterface;
use AppBundle\Generator\LastTenYearsTimeRangeParameterGenerator;
use AppBundle\Repository\Api\Parameter\TimeRangeParameter;
use DateTime;
use Generator;
use PhpSpec\ObjectBehavior;

/**
 * @mixin LastTenYearsTimeRangeParameterGenerator
 */
class LastTenYearsTimeRangeParameterGeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LastTenYearsTimeRangeParameterGenerator::class);
        $this->shouldImplement(GeneratorInterface::class);
    }

    function it_returns_time_range_paramater_collection_for_last_ten_years()
    {
        $this
            ->get()
            ->shouldYieldLike(
                $this->generateExpectedTimeRangeParameters()
            );
    }

    private function generateExpectedTimeRangeParameters(): array
    {
        $expectedTimeRangeParameters = [];

        $currentYear = date('Y');

        foreach (range($currentYear - 10, $currentYear) as $year) {
            $expectedTimeRangeParameters[] = new TimeRangeParameter(
                new DateTime(date("$year-m-d"))
            );
        }

        return $expectedTimeRangeParameters;
    }

    public function getMatchers(): array
    {
        return [
            'yieldLike' => function (Generator $returned, array $expected) {
                $key = 0;
                foreach ($returned as $timeRangeParameter) {
                    if ($timeRangeParameter != $expected[$key++]) {
                        return false;
                    }
                }
                return true;
            },
        ];
    }
}
