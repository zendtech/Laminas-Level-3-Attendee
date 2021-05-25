<?php
namespace DefaultLocale;

use DefaultLocale\Middleware\Browser;
use Zend\Mvc\MvcEvent;
use Psr\Http\Message\ResponseInterface;
use Zend\Psr7Bridge\Psr7ServerRequest;
use Zend\Psr7Bridge\Psr7Response;

class Module
{
    protected $container;
    public function onBootstrap(MvcEvent $e)
    {
        $app             = $e->getApplication();
        $eventManager    = $app->getEventManager();
        $this->container = $app->getServiceManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [$this, 'handleMiddleware'], 2);
    }
    public function handleMiddleware(MvcEvent $e)
    {
        $request  = Psr7ServerRequest::fromZend($e->getRequest());
        $response = Psr7Response::fromZend($e->getResponse());
        $done     = function ($request, $response) {};
        $result   = (new Browser())($request, $response, $done);
        if ($result) {
            return Psr7Response::toZend($result);
        }
    }
}
