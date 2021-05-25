<?php
//*** not sure how to get out of the pipe and back to MvcEvent::EVENT_DISPATCH
namespace IpCheck\Middleware;

use InvalidArgumentException;
use Application\Traits\ServiceManagerTrait;
use Interop\Http\ServerMiddleware\ {MiddlewareInterface,DelegateInterface};
use Psr\Http\Message\ {ServerRequestInterface, ResponseInterface};
use Zend\Mvc\MvcEvent;

class IpBlock implements MiddlewareInterface
{
    use ServiceManagerTrait;
    const ERROR_REDIRECT = 'ERROR: need to specify a "redirect" param with entries for "controller" and "action"';
    protected $blackList;
    protected $whiteList;
    public function __construct(array $config = [])
    {
        $this->blackList = $config['black-list'] ?? [];
        $this->whiteList = $config['white-list'] ?? [];
        if (empty($config['redirect']['controller'])) {
            throw new InvalidArgumentException(self::ERROR_REDIRECT);
        }
        $this->controller = $config['redirect']['controller'];
        $this->action     = $config['redirect']['action'] ?? 'index';
    }
    public function isValid($ipAddress)
    {
        $ok = FALSE;
        switch (TRUE) {
            case $this->whiteList && $this->blackList :
                if (in_array($ipAddress, $this->whiteList)) {
                    $ok = TRUE;
                }
                break;
            case $this->whiteList && !$this->blackList :
                if (in_array($ipAddress, $this->whiteList)) {
                    $ok = TRUE;
                }
                break;
            case !$this->whiteList && $this->blackList :
                if (in_array($ipAddress, $this->blackList)) {
                    $ok = FALSE;
                } else {
                    $ok = TRUE;
                }
                break;
            default:
                $ok = TRUE;
        }
        return $ok;
    }
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $ipAddr = $request->getServerParams()['REMOTE_ADDR'];
        $routeMatch = $request->getAttribute('Zend\Router\RouteMatch');

        if (!$this->isValid($ipAddr)) {
            $routeMatch->setParam('controller', self::DEFAULT_CONTROLLER);
            $routeMatch->setParam('action', self::DEFAULT_ACTION);
        }
        $delegate->process($request, $delegate);
        //*** how do I get back to the original request???
    }
}
