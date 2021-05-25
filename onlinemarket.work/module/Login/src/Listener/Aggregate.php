<?php
namespace Login\Listener;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\ {AbstractListenerAggregate,EventManagerInterface};

class Aggregate extends AbstractListenerAggregate
{

    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH, [$this, 'injectAuthService']);
    }
    public function injectAuthService(MvcEvent $e)
    {
        $layout = $e->getViewModel();
        $sm = $e->getApplication()->getServiceManager();
        $authService = $sm->get('login-auth-service');
        $layout->setVariable('authService', $authService);
    }
}
