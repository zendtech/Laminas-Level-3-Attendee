<?php
namespace Test;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ {ServerRequestInterface, ResponseInterface};

class Main implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $contents = $request->getParsedBody()
                  . '<h1>' . __CLASS__ . '</h1>'
                  . '<hr>'
                  . '<pre>' . var_export($request->getServerParams(), TRUE) . '</pre>';
        return $delegate->process($request->withParsedBody($contents)->withMethod('POST'), $delegate);
    }
}
