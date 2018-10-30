<?php

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/../vendor/autoload.php';

### Initialization
$request = ServerRequestFactory::fromGlobals();


### Action
$name = $request->getQueryParams()['name'] ?? 'Guest';

$response = (new HtmlResponse('Hello, ' . $name . '!'))
    ->withHeader('X-developer', 'pavel02');


### Sending

header('HTTP/1.0 ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
foreach ($response->getHeaders() as $name => $values) {
    header($name . ':' . implode(', ', $values));
}

echo $response->getBody();