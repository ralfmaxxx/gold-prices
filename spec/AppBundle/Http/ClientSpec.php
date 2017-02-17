<?php

namespace spec\AppBundle\Http;

use AppBundle\Http\Client;
use AppBundle\Http\ClientInterface;
use AppBundle\Http\Configuration\Endpoint;
use AppBundle\Http\Configuration\PathAndQuery;
use AppBundle\Http\Configuration\Response;
use AppBundle\Http\Exception\ClientException;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\TransferException;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @mixin Client
 */
class ClientSpec extends ObjectBehavior
{
    private const ENDPOINT = 'http://endpoint.com';

    private const PATH_AND_QUERY = 'prices?format=json';

    private const EXPECTED_URL = self::ENDPOINT . '/' . self::PATH_AND_QUERY;

    private const CONTENT = 'response content';

    private const EXCEPTION_MESSAGE = 'transfer error';

    private const EXCEPTION_CODE = 1;

    function let(GuzzleClientInterface $guzzleClient, Endpoint $endpoint)
    {
        $this->beConstructedWith($guzzleClient, $endpoint);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
        $this->shouldImplement(ClientInterface::class);
    }

    function it_returns_http_get_request(
        GuzzleClientInterface $guzzleClient,
        Endpoint $endpoint,
        PathAndQuery $pathAndQuery,
        ResponseInterface $response,
        StreamInterface $stream
    ) {
        $endpoint
            ->get()
            ->shouldBeCalled()
            ->willReturn(self::ENDPOINT);

        $pathAndQuery
            ->get()
            ->shouldBeCalled()
            ->willReturn(self::PATH_AND_QUERY);

        $response
            ->getBody()
            ->shouldBeCalled()
            ->willReturn($stream);

        $stream
            ->getContents()
            ->shouldBeCalled()
            ->willReturn(self::CONTENT);

        $guzzleClient
            ->request(
                ClientInterface::GET_REQUEST_METHOD,
                self::EXPECTED_URL
            )
            ->shouldBeCalled()
            ->willReturn($response);

        $this
            ->get($pathAndQuery)
            ->shouldBeLike(
                Response::createFrom($response->getWrappedObject())
            );
    }

    function it_throws_exception_when_guzzle_client_does_not_succeed(
        GuzzleClientInterface $guzzleClient,
        Endpoint $endpoint,
        PathAndQuery $pathAndQuery
    ) {
        $endpoint
            ->get()
            ->shouldBeCalled()
            ->willReturn(self::ENDPOINT);

        $pathAndQuery
            ->get()
            ->shouldBeCalled()
            ->willReturn(self::PATH_AND_QUERY);

        $transferException = new TransferException(self::EXCEPTION_MESSAGE, self::EXCEPTION_CODE);

        $guzzleClient
            ->request(
                ClientInterface::GET_REQUEST_METHOD,
                self::EXPECTED_URL
            )
            ->shouldBeCalled()
            ->willThrow($transferException);

        $this
            ->shouldThrow(ClientException::createFromPrevious($transferException))
            ->duringGet($pathAndQuery);
    }
}
