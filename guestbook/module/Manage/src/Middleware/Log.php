<?php
namespace Manage\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

class Log implements MiddlewareInterface
{
    use TableTrait;
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $data['ip_v4_address'] = $request->getServerParams()['REMOTE_ADDR'] ?? 'Unknown';
        $data['uri']           = $request->getUri()->__toString();
        $routeMatch = $request->getAttribute('Zend\Router\RouteMatch');
        $routeMatch->setParam(__CLASS__, $this->table->insert($data));
        return $delegate->process($request, $delegate);
    }
}
