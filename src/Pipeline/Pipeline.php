<?php

namespace LoneCat\PSR15\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use LoneCat\PSR15\Resolver\MiddlewareResolver;
use LoneCat\PSR15\Resolver\MiddlewareResolverInterface;

class Pipeline
    implements MiddlewareInterface
{

    protected array $queue = [];
    protected ?MiddlewareResolverInterface $resolver = null;

    public function __construct(?MiddlewareResolverInterface $resolver = null)
    {
        $this->resolver = $resolver ?? new MiddlewareResolver();
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
        return $queue->handle($request->withAttribute('queue', $queue));
    }
}
