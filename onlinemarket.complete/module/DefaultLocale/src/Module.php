<?php
namespace DefaultLocale;

use DefaultLocale\Middleware\Browser;
use Laminas\Mvc\MvcEvent;
//*** PSR7BRIDGE LAB: add the required "use" statements
use Psr\Http\Message\ResponseInterface;
use Laminas\Psr7Bridge\Psr7ServerRequest;
use Laminas\Psr7Bridge\Psr7Response;

class Module
{
    protected $container;
    public function onBootstrap(MvcEvent $e)
    {
        $app             = $e->getApplication();
        $eventManager    = $app->getEventManager();
        $this->container = $app->getServiceManager();
		//*** PSR7BRIDGE LAB: attach a listener which will dispatch DefaultLocale\Middleware\Browser *after* the Mvc "route" event
        $eventManager->attach(MvcEvent::EVENT_ROUTE, [$this, 'handleMiddleware'], -99);
    }
    public function handleMiddleware(MvcEvent $e)
    {
		//*** PSR7BRIDGE LAB: define PSR7 compliant request and response objects using Psr7Bridge classes
        $request  = Psr7ServerRequest::fromLaminas($e->getRequest());
        $response = Psr7Response::fromLaminas($e->getResponse());
        $done     = function ($request, $response) {};
        $result   = (new Browser())($request, $response, $done);
        if ($result) {
			//*** PSR7BRIDGE LAB: convert the PSR-7 response to a "native" Zend Framework response
            return Psr7Response::toLaminas($result);
        }
    }
}
