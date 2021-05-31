<?php
namespace Application;
use Laminas\Diactoros\ResponseFactory;
use Psr\Http\Message\ {ResponseInterface,ServerRequestInterface};
use Psr\Http\Server\ {MiddlewareInterface,RequestHandlerInterface};
class AppJson implements MiddlewareInterface
{
    use CheckTrait;
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        if (!$this->check($request, APP_JSON)) return $handler->handle($request);
        $data = $request->getServerParams();
        $response = (new ResponseFactory())->createResponse(200);
        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
        return $response;
    }
}
