<?php

use Zend\Diactoros\Response\HtmlResponse;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/../vendor/autoload.php';

### Initialization
$request = ServerRequestFactory::fromGlobals();


### Action

$path = $request->getUri()->getPath();

if ($path === '/') {
    $name = $request->getQueryParams()['name'] ?? 'Guest';
    $response = new HtmlResponse('Hello, ' . $name . '!');
} elseif ($path === '/about') {
    $response = new HtmlResponse('I am a simple site');
} else {
    $response = new HtmlResponse('Undefined page', 404);
}


##Postprocessing
$response = $response->withHeader('X-developer', 'pavel02');


### Sending
$emitter = new SapiEmitter();
$emitter->emit($response);