<?php
namespace Application;
use Psr\Http\Message\ {ResponseInterface,ServerRequestInterface};
use Psr\Http\Server\ {MiddlewareInterface,RequestHandlerInterface};
class Open implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $contents[] = '<!DOCTYPE html><html><head><title>Test</title></head><body>';
        // you can pass "parsed body" using an HTTP POST
        return $handler->handle(
            $request->withParsedBody($contents)->withMethod('POST')
        );
    }
}