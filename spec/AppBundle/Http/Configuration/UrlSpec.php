<?php

namespace spec\AppBundle\Http\Configuration;

use AppBundle\Http\Configuration\Endpoint;
use AppBundle\Http\Configuration\PathAndQuery;
use AppBundle\Http\Configuration\Url;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Url
 */
class UrlSpec extends ObjectBehavior
{
    private const ENDPOINT = 'http://api.endpoint.com';

    private const PATH_AND_QUERY = 'prices?format=json';

    private const EXPECTED_URL = self::ENDPOINT . '/' . self::PATH_AND_QUERY;

    function let(
        Endpoint $endpoint,
        PathAndQuery $pathAndQuery
    ) {
        $this->beConstructedThroughCreateFrom($endpoint, $pathAndQuery);

        $endpoint
            ->get()
            ->shouldBeCalled()
            ->willReturn(self::ENDPOINT);

        $pathAndQuery
            ->get()
            ->shouldBeCalled()
            ->willReturn(self::PATH_AND_QUERY);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Url::class);
    }

    function it_has_url()
    {
        $this->get()->shouldReturn(self::EXPECTED_URL);
    }
}
