<?php
namespace AccessControl\Listener;

use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\Permissions\Acl\Acl;
use Laminas\Authentication\AuthenticationService;

class AclListenerAggregate implements ListenerAggregateInterface
{

    protected $acl;
    protected $authService;

    const DEFAULT_ACTION = 'index';
    const DEFAULT_CONTROLLER = 'Guestbook\Controller\GuestbookController';

    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'checkAcl'], 999);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH,  [$this, 'injectAcl'], 99);
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
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
        $role = 'guest';
        $rights = $match->getParam('action');
        $resource = $match->getParam('controller');
        // get role
        if ($this->authService->hasIdentity()) {
            $role = $this->authService->getIdentity()->getRole() ?? 'guest';
        }
        // make sure controller which is matched is in the list of resources
        $denied = TRUE;
        if ($this->acl->hasResource($resource)
            && $this->acl->hasRole($role)
            && $this->acl->isAllowed($role, $resource, $rights)) {
                    $denied = FALSE;
        }
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
