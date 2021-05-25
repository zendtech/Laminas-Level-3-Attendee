<?php
namespace CommandLine;

use CommandLine\Listener\Aggregate;
use Events\TableModule\Model\ {EventTable, RegistrationTable};

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
                Listener\Aggregate::class => function ($container) {
                    $cache = $container->get('cache-adapter');
                    $config = $container->get('Config');
                    $consoleRouteConfig = $config['console']['router']['routes'] ?? [];
                    $aggregate = new Aggregate($consoleRouteConfig, $cache, $container);
                    return $aggregate;
                },
                Callbacks\Events::class => function ($container, $requestedName) {
                    return new $requestedName($container->get(EventTable::class),
                                              $container->get(RegistrationTable::class));
                },
            ],
        ];
    }
}
