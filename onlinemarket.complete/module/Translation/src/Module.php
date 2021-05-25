<?php
namespace Translation;

//*** TRANSLATION LAB: add an appropriate "use" statement for the listener aggregate
use Translation\Factory\AddLocale;
use Translation\Listener\TranslationListenerAggregate;

use Login\Form\Login as LoginForm;
use Interop\Container\ContainerInterface;

use Zend\Mvc\MvcEvent;
use Zend\Cache\StorageFactory;
use Zend\Cache\Storage\Adapter\Filesystem;
use Zend\I18n\View\Helper\Translate;

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
                TranslationListenerAggregate::class => function ($container) {
                    return new TranslationListenerAggregate($container);
                },
            ],
            'delegators' => [
                LoginForm::class => [Factory\AddLocale::class],
            ],
        ];
    }
    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                Translate::class => function ($container) {
                    $helper = new Translate();
                    $helper->setTranslator($container->get('MvcTranslator'));
                    return $helper;
                },
            ],
            'aliases' => [
                'translate' => Translate::class,
            ],
        ];
    }
}
