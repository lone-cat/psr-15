<?php

namespace LoneCat\PSR15\Resolver;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareResolverInterface
{

    public function resolve($middleware): MiddlewareInterface;

}