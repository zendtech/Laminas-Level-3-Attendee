<?php
namespace Application;
use Psr\Http\Message\ {ResponseInterface,ServerRequestInterface};
use Psr\Http\Server\ {MiddlewareInterface,RequestHandlerInterface};
class Log implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // "getHeaders()" reads from $_SERVER
        $headers = $request->getHeaders();
        error_log(__METHOD__ . ':' . var_export($headers, TRUE));
        return $handler->handle($request);
    }
}
