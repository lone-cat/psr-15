<?php

namespace Tests\Pipeline;

use LoneCat\PSR15\Pipeline;
use PHPUnit\Framework\TestCase;




class PipelineTest extends TestCase
{
    public function testConstructor(): void
    {
        $pipeline = new Pipeline();
        //$pipeline->middleware('test');
        //$pipeline->middleware(function () {return true;});
        $response = $pipeline->process(new \LoneCat\PSR7\HTTP\Messages\ServerRequest('GET', '', []), new contr());
        self::assertEquals(1, 1);
    }

}