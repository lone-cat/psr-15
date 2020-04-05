<?php

namespace Tests\Pipeline;

use LoneCat\PSR15\Pipeline\Pipeline;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use LoneCat\PSR15\Pipeline\SimpleMiddlewareResolver;


class PipelineTest extends TestCase
{
    public function testConstructor(): void
    {
        $resolver = new SimpleMiddlewareResolver();
        $pipeline = new Pipeline();
        //$pipeline->middleware('test');
        //$pipeline->middleware(function () {return true;});
        $response = $pipeline->process(new \LoneCat\PSR7\HTTP\Messages\ServerRequest('GET', '', []), new contr());
        self::assertEquals(1, 1);
    }

}