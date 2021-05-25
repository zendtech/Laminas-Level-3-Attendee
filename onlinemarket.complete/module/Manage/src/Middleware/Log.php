<?php
namespace Manage\Middleware;

//*** add the proper "use" statements
use Interop\Http\ServerMiddleware\ {MiddlewareInterface,DelegateInterface};
use Psr\Http\Message\ {ServerRequestInterface, ResponseInterface};

class Log implements MiddlewareInterface
{
    use TableTrait;
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        //*** get the IP address and URI from $request
        $data['ip_v4_address'] = $request->getServerParams()['REMOTE_ADDR'];
        $data['uri']           = $request->getUri()->__toString();
        //*** optionally, set a routematch param which might be useful later
        $routeMatch = $request->getAttribute('Laminas\Router\RouteMatch');
        $routeMatch->setParam(__CLASS__, $this->table->insert($data));
        // use $delegate to move to the next middleware class in the pipe
        return $delegate->process($request, $delegate);
    }
}
