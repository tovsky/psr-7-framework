<?php

use Zend\Diactoros\Response\HtmlResponse;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/../vendor/autoload.php';

### Initialization
$request = ServerRequestFactory::fromGlobals();


### Action
$name = $request->getQueryParams()['name'] ?? 'Guest';
$response = new HtmlResponse('Hello, ' . $name . '!');


##Postprocessing
$response = $response->withHeader('X-developer', 'pavel02');


### Sending
$emitter = new SapiEmitter();
$emitter->emit($response);