<?php
namespace Application\Event\Listener;
use Application\Event\AppEvent;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
class ErrorLogAggregate implements ListenerAggregateInterface
{
    public function attach(EventManagerInterface $e, $priority = 100)
    {
        $shared = $e->getSharedManager();
        $this->listeners[] = $shared->attach('*', AppEvent::EVENT_LOG, [$this, 'logMessage'], $priority);
    }
    public function detach(EventManagerInterface $e, $priority = 100)
    {
        // do nothing
    }
    public function logMessage($e)
    {
        $whoTriggered = get_class($e->getTarget());
        $optMessage   = $e->getParam('message') ?? 'No Message';
        error_log(__METHOD__ . ':' . $whoTriggered . ':' . $optMessage);
    }
}
