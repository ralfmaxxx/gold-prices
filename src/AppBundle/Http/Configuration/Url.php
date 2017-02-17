<?php

namespace AppBundle\Http\Configuration;

class Url
{
    private const URL_PATTERN = '%s/%s';

    private $url;

    private function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function createFrom(Endpoint $endpoint, PathAndQuery $pathAndQuery): self
    {
        $url = sprintf(
            self::URL_PATTERN,
            $endpoint->get(),
            $pathAndQuery->get()
        );

        return new self($url);
    }

    public function get(): string
    {
        return $this->url;
    }
}
