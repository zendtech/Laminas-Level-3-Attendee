<?php
namespace Application;
use Zend\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ {ResponseInterface,ServerRequestInterface};
use Psr\Http\Server\ {MiddlewareInterface,RequestHandlerInterface};
class Close implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        // "getParsedBody()" reads from $_POST
        $contents = $request->getParsedBody();
        $contents[] = '</body></html>';
        // contents of HTML response must be an HTML string
        return new HtmlResponse(implode(PHP_EOL, $contents));
    }
}