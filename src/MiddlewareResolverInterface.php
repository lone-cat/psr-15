<?php

namespace LoneCat\PSR15;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareResolverInterface
{

    public function resolve($middleware_id): MiddlewareInterface;

}