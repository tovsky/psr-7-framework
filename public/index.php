<?php

use Framework\Http\RequestFactory;

require __DIR__ . '/../vendor/autoload.php';

### Initialization
$request = RequestFactory::fromGlobals();


### Action
$name = $request->getQueryParams()['name'] ?? 'Guest';

header('X-developer: pavel02');

echo 'Hello, ' . $name . '!';