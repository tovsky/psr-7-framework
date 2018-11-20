<?php

namespace Test\App\Http\Action;

use App\Http\Action\AboutAction;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class AboutActionTest extends TestCase
{
    public function testSimpleAbout()
    {
        $action = new AboutAction();

        $request = new ServerRequest();
        $response = $action($request);

        self::assertEquals('I am a simple site', $response->getBody());
    }
}
