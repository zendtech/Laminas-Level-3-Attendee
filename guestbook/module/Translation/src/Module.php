<?php
namespace Translation;

use Translation\Listener\TranslationListenerAggregate;
use Laminas\Mvc\MvcEvent;
use Laminas\Cache\StorageFactory;
use Laminas\Cache\Storage\Adapter\Filesystem;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getModuleDependencies()
    {
        return ['Cache','Login'];
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                TranslationListenerAggregate::class => function ($container) {
                    $aggregate = new TranslationListenerAggregate();
                    $aggregate->setServiceManager($container);
                    return $aggregate;
                },
            ],
                
        ];
    }
}
