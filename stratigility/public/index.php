<?php
require __DIR__ . '/../vendor/autoload.php';

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
use Application\ {Test, Open, Main, Close};

// not found response
$notFound = function () { return new HtmlResponse('<h1>Not Found</h1>'); };
$pipeline = new MiddlewarePipe();
$pipeline->pipe(path('/main', new Open()));
$pipeline->pipe(path('/main', new Main()));
$pipeline->pipe(path('/main', new Close()));
$pipeline->pipe(path('/', new Test()));
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
            'An error occurred: %s',
            $e->getMessage
        ));
        return $response;
    }
);
$server->run();
