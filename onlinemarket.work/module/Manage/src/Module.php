<?php
namespace Manage;

use Login\Model\UsersTable;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getModuleDependencies()
    {
        return ['Login'];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                //*** MIDDLEWARE LAB: define middleware classes Manage\Middleware\ {Log,Lookup} as services
                Middleware\Log::class => function ($container) {
                    // ???
                },
                Middleware\Lookup::class => function ($container) {
                    // ???
                },
                // define database stuff
                'manage-db-adapter' => function ($container) {
                    return new Adapter($container->get('model-primary-adapter-config'));
                },
                'manage-access-table' => function ($container) {
                    return new TableGateway('access_log', $container->get('manage-db-adapter'));
                },
                'manage-users-table' => function ($container) {
                    return new TableGateway(UsersTable::$tableName, $container->get('manage-db-adapter'));
                },
            ]
        ];
    }
}
