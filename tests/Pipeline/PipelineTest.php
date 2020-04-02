<?php

namespace Tests\Pipeline;

use LoneCat\PSR15\Pipeline\Pipeline;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use LoneCat\PSR15\Resolver\SimpleMiddlewareResolver;

class contr implements RequestHandlerInterface {

    public function handle(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
    {
        return new \LoneCat\PSR7\HTTP\Messages\Response(200);
    }
}

class middlw implements MiddlewareInterface {

    public function process(\Psr\Http\Message\ServerRequestInterface $request,
                            RequestHandlerInterface $handler): \Psr\Http\Message\ResponseInterface
    {
        $response = $handler->handle($request);
        return $response->withHeader('passed', 'ok');
    }
}

class cont implements ContainerInterface {

    protected $data = [];

    public function __construct()
    {
        $this->data['test'] = new middlw();
    }

    public function get($id)
    {
        return $this->data[$id];
    }

    public function has($id)
    {
        return \array_key_exists($id, $this->data);
    }
}

class HeadersTest extends TestCase
{
    public function testConstructor(): void
    {
        $resolver = new SimpleMiddlewareResolver();
        $pipeline = new Pipeline($resolver);
        $pipeline->middleware(new middlw);
        $pipeline->middleware('test');
        $pipeline->middleware(function () {return true;});
        $response = $pipeline->process(new \LoneCat\PSR7\HTTP\Messages\ServerRequest('GET', '', []), new contr());
        self::assertEquals($response->getHeader('passed'), ['ok']);
    }

}