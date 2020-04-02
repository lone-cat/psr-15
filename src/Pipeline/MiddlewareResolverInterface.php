<?php

namespace LoneCat\PSR15\Pipeline;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareResolverInterface
{

    public function resolve($middleware): MiddlewareInterface;

}