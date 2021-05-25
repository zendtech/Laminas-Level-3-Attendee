<?php
namespace IpCheck\Middleware;

/**
 * Sets the PHP default locale from HTTP headers
 */
use Application\Traits\ServiceManagerTrait;
use Interop\Http\ServerMiddleware\ {MiddlewareInterface,DelegateInterface};
use Psr\Http\Message\ {ServerRequestInterface, ResponseInterface};
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
class IpLog implements MiddlewareInterface
{
    use ServiceManagerTrait;
    const TABLE_NAME = 'access_log';
    protected $table;
    protected $adapter;
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->table = new TableGateway(self::TABLE_NAME, $adapter);
    }
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $data['ip_v4_address'] = $request->getServerParams()['REMOTE_ADDR'];
        $data['uri']           = $request->getUri()->__toString();
        $routeMatch = $request->getAttribute('Zend\Router\RouteMatch');
        $routeMatch->setParam(__CLASS__, $this->table->insert($data));
        return $delegate->process($request, $delegate);
    }
}
