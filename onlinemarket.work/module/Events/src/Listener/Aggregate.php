<?php
namespace Events\Listener;

use Logging\Logger\Logging;
use Interop\Container\ContainerInterface;
use Laminas\EventManager\ {AbstractListenerAggregate,EventManagerInterface,LazyListener};

class Aggregate extends AbstractListenerAggregate
{

    protected $eventManager;
    protected $serviceContainer;

    public function __construct(ContainerInterface $container)
    {
        $this->serviceContainer = $container;
    }
    //*** attach "onLog()" as a listener to the modification event using a wildcard identifier
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        //*** LAZY LISTENER LAB: attach 'onLog' as a lazy listener
        $this->listeners[] = $shared->attach('*', Event::MOD_EVENT, [$this, 'onLog']);
    }
    public function onLog($e)
    {
        $logger = $this->serviceContainer->get(Logging::class);
        $logger->info(get_class($e->getTarget()) . ': REGISTRATION ADDED : ' . $e->getParam('registration'));
    }
}
