<?php
namespace Cache;

use Zend\Mvc\MvcEvent;
use Zend\Cache\StorageFactory;

class Module
{
    public function getServiceConfig()
    {
        return [
            'services' => [
                'cache-config' => [
                    'adapter' => [
                        'name'      => 'filesystem',
                        //*** make sure the PHP user can read/write this dir
                        'options'   => ['ttl' => 3600, 'cache_dir' => realpath(__DIR__ . '/../../../data/cache')],
                    ],
                    'plugins' => [
                        // override in /config/autoload/development.local.php
                        'exception_handler' => ['throw_exceptions' => FALSE],
                    ],
                ],
            ],
            'factories' => [
                'cache-adapter' => function ($container) {
                    return StorageFactory::factory($container->get('cache-config'));
                },
            ],
        ];
    }
}
