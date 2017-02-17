<?php

namespace AppBundle\Query;

interface QueryFunctionInterface
{
    public function __invoke(): array;
}
