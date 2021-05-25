<?php
namespace Translation;

//*** TRANSLATION LAB: add an appropriate "use" statement for the listener aggregate

use Login\Form\Login as LoginForm;
use Interop\Container\ContainerInterface;

use Zend\Mvc\MvcEvent;
use Zend\Cache\StorageFactory;
use Zend\Cache\Storage\Adapter\Filesystem;

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
                //*** TRANSLATION LAB: define the listener aggregate as a service here
            ],
            'delegators' => [
                LoginForm::class => [Factory\AddLocale::class],
            ],
        ];
    }
}
