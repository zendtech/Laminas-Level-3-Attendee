<?php
namespace Notification;

use Zend\Mvc\MvcEvent;
use Interop\Container\ContainerInterface;

class Module
{
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Listener\Aggregate::class => function (ContainerInterface $container, $requestedName, ?array $options = NULL)
                {
                    $aggregate = new $requestedName();
                    $aggregate->setServiceContainer($container);
                    return $aggregate;
                },
            ],
        ];
    }
}
