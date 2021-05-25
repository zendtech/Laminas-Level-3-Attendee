<?php
namespace AccessControl\Listener;

use AccessControl\Acl\MarketAcl;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\ {AbstractListenerAggregate,EventManagerInterface};
use Zend\Permissions\Acl\Acl;

class AclListenerAggregate extends AbstractListenerAggregate
{

    protected $acl;
    protected $authService;

    const DEFAULT_ACTION     = 'index';
    const DEFAULT_CONTROLLER = 'Market\Controller\IndexController';

    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'injectAcl'], 2);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'checkAcl'], 999);
    }
    public function injectAcl(MvcEvent $e)
    {
        $layout = $e->getViewModel();
        $layout->setVariable('acl', $this->acl);
    }
    public function checkAcl(MvcEvent $e)
    {
        // pull resource and rights from route match
        $match = $e->getRouteMatch();
        $rights = $match->getParam('action');
        $resource = $match->getParam('controller');
        // get role
        $role = ($this->authService->hasIdentity())
              ? $this->authService->getIdentity()->getRole()
              : MarketAcl::DEFAULT_ROLE;
        $denied = TRUE;
        // make sure controller which is matched is in the list of resources
        if ($this->acl->hasResource($resource)) {
            if ($this->acl->hasRole($role)) {
                if ($this->acl->isAllowed($role, $resource, $rights)) {
                    $denied = FALSE;
                }
            }
        }
        // if denied and we're not already going home ...
        if ($denied && $resource != self::DEFAULT_CONTROLLER) {
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', '/');
            $response->setStatusCode(302);
            return $response;
        }
        // otherwise: do nothing
    }
    public function setAcl(Acl $acl)
    {
        $this->acl = $acl;
        return $this;
    }
    public function setAuthService(AuthenticationService $svc)
    {
        $this->authService = $svc;
        return $this;
    }
}
