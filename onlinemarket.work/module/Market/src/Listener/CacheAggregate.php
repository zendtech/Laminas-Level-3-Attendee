<?php
namespace Market\Listener;

use Market\Controller\MarketController;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\ {AbstractListenerAggregate,EventManagerInterface};
use Application\Traits\ServiceContainerTrait;

class CacheAggregate extends AbstractListenerAggregate
{

    const EVENT_CLEAR_CACHE = 'market-event-clear-cache';

    use ServiceContainerTrait;

    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH, [$this, 'getPageViewFromCache'], $priority);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_FINISH, [$this, 'storePageViewToCache'], $priority);
        $this->listeners[] = $shared->attach('*', self::EVENT_CLEAR_CACHE, [$this, 'clearCache'], $priority);
    }
    public function clearCache($e)
    {
        if ($cacheKey = $e->getParam('cacheKey')) {
            $cache = $this->serviceContainer->get('cache-adapter');
            $cache->removeItem($cacheKey);
            error_log('Removed: ' . $cacheKey);
        }
    }
    public function getPageViewFromCache(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $controller = $routeMatch->getParam('controller');
        if ($controller == 'Market\Controller\ViewController') {
            // matched route == market/view/category | market/view/item
            $cacheKey   = str_replace('/', '_', $routeMatch->getMatchedRouteName()) . '_';
            if ($itemId = $routeMatch->getParam('itemId')) {
                $cacheKey .= $itemId;
            } elseif ($category = $routeMatch->getParam('category')) {
                $cacheKey .= $category;
            }
            $cache = $this->serviceContainer->get('cache-adapter');
            if ($cache->hasItem($cacheKey)) {
                return $cache->getItem($cacheKey);
            } else {
                $routeMatch->setParam('re-cache', $cacheKey);
            }
        }
    }
    public function storePageViewToCache(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        if ($routeMatch && $cacheKey = $routeMatch->getParam('re-cache')) {
            $cache = $this->serviceContainer->get('cache-adapter');
            $cache->setItem($cacheKey, $e->getResponse());
            error_log('Cached: ' . $cacheKey);
        }
    }
}
