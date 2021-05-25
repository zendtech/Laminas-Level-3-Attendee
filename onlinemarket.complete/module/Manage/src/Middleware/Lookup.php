<?php
namespace Manage\Middleware;

use PDO;
//*** add the proper "use" statements
use Laminas\Diactoros\Response;
use Interop\Http\ServerMiddleware\ {MiddlewareInterface,DelegateInterface};
use Psr\Http\Message\ {ServerRequestInterface, ResponseInterface};

class Lookup implements MiddlewareInterface
{
    use TableTrait;
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $data = [];
        foreach ($this->table->select() as $obj) {
            $data[] = [$obj->email, $obj->provider];
        }
        $results = json_encode(['data' => $data]);
        //*** formulate a PSR-7 compliant response; hint: zend-diactoros
        $response = new Response();
        //*** write the results to the "body"
        $response->getBody()->write($results);
        //*** return the response, but don't forget to set the header!
        return $response->withHeader('Content-Type', 'application/json');
    }
}
