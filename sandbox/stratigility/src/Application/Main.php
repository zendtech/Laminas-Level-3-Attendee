<?php
namespace Application;
use Psr\Http\Message\ {ResponseInterface,ServerRequestInterface};
use Psr\Http\Server\ {MiddlewareInterface,RequestHandlerInterface};
class Main implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // "getParsedBody()" reads from $_POST
        $contents = $request->getParsedBody();
        $contents[] = '<h1>' . __CLASS__ . '</h1><hr>';
        $contents[] = '<pre>' . var_export($request->getServerParams(), TRUE) . '</pre>';
        return $handler->handle(
            $request->withParsedBody($contents)->withMethod('POST')
        );
    }
}