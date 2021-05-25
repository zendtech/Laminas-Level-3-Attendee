<?php
namespace CommandLine\Listener;

use CommandLine\Generic\Constants;

use Zend\Mvc\MvcEvent;
use Zend\Console\Console;
use ZF\Console\ {RouteCollection, Dispatcher};
use Zend\EventManager\ {EventManagerInterface, AbstractListenerAggregate};
use Interop\Container\ContainerInterface;

class Aggregate extends AbstractListenerAggregate
{

    protected $collection = NULL;
    protected $dispatcher;
    protected $config;
    protected $cache;
    protected $container;

    public function __construct($config, $cache, ContainerInterface $container)
    {
        $this->config = $config;
        $this->cache = $cache;
        $this->container = $container;
    }
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        //*** attach a series of listeners using the shared manager
        $shared = $e->getSharedManager();
        //*** attach a listener before any routing occurs
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_ROUTE, [$this, 'clearCacheCheck'], 900);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_ROUTE, [$this, 'buildRoutes'],     800);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_ROUTE, [$this, 'buildDispatcher'], 700);
        $this->listeners[] = $shared->attach('*', MvcEvent::EVENT_ROUTE, [$this, 'handleRequest'],   600);
    }
    public function clearCacheCheck(MvcEvent $e)
    {
        // only handle non-HTTP requests
        if ($this->checkIfHttp($e->getRequest())) {
            // IMPORTANT: does NOT clear cache if a param has *changed* ... only if the number of entries is different
            // check to see if config array has changed size:
            $count = (int) $this->cache->getItem(Constants::CACHE_KEY_CONFIG);
            // --if so, clear cache
            if ($count !== count($this->config)) {
                $this->cache->setItem(Constants::CACHE_KEY_CONFIG, count($this->config));
                if ($this->cache->hasItem(Constants::CACHE_KEY_CLI)) {
                    $this->cache->removeItem(Constants::CACHE_KEY_CLI);
                }
            }
        }
    }
    public function buildRoutes(MvcEvent $e)
    {
        // only handle non-HTTP requests
        if ($this->checkIfHttp($e->getRequest())
            && !$this->collection = $this->cache->getItem(Constants::CACHE_KEY_CLI)) {
            // build route stack
            $this->collection = new RouteCollection();
            foreach ($this->config as $name => $entry) {
                if (!isset($entry['name'])) {
                    $entry['name'] = $name;
                }
                $this->collection->addRouteSpec($entry);
            }
            $this->cache->setItem(Constants::CACHE_KEY_CLI, $this->collection);
        }
    }
    public function buildDispatcher(MvcEvent $e)
    {
        // only handle non-HTTP requests
        if ($this->checkIfHttp($e->getRequest())) {
            // build route stack
            $this->dispatcher = new Dispatcher($e->getApplication()->getServiceManager());
            foreach ($this->config as $name => $entry) {
                if (isset($entry['handler'])) {
                    $this->dispatcher->map($name, $entry['handler']);
                }
            }
        }
    }
    public function handleRequest(MvcEvent $e)
    {
        if ($this->checkIfHttp($e->getRequest())) {
            // try to do a match
            $args = $e->getRequest()->getServer()['argv'];
            $args = array_slice($args, 1);
            if ($match = $this->collection->match($args)) {
                $this->dispatcher->dispatch($match, Console::getInstance());
            } else {
                die(Constants::ERROR_ROUTE_NOT_FOUND);
            }
            exit;
        }
    }
    protected function checkIfHttp($request)
    {
        return (strpos($request->getServer()['SERVER_PROTOCOL'], 'HTTP') === FALSE);
    }
}
