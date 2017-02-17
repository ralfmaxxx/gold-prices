<?php

namespace spec\AppBundle\Http\Configuration;

use AppBundle\Http\Configuration\PathAndQuery;
use PhpSpec\ObjectBehavior;

/**
 * @mixin PathAndQuery
 */
class PathAndQuerySpec extends ObjectBehavior
{
    private const PATH = 'prices';

    private const QUERY = 'format=json';

    private const EXPECTED_PATH_AND_QUERY = self::PATH . '?' . self::QUERY;

    private const EMPTY_STRING = '';

    function let()
    {
        $this->beConstructedWith(self::PATH, self::QUERY);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PathAndQuery::class);
    }

    function it_returns_path_and_query_when_both_are_not_empty()
    {
        $this->get()->shouldReturn(self::EXPECTED_PATH_AND_QUERY);
    }

    function it_returns_path_and_query_when_both_are_empty()
    {
        $this->beConstructedWith(self::EMPTY_STRING, self::EMPTY_STRING);

        $this->get()->shouldReturn(self::EMPTY_STRING);
    }
}
