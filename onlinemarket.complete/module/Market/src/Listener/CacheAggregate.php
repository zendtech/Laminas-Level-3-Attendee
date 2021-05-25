<?php
//*** CACHE LAB
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
        //*** attach a series of listeners using the shared manager
        $shared = $e->getSharedManager();
        //*** attach a listener to get the page view from cache
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_DISPATCH, [$this, 'getPageViewFromCache'], $priority);
        //*** attach a listener which listens at the very end of the cycle and check to see if the "mustCache" param has been set
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_FINISH, [$this, 'storePageViewToCache'], $priority);
        //*** attach a listener to clear cache if EVENT_CLEAR_CACHE is triggered
        $this->listeners[] = $shared->attach('*', self::EVENT_CLEAR_CACHE, [$this, 'clearCache'], $priority);
    }
    public function clearCache($e)
    {
        //*** complete the logic for this method
        if ($cacheKey = $e->getParam('cacheKey')) {
            $cache = $this->serviceContainer->get('cache-adapter');
            $cache->removeItem($cacheKey);
            error_log('Removed: ' . $cacheKey);
        }
    }
    //*** configure this to check to see if the "ViewController" has been chosen
    //*** if so, check to see if the response object has been cached and return it
    //*** otherwise set a param "mustCache" to indicate this page view should be cached
    public function getPageViewFromCache(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $controller = $routeMatch->getParam('controller');
        //*** complete the logic for this method
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
        //*** complete the logic for this method
        $routeMatch = $e->getRouteMatch();
        if ($routeMatch && $cacheKey = $routeMatch->getParam('re-cache')) {
            $cache = $this->serviceContainer->get('cache-adapter');
            $cache->setItem($cacheKey, $e->getResponse());
            error_log('Cached: ' . $cacheKey);
        }
    }
}
