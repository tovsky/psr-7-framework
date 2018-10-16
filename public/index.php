<?php

use Framework\Http\Request;

require __DIR__ . '/../vendor/autoload.php';

### Initialization
$request = new Request();


### Action
$name = $request->getQueryParams()['name'] ?? 'Guest';

header('X-developer: pavel02');

echo 'Hello, ' . $name . '!';