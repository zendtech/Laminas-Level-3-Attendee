<?php
namespace IpCheck;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                // define middleware classes as services
                Middleware\IpLog::class => function ($container) {
                    $class = new Middleware\IpLog($container->get('ip-check-db-adapter'));
                    $class->setServiceManager($container);
                    return $class;
                },
                Middleware\IpBlock::class => function ($container) {
                    $class = new Middleware\IpBlock($container->get('ip-check-config'));
                    $class->setServiceManager($container);
                    return $class;
                },
                // define database stuff
                'ip-check-db-adapter' => function ($container) {
                    return new Adapter($container->get('local-db-config'));
                },
                'ip-check-block-table' => function ($container) {
                },
                'ip-check-access-table' => function ($container) {
                },
            ]
        ];
    }
}
