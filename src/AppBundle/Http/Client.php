<?php

namespace AppBundle\Http;

use AppBundle\Http\Configuration\Endpoint;
use AppBundle\Http\Configuration\PathAndQuery;
use AppBundle\Http\Configuration\Response;
use AppBundle\Http\Configuration\Url;
use AppBundle\Http\Exception\ClientException;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\TransferException;

class Client implements ClientInterface
{
    private $guzzleClient;

    private $endpoint;

    public function __construct(
        GuzzleClientInterface $guzzleClient,
        Endpoint $endpoint
    ) {
        $this->guzzleClient = $guzzleClient;
        $this->endpoint = $endpoint;
    }

    public function get(PathAndQuery $pathAndQuery): Response
    {
        $url = Url::createFrom($this->endpoint, $pathAndQuery);

        try {
            $response = $this->guzzleClient->request(
                self::GET_REQUEST_METHOD,
                $url->get()
            );
        } catch (TransferException $exception) {
            throw ClientException::createFromPrevious($exception);
        }

        return Response::createFrom($response);
    }
}
