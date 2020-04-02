<?php

namespace LoneCat\PSR15\Pipeline;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MiddlewareQueue
    implements RequestHandlerInterface
{

    protected array $middleware_queue = [];
    protected RequestHandlerInterface $default_handler;
    protected ?MiddlewareResolverInterface $resolver = null;

    public function __construct(array $middleware_queue, RequestHandlerInterface $default_handler, ?MiddlewareResolverInterface $resolver = null)
    {
        $this->middleware_queue = $middleware_queue;
        $this->default_handler = $default_handler;
        $this->resolver = $resolver;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $current_middleware = array_shift($this->middleware_queue);
        if (is_null($current_middleware))
            return ($this->default_handler)->handle($request);

        $middleware = $this->getHandler($current_middleware);

        return $middleware->process($request, $this);
    }

    protected function getHandler($middleware): MiddlewareInterface
    {
        if ($middleware instanceof MiddlewareInterface) return $middleware;

        if (!$this->resolver) {
            throw new Exception('Class passed to pipeline is not middleware and cannot be resolved');
        }

        return $this->resolver->resolve($middleware);
    }

}