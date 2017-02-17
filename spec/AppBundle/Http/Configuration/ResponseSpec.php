<?php

namespace spec\AppBundle\Http\Configuration;

use AppBundle\Http\Configuration\Response;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @mixin Response
 */
class ResponseSpec extends ObjectBehavior
{
    private const CONTENT = 'some content';

    function let(
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $this->beConstructedThroughCreateFrom($response);

        $response
            ->getBody()
            ->shouldBeCalled()
            ->willReturn($stream);

        $stream
            ->getContents()
            ->shouldBeCalled()
            ->willReturn(self::CONTENT);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Response::class);
    }

    function it_has_response_content()
    {
        $this->get()->shouldReturn(self::CONTENT);
    }
}
