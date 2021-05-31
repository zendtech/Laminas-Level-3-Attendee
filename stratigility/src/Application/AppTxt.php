<?php
namespace Application;
use Laminas\Diactoros\ResponseFactory;
use Psr\Http\Message\ {ResponseInterface,ServerRequestInterface};
use Psr\Http\Server\ {MiddlewareInterface,RequestHandlerInterface};
class AppTxt implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $out = '';
        $data = $request->getServerParams();
        foreach ($data as $key => $value)
            $out .= "$key : " . var_export($value, TRUE) . "\n";
        $response = (new ResponseFactory())->createResponse(200);
        $response->getBody()->write($out);
        return $response;
    }
}
