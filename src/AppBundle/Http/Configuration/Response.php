<?php

namespace AppBundle\Http\Configuration;

use Psr\Http\Message\ResponseInterface;

class Response
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public static function createFrom(ResponseInterface $response)
    {
        return new self($response->getBody()->getContents());
    }

    public function get(): string
    {
        return $this->content;
    }
}
