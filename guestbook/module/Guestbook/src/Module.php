<?php
namespace Guestbook;

use Laminas\Db\Adapter\Adapter;
use Laminas\Mvc\MvcEvent;
use Laminas\Db\TableGateway\Feature\EventFeatureEventsInterface;
use Laminas\Db\TableGateway\Feature\EventFeature\TableGatewayEvent;
use Guestbook\Mapper\Guestbook as Mapper;

class Module
{
    const VERSION = '3.0.3-dev';
    const AUDIT_FILE = __DIR__ . '/../../../data/logs/audit.log';
    
    public function onBootstrap(MvcEvent $e)
    {
        // configure TableGateway\Feature\EventFeature listener
        $container = $e->getApplication()->getServiceManager();
        $mapper    = $container->get(Mapper::class);
        $mapper->getEventManager()->attach(EventFeatureEventsInterface::EVENT_POST_INSERT, [$this, 'auditInsert']);
    }

    public function auditInsert(TableGatewayEvent $e)
    {
        $rows = $e->getParam('result')->count();
        $message = date('Y-m-d H:i:s') . ': Database Insert Was ';
        $message .= ($rows) ? '' : 'NOT';
        $message .= ' Successful : Rows Affected : ' . $rows . PHP_EOL;
        file_put_contents(self::AUDIT_FILE, $message, FILE_APPEND);
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'guestbook-db-adapter' => function ($container) {
                    return new Adapter($container->get('guestbook-db-config'));
                },
            ],
        ];                    
    }
}
