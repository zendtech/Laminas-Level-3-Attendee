<?php
namespace Manage\Middleware;

use PDO;
use Zend\Diactoros\Response;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

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
        $response = new Response();
        $response->getBody()->write($results);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
