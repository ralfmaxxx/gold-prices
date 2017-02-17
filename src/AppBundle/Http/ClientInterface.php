<?php

namespace AppBundle\Http;

use AppBundle\Http\Configuration\PathAndQuery;
use AppBundle\Http\Configuration\Response;
use AppBundle\Http\Exception\ClientException;

interface ClientInterface
{
    public const GET_REQUEST_METHOD = 'GET';

    /**
     * @throws ClientException
     */
    public function get(PathAndQuery $pathAndQuery): Response;
}
