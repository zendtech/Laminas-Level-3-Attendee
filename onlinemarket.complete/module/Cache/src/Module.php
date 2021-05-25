<?php
//*** CACHE LAB
namespace Cache;

use Laminas\Mvc\MvcEvent;
//*** add the appropriate "use" statements
use Laminas\Cache\StorageFactory;

class Module
{
    public function getServiceConfig()
    {
        return [
            'services' => [
                'cache-config' => [
                    'adapter' => [
                        //*** complete this configuration
                        'name'      => 'filesystem',
                        //*** make sure this directory exists and the PHP user can read/write
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
                    //*** what to return?
                    return StorageFactory::factory($container->get('cache-config'));
                },
            ],
        ];
    }
}
