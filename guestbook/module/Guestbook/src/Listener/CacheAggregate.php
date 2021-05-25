<?php
namespace Guestbook\Listener;

use Guestbook\Controller\GuestbookController;

use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;

class CacheAggregate implements ListenerAggregateInterface
{

    protected $cacheAdapter;

    const EVENT_CLEAR_CACHE = 'guestbook-event-clear-cache';
    const OUTPUT_CACHE_KEY = 'guestbook-index-index';

    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH, [$this, 'getIndexViewFromCache'], 99);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_FINISH, [$this, 'storeIndexViewToCache'], 99);
        $this->listeners[] = $shared->attach('*', self::EVENT_CLEAR_CACHE, [$this, 'clearCache'], $priority);
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function clearCache($e)
    {
        $this->cacheAdapter->removeItem(self::OUTPUT_CACHE_KEY);
    }
    public function getIndexViewFromCache(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $controller = $routeMatch->getParam('controller');
        $action     = $routeMatch->getParam('action');
        if ($controller == GuestbookController::class && $action == 'index') {
            if ($this->cacheAdapter->hasItem(self::OUTPUT_CACHE_KEY)) {
                return $this->cacheAdapter->getItem(self::OUTPUT_CACHE_KEY);
            } else {
                $routeMatch->setParam('re-cache', TRUE);
            }
        }
    }
    public function storeIndexViewToCache(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        if ($routeMatch && $routeMatch->getParam('re-cache')) {
            $this->cacheAdapter->setItem(self::OUTPUT_CACHE_KEY, $e->getResponse());
        }
    }

    public function setCacheAdapter($adapter)
    {
        $this->cacheAdapter = $adapter;
        return $this;
    }
}
