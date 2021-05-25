<?php
namespace Model;

use Interop\Container\ContainerInterface;

//*** AGGREGATE HYDRATOR LAB: this is no longer needed
use Laminas\Hydrator\Reflection;

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
                //*** AGGREGATE HYDRATOR LAB: change this to the aggregate hydrator you created
                'model-listings-hydrator' => function (ContainerInterface $container, $requestedName, ?array $options = NULL)
                {
                    return new Reflection();
                },
            ],
        ];
    }
}
