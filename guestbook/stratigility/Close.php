<?php
namespace Test;

use Laminas\Diactoros\Response;
use Interop\Http\ServerMiddleware\ {MiddlewareInterface,DelegateInterface};
use Psr\Http\Message\ {ServerRequestInterface, ResponseInterface};

class Close implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $response = new Response();
        $contents = $request->getParsedBody() . '</body></html>';
        $response->getBody()->write($contents);
        return $response;
    }
}
