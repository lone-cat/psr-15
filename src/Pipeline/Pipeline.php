<?php

namespace LoneCat\PSR15\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Pipeline
    implements MiddlewareInterface
{

    protected array $queue = [];
    protected MiddlewareResolverInterface $resolver;

    public function __construct(MiddlewareResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    public function middleware($middleware): self
    {
        $this->queue[] = $middleware;
        return $this;
    }

    public function process(ServerRequestInterface $request,
                            RequestHandlerInterface $handler): ResponseInterface
    {
        $queue = new MiddlewareQueue($this->queue, $handler, $this->resolver);
        return $queue->handle($request);
    }
}
