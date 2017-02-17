<?php

namespace spec\AppBundle\Http\Configuration;

use AppBundle\Http\Configuration\Endpoint;
use PhpSpec\ObjectBehavior;

/**
 * @mixin Endpoint
 */
class EndpointSpec extends ObjectBehavior
{
    private const URL = 'http://some-url.com';

    function let()
    {
        $this->beConstructedWith(self::URL);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Endpoint::class);
    }

    function it_has_url()
    {
        $this->get()->shouldReturn(self::URL);
    }
}
