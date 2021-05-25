<?php
namespace Manage\Middleware;

use PDO;
//*** MIDDLEWARE LAB: add the proper "use" statements
use Interop\Http\ServerMiddleware\ {???};
use Psr\Http\Message\ {???};
use Laminas\Diactoros\???;

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
        //*** MIDDLEWARE LAB: formulate a PSR-7 compliant response; hint: zend-diactoros
        $response = ???;
        //*** write the results to the "body"
        $response->getBody()->write($results);
        //*** MIDDLEWARE LAB: return the response, but don't forget to set the header! (hint: look at the with* methods)
        return ???;
    }
}
