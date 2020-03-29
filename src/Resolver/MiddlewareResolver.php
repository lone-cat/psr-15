<?php

namespace LoneCat\PSR15\Resolver;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareResolver
    implements MiddlewareResolverInterface
{

    protected ?ContainerInterface $container = null;

    public function __construct(?ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function resolve($mw_identifier): MiddlewareInterface
    {
        if (is_callable($mw_identifier)) {
            throw new \Exception('callable middleware links will be added later!');
        }
        elseif (is_scalar($mw_identifier)) {
            if ($this->container && $this->container->has($mw_identifier)) {
                $middleware = $this->container->get($mw_identifier);
                if ($middleware instanceof MiddlewareInterface) return $middleware;
            }
        }

        throw new \Exception('Middleware cannot be resolved!');
    }
}