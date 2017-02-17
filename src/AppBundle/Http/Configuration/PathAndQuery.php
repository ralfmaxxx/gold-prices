<?php

namespace AppBundle\Http\Configuration;

class PathAndQuery
{
    private const PATH_AND_QUERY_PATTERN = '%s?%s';

    private const EMPTY_STRING = '';

    private $path;

    private $query;

    public function __construct(string $path, string $query)
    {
        $this->path = $path;
        $this->query = $query;
    }

    public function get(): string
    {
        if ([$this->path, $this->query] == [self::EMPTY_STRING, self::EMPTY_STRING]) {
            return self::EMPTY_STRING;
        }

        return sprintf(self::PATH_AND_QUERY_PATTERN, $this->path, $this->query);
    }
}
