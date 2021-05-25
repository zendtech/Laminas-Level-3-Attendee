<?php
namespace Application;
use Zend\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ {ResponseInterface,ServerRequestInterface};
use Psr\Http\Server\ {MiddlewareInterface,RequestHandlerInterface};
class Test implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $contents = '<!DOCTYPE html><html>'
                  . '<head><title>Test</title></head>'
                  . '<body><h1>Test</h1><hr>'
                  . '<a href="/main">TEST</a></body></html>';
        return new HtmlResponse($contents);
    }
}