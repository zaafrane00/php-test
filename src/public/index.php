<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FastRoute\Dispatcher;
use FastRoute\Factory;
use Whoops\Run;
use Whoops\Handler\JsonResponseHandler;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
// Load environment variables
$whoops = new Run();
$whoops->pushHandler(new JsonResponseHandler());
$whoops->register();

// this is the router
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/api/uuid', 'UuidController@generate');
    // {id} must be a number (\d+)
    $r->addRoute('POST', '/api/login', 'AuthController@login');
    // The /{title} suffix is optional
    $r->addRoute('GET', '/api/protected', 'AuthController@protectedData');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Strip query string (?foo=bar) and decode URI
switch ($dispatcher->dispatch($httpMethod, $uri)) {
    case Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        list($class, $method) = explode('@', $handler);
        (new $class())->$method();
        break;
    default:
        $handler = null;
        break;
}
