<?php
namespace Logging;

use Logging\Logger\Logging;
use Logging\Logger\Factory\ {LoggerFactory,ListenerFactory};
use Laminas\Log\Logger;
use Laminas\Mvc\ {MvcEvent};
use Laminas\ServiceManager\Proxy\LazyServiceFactory;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_ROUTE, [$this, 'setLogService'], 99);
    }

    public function setLogService(MvcEvent $e)
    {
        $logger = $e->getApplication()->getServiceManager()->get(Logging::class);
        Logger::registerErrorHandler($logger);
        Logger::registerExceptionHandler($logger);
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Logging::class => LoggerFactory::class,
                //*** DATABASE EVENTS LAB: inject database adapter platform into constructor for "logging-listener"
                Listener::class => ListenerFactory::class,
            ],
            'delegators' => [
                //*** LAZY SERVICES LAB: configure the Logging class as a lazy service
                //***                    NOTE: delegators must be assigned in the form of an array, even if only one!
            ],
            'lazy_services' => [
                'class_map' => [Logging::class => Logging::class],
                'proxies_target_dir' => __DIR__ . '/../../../data/proxy',
                'proxies_namespace' => 'LoggerProxy',
                'write_proxy_files' => TRUE,
            ],
        ];
    }

}
