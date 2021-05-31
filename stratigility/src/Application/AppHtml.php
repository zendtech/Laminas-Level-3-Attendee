<?php
namespace Application;
use Laminas\Diactoros\ResponseFactory;
use Psr\Http\Message\ {ResponseInterface,ServerRequestInterface};
use Psr\Http\Server\ {MiddlewareInterface,RequestHandlerInterface};
class AppHtml implements MiddlewareInterface
{
    use CheckTrait;
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        if (!$this->check($request, APP_HTML)) return $handler->handle($request);
        $data = $request->getServerParams();
        $out = '<ul>';
        foreach ($data as $key => $value)
            $out .= "<li>$key : " . var_export($value, TRUE) . "</li>\n";
        $out .= '</ul>';
        $response = (new ResponseFactory())->createResponse(200);
        $response->getBody()->write($out);
        return $response;
    }
}
