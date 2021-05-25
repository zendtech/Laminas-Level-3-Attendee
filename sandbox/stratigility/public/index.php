<?php
require __DIR__ . '/../vendor/autoload.php';

use Zend\Stratigility\MiddlewarePipe;
use Zend\Stratigility\Middleware\NotFoundHandler;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Server;  // NOTE: this is removed in zend-diactoros v2.x!
use Application\ {Test, Open, Main, Close};

// NOTE: these are *functions* which provide convient wrappers:
//       "middleware()" produces middleware from anonymous functions
//       "path()" adds routing and requires that you call "middleware()" as 2nd argument
use function Zend\Stratigility\path;

// not found response
$notFound = function () { return new HtmlResponse('<h1>Not Found</h1>'); };
$app = new MiddlewarePipe();
$app->pipe(path('/main', new Open()));
$app->pipe(path('/main', new Main()));
$app->pipe(path('/main', new Close()));
$app->pipe(path('/', new Test()));
$app->pipe(new NotFoundHandler($notFound));
$server = Server::createServer([$app, 'handle'], $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
$server->listen();