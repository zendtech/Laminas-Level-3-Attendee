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
                // define middleware classes as services
                Middleware\Log::class => function ($container) {
                    $class = new Middleware\Log();
                    $class->setTable($container->get('manage-access-table'));
                    return $class;
                },
                Middleware\Lookup::class => function ($container) {
                    $class = new Middleware\Lookup();
                    $class->setTable($container->get('manage-users-table'));
                    return $class;
                },
                // define database stuff
                'manage-db-adapter' => function ($container) {
                    return new Adapter($container->get('local-db-config'));
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
