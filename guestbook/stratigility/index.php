<?php
use Zend\Stratigility\MiddlewarePipe;
use Zend\Stratigility\NoopFinalHandler;
use Zend\Diactoros\ {Server, Response};
use Test\ {Test, Open, Main, Close};

require __DIR__ . '/../vendor/autoload.php';

$app    = new MiddlewarePipe();
$app->setResponsePrototype(new Response());
$app->pipe('/main', new Open());
$app->pipe('/main', new Main());
$app->pipe('/main', new Close());
$app->pipe('/', new Test());
$server = Server::createServer($app, $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
$server->listen(new NoopFinalHandler());
