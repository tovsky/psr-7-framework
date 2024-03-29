<?php

use App\Http\Action;
use App\Http\Middleware;
use Aura\Router\RouterContainer;
use Framework\Http\ActionResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

require __DIR__ . '/../vendor/autoload.php';

### Initialization

$params = [
    'users' => ['admin' => 'password'],
];

$aura = new RouterContainer();
$routes = $aura->getMap();

$routes->get('home', '/', Action\HelloAction::class);
$routes->get('about', '/about', Action\AboutAction::class);

$routes->get('cabinet', '/cabinet', function (ServerRequestInterface $request) use ($params) {
    $auth = new Middleware\BasicAuthMiddleware($params['users']);
    $cabinet = new Action\CabinetAction();

    return $auth($request, function (ServerRequestInterface $request) use ($cabinet) {
        return $cabinet($request);
    });
});

$routes->get('blog', '/blog', Action\Blog\IndexAction::class);
$routes->get('blog_show', '/blog/{id}', Action\Blog\ShowAction::class)->tokens(['id' => '\d+']);

$router = new AuraRouterAdapter($aura);
$resolver = new ActionResolver();

### Running

$request = ServerRequestFactory::fromGlobals();
try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $action = $resolver->resolve($result->getHandler());
    $response = $action($request);
} catch (RequestNotMatchedException $e){
    $response = new HtmlResponse('Undefined page', 404);
}

##Postprocessing
$response = $response->withHeader('X-developer', 'pavel02');


### Sending
$emitter = new SapiEmitter();
$emitter->emit($response);