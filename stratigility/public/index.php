<?php
require __DIR__ . '/../vendor/autoload.php';

/**
 * Usage:
 *
 * CURL usage:
 *     curl -X GET -H "Accept: application/json" http://10.30.30.30/stratigility/api?source=[functions|classes]
 *     curl -X GET -H "Accept: text/html" http://10.30.30.30/stratigility/api?source=[functions|classes]
 */

// main classes and functions needed
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\MiddlewarePipe;

// NOTE: these are *functions* that provide convenient wrappers:
//       "middleware()" produces middleware from anonymous functions
//       "path()" adds routing and requires that you call "middleware()" as 2nd argument
use function Laminas\Stratigility\middleware;
use function Laminas\Stratigility\path;

$source = $_GET['source'] ?? 'functions';
$source = ($source === 'functions') ? 'functions' : 'classes';

// add middleware to the pipe
$pipeline = new MiddlewarePipe();
$middleware = include __DIR__ . '/../src/' . $source . '.php';
foreach ($middleware as $item)
    $pipeline->pipe(path('/stratigility/api', $item));

// add Not Found response
$notFound = function () {
    $response = (new ResponseFactory())->createResponse(404);
    $response->getBody()->write("Not Found\n");
    return $response;
};
$pipeline->pipe(new NotFoundHandler($notFound));

$server = new RequestHandlerRunner(
    $pipeline,
    new SapiEmitter(),
    static function () {
        return ServerRequestFactory::fromGlobals();
    },
    static function (\Throwable $e) {
        $response = (new ResponseFactory())->createResponse(500);
        $response->getBody()->write(sprintf(
            "An error occurred: %s\n",
            $e->getMessage
        ));
        return $response;
    }
);
$server->run();
