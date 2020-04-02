<?php

namespace LoneCat\PSR15\Resolver;

use Exception;
use Psr\Http\Server\MiddlewareInterface;

class SimpleMiddlewareResolver
    implements MiddlewareResolverInterface
{

    public function resolve($middleware): MiddlewareInterface
    {
        if (!($middleware instanceof MiddlewareInterface))
            throw new Exception('Invalid middleware passed!');

        return $middleware;
    }
}