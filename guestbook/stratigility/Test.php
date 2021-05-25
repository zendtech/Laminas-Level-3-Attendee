<?php
namespace Test;

use Zend\Diactoros\Response;
use Interop\Http\ServerMiddleware\ {MiddlewareInterface,DelegateInterface};
use Psr\Http\Message\ {ServerRequestInterface, ResponseInterface};

class Test implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $contents = '<!DOCTYPE html><html><head><title>Test</title></head><body><h1>Test</h1><hr><a href="/main">TEST</a></body></html>';
        $response = new Response();
        $response->getBody()->write($contents);
        return $response;
    }
}
