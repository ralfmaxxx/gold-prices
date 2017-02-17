<?php

namespace AppBundle\Http\Configuration;

class Endpoint
{
    private $endpoint;

    public function __construct(string $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function get(): string
    {
        return $this->endpoint;
    }
}
